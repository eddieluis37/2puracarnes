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
        $this->OrderById();

        return view('livewire.reports_sales_x_sc.component', [
            'inicio' => Sale::where('created_at', '>', '2024-04-01')
                ->orderBy('id', 'asc')->get(),
            'final' => Sale::where('created_at', '>', '2024-04-01')
                ->orderBy('id', 'desc')->get()
        ])->extends('layouts.theme.app')
            ->section('content');
    }

    public function OrderById()
    {

        $from = $this->userId1;
        $to = $this->userId2;

        $this->data = Sale::join('subcentrocostos as sc', 'sc.id', 'sales.subcentrocostos_id')
            ->leftjoin('users as u', 'u.id', 'sales.user_id')
            ->leftjoin('thirds as v', 'v.id', 'sales.vendedor_id')
            ->leftjoin('thirds as c', 'c.id', 'sales.third_id')
            ->select(
                'sc.name as subcentro',
                \DB::raw('count(sales.id) as total_ventas'),
                \DB::raw('(SELECT COALESCE(SUM(valor_total), 0) FROM notadebitos WHERE sales.id = notadebitos.sale_id) - 
                      (SELECT COALESCE(SUM(valor_total), 0) FROM notacreditos WHERE sales.id = notacreditos.sale_id) AS venta_real')
            )
            ->whereBetween('sales.id', [$from, $to])
            ->where('sales.status', '1')
            ->groupBy('sc.name')
            ->orderBy('sc.name')
            ->get();
    }

    /*  public function SalesByDate()
    {
        if ($this->reportType == 1) // ventas del dia
        {
            $from = $this->userId1;
            $to = $this->userId2;
        } else {
            $from = Carbon::parse($this->dateFrom)->format('Y-m-d') . ' 00:00:00';
            $to = Carbon::parse($this->dateTo)->format('Y-m-d')     . ' 23:59:59';
        }

        if ($this->reportType == 1 && ($this->dateFrom == '' || $this->dateTo == '')) {
            return;
        }

        if ($this->userId1 == 0) {
            $this->data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.*', 'u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->get();
        } else {
            $this->data = Sale::join('users as u', 'u.id', 'sales.user_id')
                ->select('sales.*', 'u.name as user')
                ->whereBetween('sales.created_at', [$from, $to])
                ->where('user_id', $this->userId1)
                ->get();
        }
    } */


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
