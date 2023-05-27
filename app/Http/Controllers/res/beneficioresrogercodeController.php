<?php

namespace App\Http\Controllers\res;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Yajra\Datatables\Datatables;
use Carbon\Carbon;
use Illuminate\Support\Facades\Validator;

class beneficioresrogercodeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return view('categorias.res.beneficiores.index');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show()
    {
            $data = DB::table('beneficiores as be')
            ->join('thirds as tird', 'be.thirds_id', '=', 'tird.id')
            ->select('be.*', 'tird.name as namethird')
            //->where('be.status', 1)
            ->get();
            //$data = Compensadores::orderBy('id','desc');
            return Datatables::of($data)->addIndexColumn()
                ->addColumn('date', function($data){
                    $date = Carbon::parse($data->created_at);
                     $onlyDate = $date->toDateString();
                    return $onlyDate;
                })
                ->addColumn('action', function($data){
                    $currentDateTime = Carbon::now();
                    if (Carbon::parse($currentDateTime->format('Y-m-d'))->gt(Carbon::parse($data->fecha_cierre))) {
                        $btn = '
                        <div class="text-center">
					    <a href="desposteres/'.$data->id.'" class="btn btn-dark" title="Despostar" >
						    <i class="fas fa-directions"></i>
					    </a>
					    <button class="btn btn-dark" title="Borrar Beneficio" onclick="showDataForm('.$data->id.')">
						    <i class="fas fa-eye"></i>
					    </button>
					    <button class="btn btn-dark" title="Borrar Beneficio" disabled>
						    <i class="fas fa-trash"></i>
					    </button>
                        </div>
                        ';
                    }elseif (Carbon::parse($currentDateTime->format('Y-m-d'))->lt(Carbon::parse($data->fecha_cierre))) {
                        $btn = '
                        <div class="text-center">
					    <a href="desposteres/'.$data->id.'" class="btn btn-dark" title="Despostar" >
						    <i class="fas fa-directions"></i>
					    </a>
					    <button class="btn btn-dark" title="Borrar Beneficio" onclick="editCompensado('.$data->id.');">
						    <i class="fas fa-edit"></i>
					    </button>
					    <button class="btn btn-dark" title="Borrar Beneficio" onclick="downCompensado('.$data->id.');">
						    <i class="fas fa-trash"></i>
					    </button>
                        </div>
                        ';
                    }else{
                        $btn = '
                        <div class="text-center">
					    <a href="desposteres/'.$data->id.'" class="btn btn-dark" title="Despostar" >
						    <i class="fas fa-directions"></i>
					    </a>
					    <button class="btn btn-dark" title="Borrar Beneficio" >
						    <i class="fas fa-eye"></i>
					    </button>
					    <button class="btn btn-dark" title="Borrar Beneficio" disabled>
						    <i class="fas fa-trash"></i>
					    </button>
                        </div>
                        ';
                    }
                    return $btn;
                })
                ->rawColumns(['date','action'])
                ->make(true);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }
}
