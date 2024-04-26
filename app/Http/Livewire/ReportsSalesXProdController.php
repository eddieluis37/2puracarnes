<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\User;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsSalesXProdController extends Component
{

    public $componentName, $data, $details, $sumDetails, $countDetails,
        $reportType, $IdInicial,  $IdFinal, $dateFrom, $dateTo, $saleId;

    public $results;
    public $totals;


    public function mount()
    {
        $this->componentName = 'Ventas por productos';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->IdInicial = 0;
        $this->IdFinal = 0;
        $this->saleId = 0;

        $this->dateFrom = Carbon::now()->setTime(0, 0, 0)->format('Y-m-d\TH:i');
        $this->dateTo = Carbon::now()->setTime(12, 0, 0)->format('Y-m-d\TH:i');
    }

    public function render()
    {
        /*   if ($this->IdInicial > 0 && $this->IdFinal > 0) {
            $this->SalesById($this->IdInicial, $this->IdFinal); // Llamar al método SalesById() con los Ids de ventas
        } else {
            $this->SalesByProducts(); // Llamar al método SalesByProducts() para obtener los resultados por fechas
        } */


        //   $this->SalesById($this->IdInicial, $this->IdFinal); // Llamar al método SalesById() con los Ids de ventas

        $this->SalesByProducts(); // Llamar al método SalesByProducts() para obtener los resultados por fechas


        return view('livewire.reports_sales_x_sc.component', [
            'inicio' => Sale::where('created_at', '>', '2024-04-01')->orderBy('id', 'asc')->get(),
            'final' => Sale::where('created_at', '>', '2024-04-01')->orderBy('id', 'desc')->get(),

            'dataById' => $this->data, // Resultados del método SalesById()
            'dataByDate' => $this->data, // Resultados del método SalesByProducts()
            'totalsById' => $this->totals, // Totales del método SalesById()
            'totalsByDate' => $this->totals, // Totales del método SalesByProducts()
        ])->extends('layouts.theme.app')
            ->section('content');
    }


    /*    public function SalesById($from = null, $to = null)
    {
        $query = Sale::with('subcentrocosto')
            ->select(
                'subcentrocostos.name as subcentro',
                DB::raw('COUNT(sales.id) as total_ventas'),
                DB::raw('SUM(COALESCE((SELECT SUM(valor_total) FROM notacreditos WHERE sales.id = notacreditos.sale_id), 0) - 
                COALESCE((SELECT SUM(valor_total) FROM notadebitos WHERE sales.id = notadebitos.sale_id), 0)) + 
                SUM(sales.total_bruto) as venta_real'),
                DB::raw('SUM(sales.descuentos) as descuentos'),
                DB::raw('(SUM(COALESCE((SELECT SUM(valor_total) FROM notacreditos WHERE sales.id = notacreditos.sale_id), 0) - 
                COALESCE((SELECT SUM(valor_total) FROM notadebitos WHERE sales.id = notadebitos.sale_id), 0)) + 
                SUM(sales.total_bruto) - SUM(sales.descuentos) + SUM(sales.total_otros_impuestos) +
                SUM(sales.total_iva) + SUM(sales.total_otros_impuestos)) as subtotal'),
                DB::raw('SUM(sales.total_iva) as impuesto_IVA'),
                DB::raw('SUM(sales.total_otros_impuestos) as impuesto_SALUDABLE'),
                DB::raw('SUM(sales.total_iva) + SUM(sales.total_otros_impuestos) as Total_Impuestos'),
                DB::raw('SUM(COALESCE((SELECT SUM(valor_total) FROM notacreditos WHERE sales.id = notacreditos.sale_id), 0) - 
                COALESCE((SELECT SUM(valor_total) FROM notadebitos WHERE sales.id = notadebitos.sale_id), 0)) + 
                SUM(sales.total_bruto) - SUM(sales.descuentos) + SUM(sales.total_otros_impuestos) +
                SUM(sales.total_iva) + SUM(sales.total_otros_impuestos) as Total')
            )
            ->join('subcentrocostos', 'subcentrocostos.id', '=', 'sales.subcentrocostos_id')
            ->where('sales.status', '1')
            ->groupBy('subcentrocostos.id', 'subcentrocostos.name')
            ->orderBy('subcentrocostos.name', 'ASC');

        if ($from && $to) {
            $query->whereBetween('sales.created_at', [$from, $to]);
        } else {
            $query->whereBetween('sales.id', [$this->IdInicial, $this->IdFinal]);
        }

        $this->results = $query->get();

        $this->data = $this->results;

        $this->totals = [
            'total_ventas' => $this->results->sum('total_ventas'),
            'venta_real' => $this->results->sum('venta_real'),
            'descuentos' => $this->results->sum('descuentos'),
            'subtotal' => $this->results->sum('subtotal'),
            'impuesto_IVA' => $this->results->sum('impuesto_IVA'),
            'impuesto_SALUDABLE' => $this->results->sum('impuesto_SALUDABLE'),
            'Total_Impuestos' => $this->results->sum('Total_Impuestos'),
            'Total' => $this->results->sum('Total'),
        ];
    } */

    public function SalesByProducts()
    {
        if ($this->reportType == 0) // ventas del dia
        {
            $from = Carbon::parse(Carbon::now())->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse(Carbon::now())->format('Y-m-d')   . ' 23:59:59';
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d H:i:s');
            $to = Carbon::parse($this->dateTo)->format('Y-m-d H:i:s');
        }

        $this->results = SaleDetail::with(['sale', 'product.category'])
            ->whereHas('sale', function ($query) use ($from, $to) {
                $query->whereBetween('created_at', [$from, $to])
                    ->where('status', '1');
            })
            ->select(
                'products.code as product_code',
                'products.name as product_name',
                'categories.name as category_name', // Agregar el nombre de la categoría
                DB::raw('SUM(sale_details.quantity) as total_sales'),
                DB::raw('SUM(sale_details.total_bruto) as total_bruto'),
                DB::raw('SUM(sale_details.descuento) as descuento_producto'),
                DB::raw('SUM(sale_details.descuento_cliente) as descuento_cliente'),
                DB::raw('SUM(sale_details.total) as total_amount')
            )
            ->join('products', 'products.id', '=', 'sale_details.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id') // Unir la tabla de categorías
            ->groupBy('products.id', 'products.name', 'categories.name') // Agrupar también por el nombre de la categoría
            ->orderBy('products.name', 'ASC')
            ->get();

        $this->data = $this->results;
        dd($this->data);

        // Calcular totales y asignarlos a $this->totals
        $this->totals = [
            'total_sales' => $this->results->sum('total_sales'),
            'total_subtotal' => $this->results->sum('total_subtotal'),
            'total_tax_amount' => $this->results->sum('total_tax_amount'),
            'total_amount' => $this->results->sum('total_amount'),
        ];
    }





    public function getDetails($saleId)
    {
        $this->details = SaleDetail::join('products as p', 'p.id', 'sale_details.product_id')
            ->select('sale_details.id', 'sale_details.price', 'sale_details.quantity', 'p.name as product')
            ->where('sale_details.sale_id', $saleId)
            ->get();


        //
        $suma = $this->details->sum(function ($item) {
            return $item->price * $item->quantity;
        });

        $this->sumDetails = $suma;
        $this->countDetails = $this->details->sum('quantity');
        $this->saleId = $saleId;

        $this->emit('show-modal', 'details loaded');
    }
}
