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
          <h4 style="color:white;"><strong>Cargar</s> ventas diarias </strong></h3>
        </div>
      </div>
      <div class="row g-3 mt-3">
        <div class="col-md-4">
          <div class="task-header">
            <div class="form-group">
              <label for="categoria" class="form-label">Categoria</label>
              <select class="form-control form-control-sm input" name="categoria" id="categoria" required>
                <option value="">Seleccione la categoria</option>
                @foreach($category as $option)
                <option value="{{ $option['id'] }}" data="{{ $option }}">{{ $option['name'] }}</option>
                @endforeach
              </select>
              <span class="text-danger error-message"></span>
            </div>
          </div>
        </div>

        <div class="col-md-4">
          <div class="task-header">
            <div class="form-group">
              <label for="centrocosto" class="form-label">Centro de costo</label>
              <select class="form-control form-control-sm input" name="centrocosto" id="centrocosto" required>
                <option value="">Seleccione el centro de costo</option>
                @foreach($centros as $option)
                <option value="{{ $option['id'] }}" data="{{ $option }}">{{ $option['name'] }}</option>
                @endforeach
              </select>
              <span class="text-danger error-message"></span>
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive mt-3">
        <form method="POST" action="/updateCcpInventory">
          @csrf
          <table id="tableInventory" class="table table-striped mt-1">
            <thead class="text-white" style="background: #3B3F5C">
              <tr>
                <th class="table-th text-white">CAT</th>
                <th class="table-th text-white">ID</th>
                <th class="table-th text-white">PRODUCTO</th>
                <th class="table-th text-white text-left">VENTA</th>
              </tr>
            </thead>
            <tbody>
              <th></th>
              <td></td>
              <td class="text-right"></td>
              <td class="text-right"></td>
            </tbody>
            <tfoot>
              <tr>
                <th></th>
                <td></td>
                <td class="text-center"></td>
              </tr>
            </tfoot>
          </table>
        </form>
      </div>
    </div>
  </div>
</div>
@endsection
@section('script')
<script src="{{asset('code/js/inventory/code-cv-index.js')}}"></script>

@endsection