
@section('title','Desposte')
@section('styles')
<style type="text/css">
    .unstyled-button {
        border: none;
        padding: 0;
        background: none;
      }
</style>

@endsection
@section('options')
@endsection
@section('preference')
@endsection
@section('content')
<div class="content-wrapper">
    <div class="page-header">
        <h3 class="page-title">
            Desposte / RES
        </h3>
        <nav aria-label="breadcrumb">
            <ol class="breadcrumb">
                <li class="breadcrumb-item"><a href="#">Panel administrador</a></li>
                <li class="breadcrumb-item active" aria-current="page">Desposte de Res</li>
            </ol>
        </nav>
    </div>
    <div class="row">
        <div class="col-lg-12 grid-margin stretch-card">
            <div class="card">
                <div class="card-body">

                    <div class="d-flex justify-content-between">
                        <h4 class="card-title">Desposte de Res</h4>
                       
                    </div>
                    {!! Form::open(['route'=>'storem', 'method'=>'POST','files' => true]) !!}
                    <div class="row">
                    
                        <div class="form-group col-md-1">
                            <label for="sell_price">Id-Beneficio</label>
                            <input type="number" name="id" id="id" class="form-control" readonly  value="{{$beneficior[0]->id}}" >
                        </div>
                      
                        <div class="form-group col-md-2">
                            <label for="sell_price">Lote</label>
                            <input type="text" name="lote" id="lote" class="form-control" readonly  value="{{$beneficior[0]->lote}}">
                        </div>
                        <div class="form-group col-md-2">
                            <label for="sell_price">Factura</label>
                            <input type="text" name="factura" id="factura" class="form-control" readonly value="{{$beneficior[0]->factura}}" >
                        </div>

                        
                        <div class="form-group col-md-1">                          
                            <button type="submit" class="btn btn-primary mr-2">Despostar</button>
                            <a  href="{{route('desposters.index')}}" class="btn btn-light">
                                Cancelar
                            </a>
                        </div>
                   
                    </div>
                    {!! Form::close() !!}
                   
                    

                    <div class="table-responsive">
                        <table id="order-listing" class="table">
                            <thead>
                                <tr>
                                    <th>Id</th>                                    
                                    <th>F.técnica</th>
                                    <th>Producto</th>
                                    <th>Peso</th>
                                    <th>%Desposte</th>
                                    <th>Costo</th>
                                    <th>Precio</th>
                                    <th>Total</th>
                                    <th>%Venta</th>
                                    <th>%Utilidad</th>
                                    <th>Acciones</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php $tpeso = 0; $tdesposte = 0; ?>
                                @foreach ($data as $desposter)
                                <tr>
                                    <th scope="row">{{$desposter->id}}</th>                                   
                                    <td>{{$desposter->fichatecnica->name}}</td>
                                    <td>{{$desposter->product -> name}}</td>
                                    <td>{{$desposter->peso}}</td>
                                    <td>{{$desposter->porcdesposte}}</td>
                                    <td>{{number_format($desposter->costo,0)}}</td>
                                    <td>{{number_format($desposter->precio,0)}}</td>
                                    <td>{{number_format($desposter->total,0)}}</td>
                                    <td>{{ number_format($desposter->porcventa,2)}}</td>
                                    <td>{{ number_format($desposter->porcutilidad,2 ) }}</td>
                                    <td style="width: 50px;">
                                        <a class="jsgrid-button jsgrid-edit-button" href="{{route('desposters.edit', $desposter)}}" title="Proceso de desposte">
                                            <i class="far fa-edit"></i>
                                        </a>                                
                                    </td>
                                </tr>
                                <?php $tpeso = $tpeso + $desposter->peso ;
                                      $tdesposte = $tdesposte + $desposter-> total; ?>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>

  <style>
    .campo{
        background-color:#e9ecef;
    }
</style>                
<?php 
   $pi = $beneficior[0]->canalplanta; 
   $cant = $beneficior[0]->cantidad;
   $ck = $beneficior[0]->costokilo;
   $tck = $pi * $ck;
