<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\Sale;


use Maatwebsite\Excel\Concerns\FromCollection;      // para trabajar con colecciones y obtener la data
use Maatwebsite\Excel\Concerns\WithHeadings;        // para definir los títulos de encabezado
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;   // para interactuar con el libro
use Maatwebsite\Excel\Concerns\WithCustomStartCell; // para definir la celda donde inicia el reporte
use Maatwebsite\Excel\Concerns\WithTitle;           // para colocar nombre a las hojas del libro
use Maatwebsite\Excel\Concerns\WithStyles;          // para dar formato a las celdas
use Carbon\Carbon;


class OrdersExport implements FromCollection, WithHeadings, WithCustomStartCell, WithTitle, WithStyles
{

    protected $IdFrom, $IdTo;
    function __construct($f1, $f2)
    {
        $this->IdFrom = $f1;
        $this->IdTo = $f2;
    }


    public function collection()
    {
        $data = [];

        $data = Order::join('users as u', 'u.id', 'orders.user_id')
            ->leftjoin('subcentrocostos as sc', 'sc.id', 'orders.subcentrocostos_id')
            ->leftjoin('thirds as v', 'v.id', 'orders.vendedor_id')
            ->leftjoin('thirds as c', 'c.id', 'orders.third_id')
            ->leftjoin('thirds as a', 'a.id', 'orders.alistador_id')
            ->select('orders.id', 'sc.name as subcentro', 'v.name as vendedor', 'c.name as cliente', 'c.identification', 'orders.direccion_envio', 'c.celular', 'orders.fecha_entrega', 'orders.hora_inicial_entrega', 'orders.hora_final_entrega', 'a.name as alistador', 'orders.observacion')
            ->whereBetween('orders.id', [$this->IdFrom, $this->IdTo])
            ->where('orders.status', '1')
            ->orderBy('id', 'desc')
            ->get();


        return $data;
    }

    //cabeceras del reporte
    public function headings(): array
    {
        return ["ID", "SUBCENTRO", "VENDEDOR", "CLIENTE", "IDENTIDAD", "DIR_ENTREGA", "TELEFONO", "FECHA_ENTREGA", "HORA_INICIAL", "HORA_FINAL", "HORA_FINAL", "ALISTADOR", "OBSERVACIONES"];
    }


    public function startCell(): string
    {
        return 'A1';
    }

    public function styles(Worksheet $sheet)
    {
        return [
            2 => ['font' => ['bold' => true]],
        ];
    }

    public function title(): string
    {
        return 'Consolidado Ordenes de Pedidos';
    }
}
