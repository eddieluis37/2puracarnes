<?php

namespace App\Http\Livewire;

use App\Models\Order;
use Livewire\Component;
use App\Models\User;
use App\Models\Sale;
use App\Models\SaleDetail;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;

class ReportsSalesXsCController extends Component
{

    public $componentName, $data, $details, $sumDetails, $countDetails,
        $reportType, $userId1,  $userId2, $dateFrom, $dateTo, $saleId;

    public $results;
    public $totals;


    public function mount()
    {
        $this->componentName = 'Ventas por sub-centro de costo';
        $this->data = [];
        $this->details = [];
        $this->sumDetails = 0;
        $this->countDetails = 0;
        $this->reportType = 0;
        $this->userId1 = 0;
        $this->userId2 = 0;
        $this->saleId = 0;
    }

    public function render()
    {
        $this->SalesById();

        return view('livewire.reports_sales_x_sc.component', [
            'inicio' => Sale::where('created_at', '>', '2024-04-01')
                ->orderBy('id', 'asc')->get(),
            'final' => Sale::where('created_at', '>', '2024-04-01')
                ->orderBy('id', 'desc')->get()
        ])->extends('layouts.theme.app')
            ->section('content');

        return view('livewire.reports_sales_x_sc.component');
    }


    public function SalesById()
    {
        $from = $this->userId1;
        $to = $this->userId2;
        $this->results = Sale::with('subcentrocosto')
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
            ->whereBetween('sales.id', [$from, $to])
            ->where('sales.status', '1')
            ->groupBy('subcentrocostos.id', 'subcentrocostos.name')
            ->orderBy('subcentrocostos.name', 'ASC')
            ->get();

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
