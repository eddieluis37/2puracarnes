@extends('layouts.theme.app')
@section('content')
<style>
  .table-totales {
    /*border: 2px solid red;*/
  }

  .table-totales,
  th,
  td {
    border: 1px solid #DCDCDC;
  }

  .table-inventario,
  th,
  td {
    border: 1px solid #DCDCDC;
  }
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
  <div class="col-sm-12">
    <div class="widget widget-chart-one">
      <div class="card text-center" style="background: #3B3F5C">
        <div class="m-2">
          <h4 style="color:white;"><strong>Reporte de ventas por productos</strong></h3>
        </div>
      </div>
      <div class="row g-3 mt-3">
        <div class="col-md-3">
          <label for="" class="form-label">Categoria</label>
          <select class="form-control form-control-sm input" name="categoria" id="categoria" required>
            <option value="">Seleccione la categoria</option>
            @foreach($category as $option)
            <option value="{{ $option['id'] }}" data="{{ $option }}">{{ $option['name'] }}</option>
            @endforeach
          </select>
          <span class="text-danger error-message"></span>
        </div>
        <!--  <div class="col-md-4">
          <label for="date1" class="form-label">Fecha inicio</label>
          <input type="date" class="form-control" value="{{$startDate}}" placeholder="Last name">
        </div> -->
        <div class="col-md-3" style="display:none">
          <label for="date1" class="form-label">Fecha de Cierre</label>
          <input type="date" class="form-control" value="{{$endDate}}" placeholder="Last name">
        </div>
        <div class="col-md-3">
          <label for="" class="form-label">Centro de costo</label>
          <select class="form-control form-control-sm input" name="centrocosto" id="centrocosto" required>
            <option value="">Seleccione el centro de costo</option>
            @foreach($centros as $option)
            <option value="{{ $option['id'] }}" data="{{ $option }}">{{ $option['name'] }}</option>
            @endforeach
          </select>
          <span class="text-danger error-message"></span>
        </div>
        <!--  <div class="col-md-4">
          <label for="date1" class="form-label">Responsable</label>
					<select class="form-control form-control-sm " name="" id="" required="">
						<option value="">Seleccione el responsable</option>
					</select>
        </div> -->
        <div class="col-md-3 text-right ml-auto">
          <div style="margin-top:28px;" clas="">
            <button class="btn btn-success btn-lg" type="button" id="cargarInventarioBtn"></button>
          </div>
        </div>

        @can('Cerrar_Inventario')


        @endcan


        <div class="table-responsive mt-3">
          <table id="tableInventory" class="table table-success table-striped mt-1">
            <thead class="text-white" style="background: #3B3F5C">
              <tr>
                <th class="table-th text-white" title="Categoria">COD</th>
                <th class="table-th text-white" title="Productos">PRODUCTO</th>
                <th class="table-th text-white" title="Categoria">CAT</th>
                <th class="table-th text-white" title="Cantidades vendidas">CV</th>
                <th class="table-th text-white" title="Cantidades acreditadas">CN</th>
                <th class="table-th text-white" title="Cantidad debitadas">CD</th>
                <th class="table-th text-white" title="Cantidad real">CR</th>
                <th class="table-th text-white" title="Dinero venta real">$VR</th>
                <th class="table-th text-white" title="Descuento por producto">DP</th>
                <th class="table-th text-white" title="Descuento por cliente">DC</th>
                <th class="table-th text-white" title="">SUBTOTAL</th>
                <th class="table-th text-white" title="">IS</th>
                <th class="table-th text-white" title="Impuesto IVA">IVA</th>
                <th class="table-th text-white" title="">TOTAL</th>
              </tr>
            </thead>
            <tbody>
            </tbody>
            <tfoot>
              <tr>
                <th>Totales</th>
                <td></td>
                <td></td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>
                <td>0.00</td>              
              </tr>
            </tfoot>
          </table>
        </div>


      </div>
    </div>
  </div>
  @endsection
  @section('script')
  <script src="{{asset('code/js/reportes/code-consolidado-index.js')}} " type="module"></script>
  @endsection