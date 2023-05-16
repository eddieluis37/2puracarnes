@extends('layouts.theme.app')
@section('content')
<style>
  .table-totales{
    /*border: 2px solid red;*/
  }
  .table-totales, th, td {
    border: 1px solid #DCDCDC;
  }
  .table-inventario, th, td {
    border: 1px solid #DCDCDC;
  }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
  <div class="col-sm-12">
    <div class="widget widget-chart-one">
      <div class="card text-center" style="background: #3B3F5C">
        <div class="m-2">
          <h4 style="color:white;"><strong>Movimiento diario</strong></h3>
        </div>
      </div>
      <div class="row g-3 mt-3">
        <div class="col-md-4">
          <label for="" class="form-label">Seccion</label>
					<select class="form-control form-control-sm " name="" id="" required="">
						<option value="">Seleccione la seccion</option>
					</select>
        </div>
        <div class="col-md-4">
          <label for="date1" class="form-label">Fecha</label>
          <input type="date" class="form-control" placeholder="Last name" aria-label="Last name" value="{{date('Y-m-d')}}">
        </div>
        <div class="col-md-4">
          <label for="" class="form-label">Punto</label>
					<select class="form-control form-control-sm " name="" id="" required="">
						<option value="">Seleccione el punto</option>
					</select>
        </div>
        <div class="col-md-4">
          <label for="date1" class="form-label">Responsable</label>
          <input type="text" class="form-control" placeholder="EDGARDO CASTELLON" aria-label="Last name">
        </div>
        <div class="col-md-4">
          <div style="margin-top:28px;" clas="">
            <button class="btn btn-primary btn-lg" type="button">Aceptar</button>
          </div>
        </div>
      </div>
    
    
      <div class="table-responsive mt-3">
        <table class="table table-sm table-inventario">
          <thead class="text-white" style="background: #3B3F5C">
            <tr>
              <th class="table-th text-white">PRODUCTO</th>
              <th class="table-th text-white">UNID DE MEDIDA</th>
              <th class="table-th text-white">COMPRAS LOTES</th>
              <th class="table-th text-white">COMPENSADO</th>
              <th class="table-th text-white">TRASLADO DE INGRESO</th>
              <th class="table-th text-white">TRASLADO DE SALIDA</th>
              <th class="table-th text-white">DECOMISO</th>
              <th class="table-th text-white">DE BAJA</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Bola de pierna</td>
              <td>Kilos</td>
              <td>0.00</td>
              <td>460.00</td>
              <td>0.00</td>
              <td>0.00</td>
              <td>323.89</td>
              <td>26.95</td>
            </tr>
            <tr>
              <td>Brazo completo</td>
              <td>Kilos</td>
              <td>0.00</td>
              <td>460.00</td>
              <td>0.00</td>
              <td>0.00</td>
              <td>323.89</td>
              <td>26.95</td>
            </tr>
            <tr>
              <td>Cadera completa</td>
              <td>Kilos</td>
              <td>0.00</td>
              <td>460.00</td>
              <td>0.00</td>
              <td>0.00</td>
              <td>323.89</td>
              <td>26.95</td>
            </tr>
            <tr>
              <td>Pachas</td>
              <td>Kilos</td>
              <td>0.00</td>
              <td>460.00</td>
              <td>0.00</td>
              <td>0.00</td>
              <td>323.89</td>
              <td>26.95</td>
            </tr>
            <tr>
              <td>Hueso poroso</td>
              <td>Kilos</td>
              <td>0.00</td>
              <td>460.00</td>
              <td>0.00</td>
              <td>0.00</td>
              <td>323.89</td>
              <td>26.95</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <th>Totales</th>
              <td></td>
              <td>0.00</td>
              <td>460.00</td>
              <td>0.00</td>
              <td>0.00</td>
              <td>323.89</td>
              <td>26.95</td>
            </tr>
          </tfoot>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection