<?php

namespace App\Http\Controllers;

use App\Models\Sale;
use App\Models\SaleDetail;
use App\Models\Third;
use App\Models\Product;
use App\Models\centros\Centrocosto;
use Illuminate\Support\Facades\DB;

use Illuminate\Http\Request;

class SaleController extends Controller
{
    
    public function index()
    {
        $ventas = Sale::get();
        $centros = Centrocosto::Where('status', 1)->get();
        $clientes = Third::Where('cliente', 1)->get();
        $vendedores = Third::Where('vendedor', 1)->get();
        $domiciliarios = Third::Where('domiciliario', 1)->get();

        return view('sale.index',compact('centros','clientes','vendedores','domiciliarios','ventas'));
    }

    
    public function create($id)
    {
        $venta = Sale::find($id);
        $producto = Product::get();
        $ventasdetalle = $this->getventasdetalle($id,$venta->centrocosto_id);
        $arrayTotales = $this->sumTotales($id);
        

        return view('sale.create',compact('venta','ventasdetalle','arrayTotales','producto'));
    }

    public function create_reg_pago($id)
    {
        $venta = Sale::find($id);
        $producto = Product::get();
        $ventasdetalle = $this->getventasdetalle($id,$venta->centrocosto_id);
        $arrayTotales = $this->sumTotales($id);
        

        return view('sale.registrar_pago',compact('venta','ventasdetalle','arrayTotales','producto'));
    }

    
    public function store(Request $request)
    {
        $venta = new Sale();
        $idcc = $request->centrocosto;

        $venta->fecha_venta = $request->fecha_venta;
        $venta->centrocosto_id = $request->centrocosto;
        $venta->third_id = $request->cliente;
        $venta->vendedor_id = $request->vendedor;
        $venta->domiciliario_id = $request->domiciliario;
        $venta->user_id = $request->user()->id;
        
        $venta->total = 0;
        $venta->items = 0;
        $venta->cash = 0;
        $venta->change = 0;
        $venta->status = 0;
        
        $venta->save();

        //ACTUALIZA CONSECUTIVO 
        DB::update("
        UPDATE sales a,    
        (
            SELECT @numeroConsecutivo:= (SELECT (COALESCE (max(consec),0) ) FROM sales where centrocosto_id = :vcentrocosto1 ),
            @documento:= (SELECT MAX(prefijo) FROM centro_costo where id = :vcentrocosto2 )
        ) as tabla
        SET a.consecutivo =  CONCAT( @documento,  LPAD( (@numeroConsecutivo:=@numeroConsecutivo + 1),5,'0' ) ),
            a.consec = @numeroConsecutivo
        WHERE a.consecutivo is null",
           [               
               'vcentrocosto1' => $idcc,
               'vcentrocosto2' => $idcc
           ]
       );
       
       $ventasdetalle = $this->getventasdetalle($venta->id,$venta->centrocosto_id);
       $arrayTotales = $this->sumTotales($venta->id);
       $producto = Product::get();
       return view('sale.create',compact('venta','ventasdetalle','arrayTotales','producto'));
    }

    
    public function show(Pago $pago)
    {
    
    }

    
    public function edit($ventaId)
    {
        $venta = Sale::find($ventaId);
        return response()->json([
            'data' => $venta,
            'dataurl' => "/sale/$ventaId"
          ]);
    }

  
    public function update(Request $request, $ventaId)
    {
        $venta = Sale::find($ventaId);

        $venta->fecha_venta = $request->fecha2;
        $venta->centrocosto_id = $request->centrocosto2;
        $venta->third_id = $request->cliente2;
        $venta->vendedor_id = $request->vendedor2;
        $venta->domiciliario_id = $request->domiciliario2;
        
        $venta->save();

       return redirect()->back();
    }

    
    public function delete(Request $request, $ventaId)
    {
        $venta = Sale::find($ventaId);
        $venta->delete();
        return redirect()->back();
    }

    public function getventasdetalle($ventaId, $centrocostoId)
    {
        $detail = DB::table('sale_details as dv')
            ->join('products as pro', 'dv.product_id', '=', 'pro.id')
            ->join('centro_costo_products as ce', 'pro.id', '=', 'ce.products_id')
            ->select('dv.*', 'pro.name as nameprod', 'pro.code',  'ce.fisico')
            ->selectRaw('ce.invinicial + ce.compraLote + ce.alistamiento +
            ce.compensados + ce.trasladoing - (ce.venta + ce.trasladosal) stock')
            ->where([
                ['ce.centrocosto_id', $centrocostoId],                
                ['dv.sale_id', $ventaId],                
            ])->orderBy('dv.id','DESC')->get();

        return $detail;
    }

    public function sumTotales($id)
    {

        $kgTotalventa = (float)SaleDetail::Where([['sale_id', $id]])->sum('total');        

        $array = [
            'kgTotalventa' => $kgTotalventa,            
        ];

        return $array;
    }

    public function getproducts(Request $request)
    {
        $prod = Product::Where([        
            ['id', '1'],            
        ])->get();
        return response()->json(['products' => $prod]);
    }

    public function savedetail(Request $request)
    {
        try {            
            $detail = new SaleDetail();
            
            $total = $request->kgrequeridos * $request->precioventa; 
            $preciov = $request->precioventa * 1.0; 

            $detail->sale_id = $request->saleId;
            $detail->product_id =  $request->producto;
            $detail->price = $preciov;
            $detail->quantity = $request->kgrequeridos;
            $detail->porciva = 0;
            $detail->iva = 0;            
            $detail->total = $total ;
            $detail->save();            
            
             //ACTUALIZA VENTA 
                DB::update("
                UPDATE sales SET total = total + :totaldet
                WHERE id = :idventa",
                [               
                    'idventa' => $request->saleId,
                    'totaldet' =>  $total
                ]
            );

            $venta = Sale::find($request->saleId);            

            return response()->json([
                'status' => 1,
                'message' => "Agregado correctamente",
                'sale_id' => $detail->id,
                'product_id' => $detail->product->name,
                'price' => $preciov,
                'quantity' => $detail->quantity,
                'iva' => 0,
                'total' => $total,
                'totalsale' => $venta->total,
            ]);

        } catch (\Throwable $th) {
            return response()->json([
                'status' => 0,
                'message' => (array) $th
            ]);
        }
    }
    

}
