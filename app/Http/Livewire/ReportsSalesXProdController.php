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
       $this->SalesByProducts(); // Llamar al método SalesByProducts() para obtener los resultados por fechas

        return view('livewire.reports_sales_x_prod.component', [
            'inicio' => Sale::where('created_at', '>', '2024-04-01')->orderBy('id', 'asc')->get(),
            'final' => Sale::where('created_at', '>', '2024-04-01')->orderBy('id', 'desc')->get(),

            'dataById' => $this->data, // Resultados del método SalesById()
            'dataByDate' => $this->data, // Resultados del método SalesByProducts()
            'totalsById' => $this->totals, // Totales del método SalesById()
            'totalsByDate' => $this->totals, // Totales del método SalesByProducts()
        ])->extends('layouts.theme.app')
            ->section('content');
    }

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

        $this->results = SaleDetail::with(['sale', 'product.category', 'product.notacredito_details', 'product.notadebito_details'])
            ->whereHas('sale', function ($query) use ($from, $to) {
                $query->whereBetween('created_at', [$from, $to])
                    ->where('status', '1');
            })
            ->select(
                'products.code as product_code',
                'products.name as product_name',
                'categories.name as category_name',
                DB::raw('SUM(sale_details.quantity) as cantidad_venta'),
                'notacredito_details.quantity as notacredito_quantity',
                'notadebito_details.quantity as notadebito_quantity',
                DB::raw('(SUM(sale_details.quantity) + COALESCE(notadebito_details.quantity, 0)) - COALESCE(notacredito_details.quantity, 0) as cantidad_venta_real'),
                DB::raw('(SUM(sale_details.total_bruto) + COALESCE(notadebito_details.total_bruto, 0)) - COALESCE(notacredito_details.total_bruto, 0) as dinero_venta_real'),
                DB::raw('SUM(sale_details.descuento) as descuento_producto'),
                DB::raw('SUM(sale_details.descuento_cliente) as descuento_cliente'),
                DB::raw('(SUM(sale_details.total_bruto) + COALESCE(notadebito_details.total_bruto, 0)) - COALESCE(notacredito_details.total_bruto, 0) - SUM(sale_details.descuento) - SUM(sale_details.descuento_cliente) as sub_total'),
                DB::raw('SUM(sale_details.otro_impuesto) as impuesto_salud'),
                DB::raw('SUM(sale_details.iva) as iva'),
                DB::raw('(SUM(sale_details.total_bruto) + COALESCE(notadebito_details.total_bruto, 0)) - COALESCE(notacredito_details.total_bruto, 0) - SUM(sale_details.descuento) - SUM(sale_details.descuento_cliente) + SUM(sale_details.otro_impuesto) + SUM(sale_details.iva) as total'),
            )
            ->join('products', 'products.id', '=', 'sale_details.product_id')
            ->join('categories', 'categories.id', '=', 'products.category_id')
            ->leftjoin('notacredito_details', 'notacredito_details.product_id', '=', 'sale_details.product_id')
            ->leftjoin('notadebito_details', 'notadebito_details.product_id', '=', 'sale_details.product_id')
            ->groupBy('products.id', 'products.name', 'categories.name')
            ->orderBy('products.name', 'ASC')
            ->get();

        $this->data = $this->results;
        // dd($this->data);

        // Calcular totales y asignarlos a $this->totals
        $this->totals = [
            'cantidad_venta' => $this->results->sum('cantidad_venta'),
            'notacredito_quantity' => $this->results->sum('notacredito_quantity'),
            'notadebito_quantity' => $this->results->sum('notadebito_quantity'),
            'cantidad_venta_real' => $this->results->sum('cantidad_venta_real'),
            'dinero_venta_real' => $this->results->sum('dinero_venta_real'),
            'descuento_producto' => $this->results->sum('descuento_producto'),
            'descuento_cliente' => $this->results->sum('descuento_cliente'),
            'sub_total' => $this->results->sum('sub_total'),
            'impuesto_salud' => $this->results->sum('impuesto_salud'),
            'iva' => $this->results->sum('iva'),
            'total' => $this->results->sum('total'),
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
