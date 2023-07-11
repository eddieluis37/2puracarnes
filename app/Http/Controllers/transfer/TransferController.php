<?php

namespace App\Http\Controllers\transfer;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\centros\Centrocosto;
use App\Models\alistamiento\Alistamiento;
use Illuminate\Http\Request;
use App\Models\Centro_costo_product;
use App\Models\Product;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;
use App\Models\Products\Meatcut;
use App\Http\Controllers\metodosgenerales\metodosrogercodeController;
use App\Models\shopping\shopping_enlistment;
use App\Models\shopping\shopping_enlistment_details;



 class TransferController extends Controller
{
    public function index()
    {
        $category = Category::WhereIn('id',[1,2,3])->get();
        $centros = Centrocosto::Where('status',1)->get();        
        $centroCostoProductos = Centro_costo_product::all();
      //  $products = Product::pluck('name', 'id');
       /*  $dataAlistamiento = DB::table('enlistments as ali')
        ->join('categories as cat', 'ali.categoria_id', '=', 'cat.id')
        ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
        ->select('ali.*', 'cat.name as namecategoria','centro.name as namecentrocosto')
        ->where('ali.id', $id)
        ->get(); */

         return view("transfer.index", compact('category', 'centros', 'centroCostoProductos'));
    }


     public function store(Request $request)
    {
        // Validar los datos del formulario de transferencia
        $request->validate([
            'from_cost_center_id' => 'required',
            'to_cost_center_id' => 'required',
            'product_id' => 'required',
            'quantity' => 'required|numeric|min:1',
        ]);
         // Obtener los datos del formulario
        $fromCostCenterId = $request->input('from_cost_center_id');
        $toCostCenterId = $request->input('to_cost_center_id');
        $productId = $request->input('product_id');
        $quantity = $request->input('quantity');
         // Realizar la transferencia de productos
        // Aquí debes implementar la lógica para transferir los productos de un centro de costo a otro
        // Puedes utilizar los IDs de los centros de costo y del producto para realizar las consultas necesarias
         // Redirigir a la página de transferencia con un mensaje de éxito
        return redirect()->route('transfer.index')->with('success', 'La transferencia de productos se ha realizado con éxito.');
    }

    public function show()
    {
        $data = DB::table('enlistments as ali')
        ->join('categories as cat', 'ali.categoria_id', '=', 'cat.id')
        ->join('meatcuts as cut', 'ali.meatcut_id', '=', 'cut.id')
        ->join('centro_costo as centro', 'ali.centrocosto_id', '=', 'centro.id')
        ->select('ali.*', 'cat.name as namecategoria','centro.name as namecentrocosto', 'cut.name as namecut')
        ->where('ali.status', 1)
        ->get();
        //$data = Compensadores::orderBy('id','desc');
        return Datatables::of($data)->addIndexColumn()
            ->addColumn('date', function($data){
                $date = Carbon::parse($data->fecha_alistamiento);
                    $onlyDate = $date->toDateString();
                return $onlyDate;
            })
            ->addColumn('inventory', function($data){
                if ($data->inventario == 'pending') {
                    $statusInventory = '<span class="badge bg-warning">Pendiente</span>';
                }else{
                    $statusInventory= '<span class="badge bg-success">Agregado</span>';
                }
                return $statusInventory;
            })
            ->addColumn('action', function($data){
                $currentDateTime = Carbon::now();
                if (Carbon::parse($currentDateTime->format('Y-m-d'))->gt(Carbon::parse($data->fecha_cierre))) {
                    $btn = '
                    <div class="text-center">
					<a href="alistamiento/create/'.$data->id.'" class="btn btn-dark" title="Alistar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="" onclick="showDataForm('.$data->id.')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="" disabled>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                }elseif (Carbon::parse($currentDateTime->format('Y-m-d'))->lt(Carbon::parse($data->fecha_cierre))) {
                    $status = '';
                    if ($data->inventario == 'added') {
                        $status = 'disabled';
                    }
                    $btn = '
                    <div class="text-center">
					<a href="alistamiento/create/'.$data->id.'" class="btn btn-dark" title="Alistar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="" onclick="showDataForm('.$data->id.')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="Borrar Beneficio" onclick="downAlistamiento('.$data->id.');" '.$status.'>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                }else{
                    $btn = '
                    <div class="text-center">
					<a href="alistamiento/create/'.$data->id.'" class="btn btn-dark" title="Alistar" >
						<i class="fas fa-directions"></i>
					</a>
					<button class="btn btn-dark" title="" onclick="showDataForm('.$data->id.')">
						<i class="fas fa-eye"></i>
					</button>
					<button class="btn btn-dark" title="" disabled>
						<i class="fas fa-trash"></i>
					</button>
                    </div>
                    ';
                }
                return $btn;
            })
            ->rawColumns(['date','inventory','action'])
            ->make(true);
    }

    public function getProductsCategoryPadre(Request $request){
        $cortes = Meatcut::Where([
            ['category_id',$request->categoriaId],
            ['status',1]
        ])->get();
        return response()->json(['products' => $cortes]);
    }

    public function getproducts(Request $request)
    {
        $prod = Product::Where([
            ['meatcut_id',$request->categoriaId],
            ['status',1],
            ['level_product_id',2]
        ])->get();
        return response()->json(['products' => $prod]);
    }

    public function getMeatcutAndProducts(Request $request)
    {
        $meatcuts = Meatcut::where('status', 1)->orderBy('name')->get();
        
        $products = Product::where([
            ['category_id', $request->categoriaId],
            ['status', 1]
        ])->whereIn('level_product_id', [1, 2])->orderBy('name')->get();
        
        return response()->json([
            'meatcuts' => $meatcuts,
            'products' => $products
        ]);       
    }   

}
