<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Sale;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use Illuminate\Support\Collection;


use Maatwebsite\Excel\Concerns\FromCollection;      // para trabajar con colecciones y obtener la data
use Maatwebsite\Excel\Concerns\WithHeadings;        // para definir los títulos de encabezado
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;   // para interactuar con el libro
use Maatwebsite\Excel\Concerns\WithCustomStartCell; // para definir la celda donde inicia el reporte
use Maatwebsite\Excel\Concerns\WithTitle;           // para colocar nombre a las hojas del libro
use Maatwebsite\Excel\Concerns\WithStyles;          // para dar formato a las celdas
use Carbon\Carbon;

use Maatwebsite\Excel\Sheet;
use Maatwebsite\Excel\Concerns\WithEvents;
use Maatwebsite\Excel\Events\AfterSheet;


class ComprasXProdExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles, WithEvents
{

    protected $dateFrom;
    protected $dateTo;

    function __construct($f1, $f2)
    {
        $this->dateFrom = $f1;
        $this->dateTo = $f2;

        //  dd($this->dateFrom, $this->dateTo);

    }

    public function collection()
    {
        $data = [];

        $data = DB::select("
        SELECT
       /*  fecha_compra,
        factura_compra,
        nombre_proveedor, */
        product_code,
        product_name,
        category_name,
        SUM(cant_compras_lote) AS total_cant_compras_lote,
        SUM(costo_compras_lote) AS total_costo_compras_lote,
        SUM(cant_compras_comp) AS total_cant_compras_comp,
        SUM(precio_compras_comp) AS total_precio_compras_comp,
        SUM(subtotal_compras_comp) AS total_subtotal_compras_comp,
        SUM(cant_compras_lote) + SUM(cant_compras_comp) AS total_cantidades,
        SUM(costo_compras_lote) + SUM(subtotal_compras_comp) AS total_costo,
        (SUM(costo_compras_lote) + SUM(subtotal_compras_comp)) / (SUM(cant_compras_lote) + SUM(cant_compras_comp)) AS costo_promedio
    FROM
    (
        -- Primera consulta
        SELECT
            fecha_compra,
            factura_compra,
            nombre_proveedor,
            product_code,
            product_name,
            category_name,
            cant_compras_lote,
            costo_compras_lote,
            cant_compras_comp,
            precio_compras_comp,
            subtotal_compras_comp
        FROM
        (
            -- Consulta 1
            SELECT
                beneficiores.fecha_beneficio as fecha_compra,
                beneficiores.factura as factura_compra,
                COALESCE(beneficiores_third.name) as nombre_proveedor,  
                P.code as product_code,
                P.name as product_name,
                categories.name as category_name,       
                desposteres.peso as cant_compras_lote,  
                COALESCE(desposteres.costo, 0) as costo_compras_lote,  
                '0' as cant_compras_comp,
                '0' as precio_compras_comp,
                '0' as subtotal_compras_comp
            FROM beneficiores
            LEFT JOIN desposteres ON beneficiores.id = desposteres.beneficiores_id
            LEFT JOIN products AS P ON desposteres.products_id = P.id
            LEFT JOIN categories ON categories.id = P.category_id
            LEFT JOIN thirds AS beneficiores_third ON beneficiores.thirds_id = beneficiores_third.id
            WHERE (desposteres.beneficiores_id IS NOT NULL)
            AND (beneficiores.fecha_beneficio BETWEEN '$this->dateFrom' AND '$this->dateTo' OR beneficiores.fecha_beneficio IS NULL)
            
            UNION ALL
            
            -- Consulta 2
            SELECT
                beneficiocerdos.fecha_beneficio as fecha_compra,
                beneficiocerdos.factura as factura_compra,
                COALESCE(beneficiocerdos_third.name) as nombre_proveedor,    
                products.code as product_code,
                products.name as product_name,
                categories.name as category_name,       
                despostecerdos.peso as cant_compras_lote,  
                COALESCE(despostecerdos.costo, 0) as costo_compras_lote,
                '0' as cant_compras_comp,
                '0' as precio_compras_comp,
                '0' as subtotal_compras_comp
            FROM beneficiocerdos
            LEFT JOIN despostecerdos ON beneficiocerdos.id = despostecerdos.beneficiocerdos_id
            LEFT JOIN products ON despostecerdos.products_id = products.id
            LEFT JOIN categories ON categories.id = products.category_id
            LEFT JOIN thirds AS beneficiocerdos_third ON beneficiocerdos.thirds_id = beneficiocerdos_third.id
            WHERE (despostecerdos.beneficiocerdos_id IS NOT NULL)
            AND (beneficiocerdos.fecha_beneficio BETWEEN '$this->dateFrom' AND '$this->dateTo' OR beneficiocerdos.fecha_beneficio IS NULL)
            
            UNION ALL
            
            -- Consulta 3
            SELECT
                compensadores.fecha_compensado as fecha_compra,
                compensadores.factura as factura_compra,
                COALESCE(compensandores_third.name) as nombre_proveedor,  
                products.code as product_code,
                products.name as product_name,
                categories.name as category_name,       
                '0' as cant_compras_lote,
                '0' as costo_compras_lote,
                compensadores_details.peso as cant_compras_comp,  
                compensadores_details.pcompra as precio_compras_comp,
                compensadores_details.subtotal as subtotal_compras_comp
            FROM compensadores
            LEFT JOIN compensadores_details ON compensadores.id = compensadores_details.compensadores_id
            LEFT JOIN products ON compensadores_details.products_id = products.id
            LEFT JOIN categories ON categories.id = products.category_id
            LEFT JOIN thirds AS compensandores_third ON compensadores.thirds_id = compensandores_third.id
            WHERE (compensadores_details.compensadores_id IS NOT NULL)
            AND (compensadores.fecha_compensado BETWEEN '$this->dateFrom' AND '$this->dateTo' OR compensadores.fecha_compensado IS NULL)
        ) AS combined_data
    ) AS final_data
    GROUP BY product_code, product_name
        ");

        // Convertir el array de resultados en una colección
        $collection = new Collection($data);

        return $collection;
    }

    //cabeceras del reporte
    public function headings(): array
    {
        return ["COD", "PRODUCTOS", "CATEGORIA", "COMPRA_LOTE", "COSTO_COMPRA_LOTE", "CANTIDAD_COMPENSADA", "PRECIO_COMPRA_COMPENSADA", "SUBTOTAL_COMPRA_COMPENSADA", "TOTAL_CANTIDADES", "TOTAL_COSTO", "COSTO_PROMEDIO"];
    }


    public function startCell(): string
    {
        return 'A2';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Reporte de compras por productos';
    }

    public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $event->sheet->getDelegate()->getColumnDimension('A')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('B')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('C')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('D')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('E')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('F')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('G')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('H')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('I')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('J')->setAutoSize(true);
                $event->sheet->getDelegate()->getColumnDimension('K')->setAutoSize(true);

                // Ajustar automáticamente el tamaño de todas las columnas
                //      $event->sheet->getDelegate()->getDelegate()->getDelegate()->calculateColumnWidths();

                // Agrega la funcion autosuma a la columnas
                /*   $event->sheet->getDelegate()->setCellValue('K' . ($event->sheet->getDelegate()->getHighestRow() + 1), '=SUM(K2:K' . $event->sheet->getDelegate()->getHighestRow() . ')');
                
                $event->sheet->getDelegate()->setCellValue('J' . ($event->sheet->getDelegate()->getHighestRow() + 1), '=SUM(J2:J' . $event->sheet->getDelegate()->getHighestRow() . ')');
                $event->sheet->getDelegate()->setCellValue('I' . ($event->sheet->getDelegate()->getHighestRow() + 1), '=SUM(I2:I' . $event->sheet->getDelegate()->getHighestRow() . ')');
                $event->sheet->getDelegate()->setCellValue('H' . ($event->sheet->getDelegate()->getHighestRow() + 1), '=SUM(H2:H' . $event->sheet->getDelegate()->getHighestRow() . ')');           
                $event->sheet->getDelegate()->setCellValue('G' . ($event->sheet->getDelegate()->getHighestRow() + 1), '=SUM(G2:G' . $event->sheet->getDelegate()->getHighestRow() . ')');
                $event->sheet->getDelegate()->setCellValue('F' . ($event->sheet->getDelegate()->getHighestRow() + 1), '=SUM(F2:F' . $event->sheet->getDelegate()->getHighestRow() . ')');
                $event->sheet->getDelegate()->setCellValue('E' . ($event->sheet->getDelegate()->getHighestRow() + 1), '=SUM(E2:E' . $event->sheet->getDelegate()->getHighestRow() . ')');
             */
                $event->sheet->getDelegate()->setCellValue('D' . ($event->sheet->getDelegate()->getHighestRow() + 1), '=SUM(D2:D' . $event->sheet->getDelegate()->getHighestRow() . ')');
                $event->sheet->getDelegate()->getStyle('D')->getNumberFormat()->setFormatCode('#,##0.00');
                $event->sheet->getDelegate()->getStyle('E')->getNumberFormat()->setFormatCode('#,##0.00');
                $event->sheet->getDelegate()->getStyle('F')->getNumberFormat()->setFormatCode('#,##0.00');
                $event->sheet->getDelegate()->getStyle('G')->getNumberFormat()->setFormatCode('#,##0.00');
                $event->sheet->getDelegate()->getStyle('H')->getNumberFormat()->setFormatCode('#,##0.00');
                $event->sheet->getDelegate()->getStyle('I')->getNumberFormat()->setFormatCode('#,##0.00');
                $event->sheet->getDelegate()->getStyle('J')->getNumberFormat()->setFormatCode('#,##0.00');
                $event->sheet->getDelegate()->getStyle('K')->getNumberFormat()->setFormatCode('#,##0.00');
            },
        ];
    }

    /* public function registerEvents(): array
    {
        return [
            AfterSheet::class => function (AfterSheet $event) {
                $columns = range('D', 'K');

                foreach ($columns as $column) {
                    $event->sheet->getDelegate()->getColumnDimension($column)->setAutoSize(true);

                    $lastRow = $event->sheet->getDelegate()->getHighestRow();
                    $event->sheet->getDelegate()->setCellValue($column . ($lastRow + 1), "=SUM($column:$column$lastRow)");
                    $event->sheet->getDelegate()->getStyle($column)->getNumberFormat()->setFormatCode('#,##0.00');
                }
            },
        ];
    } */
}