?>
 
 <div class="form-row" style="padding:20px">
    <div class="form-group col-md-6">         
        <div class="card">            
            <div class="card-body">
                <div class="card-title">MERMA</div>
                    
                <div class="form-row">
                    <div class="form-group col-md-4">
                        <label for="sell_price">Peso Inicial</label>                        
                        <div class="form-control campo" >
                            {{ number_format( $pi,2 )}} </div>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="sell_price">Peso por Animal</label>
                        <div class="form-control campo" >
                            {{ number_format( $pi / $cant,2 )}} </div>    
                    </div>
                    <div class="form-group col-md-4">
                        <label for="sell_price">Peso total Desposte</label>
                        <div class="form-control campo" >
                            {{ number_format( $tpeso,2)}} </div>    
                    </div>
                    <div class="form-group col-md-4">
                        <label for="sell_price">MERMA</label>
                        <div class="form-control campo" >
                            {{ number_format( $tpeso - $pi,2)}} </div>    
                    </div>
                    <div class="form-group col-md-4">
                        <label for="sell_price"> % MERMA</label>
                        <?php if($tpeso == 0) { ?>
                           <div class="form-control campo" >
                           <?php  echo number_format($tpeso,2) ; ?>
                           </div>
                        <?php } ?>
                        <?php if($tpeso != 0) { ?>
                           <div class="form-control campo" >
                           <?php  echo number_format( ( ($tpeso  - $pi) / $tpeso ) *100 ,2) ; ?>
                           </div>
                        <?php } ?>
                    </div>
                    <div class="form-group col-md-4">
                        <label for="sell_price"> CANT ANIMALES</label>
                        <div class="form-control campo" >
                            {{ number_format($cant,0)}} </div>    
                    </div>

                                       
                </div>               
            </div>
        </div>         
    </div>

    <div class="form-group col-md-6">       
         <div class="card">            
                <div class="card-body">
                    <div class="card-title">UTILIDAD</div>
                         <div class="form-row">

                          <div class="form-group col-md-4">
                            <label for="sell_price"> Costo Kilo</label>
                            <div class="form-control campo" >
                                {{ number_format( $ck,2) }} </div>    
                          </div>
                          <div class="form-group col-md-4">
                            <label for="sell_price"> Valor Desposte</label>
                            <div class="form-control campo" >
                                {{ number_format( $tdesposte,2) }} </div>    
                          </div>
                          <div class="form-group col-md-4">
                            <label for="sell_price"> Total Costo Kilo</label>
                            <div class="form-control campo" >
                                {{ number_format( $tck ,2) }} </div>    
                          </div>

                            
                          <div class="form-group col-md-4">
                            <label for="sell_price"> Utilidad</label>
                            <div class="form-control campo" >
                                {{ number_format( $tdesposte - $tck ,2) }} </div>    
                          </div>
                          
                          <div class="form-group col-md-4">
                                <label for="sell_price"> % Utilidad</label>
                                <?php if($tdesposte == 0) { ?>
                                <div class="form-control campo" >
                                <?php  echo number_format($tdesposte,2) ; ?>
                                </div>
                                <?php } ?>
                                <?php if($tdesposte != 0) { ?>
                                <div class="form-control campo" >
                                <?php  echo number_format( ( ( $tdesposte - $tck ) / $tdesposte ) * 100 ,2) ; ?>
                                </div>
                                <?php } ?>                                
                          </div>

                          <div class="form-group col-md-4">
                                <label for="sell_price"> Utilidad por Animal</label>
                                <?php if($tdesposte == 0) { ?>
                                <div class="form-control campo" >
                                <?php  echo number_format($tdesposte,2) ; ?>
                                </div>
                                <?php } ?>
                                <?php if($tdesposte != 0) { ?>
                                <div class="form-control campo" >
                                <?php  echo number_format( ( $tdesposte - $tck ) / $cant ,2) ; ?>
                                </div>
                                <?php } ?>                                
                          </div>
                                                      
                        </div>          
                </div>
            </div>          
    </div>
</div>
 

                
                {{--  <div class="card-footer text-muted">
                    {{$beneficiors->render()}}
                </div>  --}}
            </div>
        </div>
    </div>
</div>
@endsection
@section('scripts')
{!! Html::script('melody/js/data-table.js') !!}
@endsection
