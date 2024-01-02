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
          <h4 style="color:white;"><strong>Movimiento diario</strong></h3>
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
          <label for="date1" class="form-label">Fecha</label>
          <input type="date" class="form-control" name="fecha" id="fecha" placeholder="Last name" aria-label="Last name" value="{{date('Y-m-d')}}">
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
     <!--    <div class="col-md-4">
          <label for="date1" class="form-label">Responsable</label>
          <select class="form-control form-control-sm " name="responsable" id="responsable" required="">
            <option value="">Seleccione el responsable</option>
          </select>
        </div>
        <div class="col-md-4">
          <div style="margin-top:28px;" clas="">
            <button type="submit" id="btnAddTransfer" class="btn btn-primary btn-lg">Aceptar</button>
          </div>
        </div> -->
      </div>
      <div class="table-responsive mt-3">
        <table id="tableInventory" class="table table-striped mt-1">
          <thead class="text-white" style="background: #3B3F5C">
            <tr>
              <th class="table-th text-white">CAT</th>
              <th class="table-th text-white">PRODUCTO</th>
              <th class="table-th text-white">INV INICIAL</th>
              <th class="table-th text-white">COMPRA LOTE</th>
              <th class="table-th text-white">ALIST</th>
              <th class="table-th text-white">COMPEN</th>
              <th class="table-th text-white">TRAS ING</th>
              <th class="table-th text-white">TRAS SAL</th>
              <th class="table-th text-white">VENTA</th>
              <th class="table-th text-white">STOCK IDEAL</th>
              <th class="table-th text-white">INV FINAL</th>             
              <th class="table-th text-white">DISPO</th>
              <th class="table-th text-white">MERMA</th>
              <th class="table-th text-white">%MERMA</th>

              <!-- <th class="table-th text-white">TOTAL INV INI</th>
              <th class="table-th text-white">COMPRA LOTE</th>
              <th class="table-th text-white">COSTO UNI LOTE</th>            
             
              <th class="table-th text-white">TOTAL COMP</th>
             
              <th class="table-th text-white">COSTO UNI TRAS ING</th>
              <th class="table-th text-white">TOTAL ING</th>
             
              <th class="table-th text-white">TOTAL VENTA</th>
              <th class="table-th text-white">PRECIO VENTA PROD</th>
              <th class="table-th text-white">PRECIO VENTA MIN</th>
              <th class="table-th text-white">DIF</th>
              <th class="table-th text-white">TRAS SALIDA</th>
              <th class="table-th text-white">COSTO UNI TRAS SALIDA</th>
             
             
              <th class="table-th text-white">COSTO UNIT INV INI</th>
              <th class="table-th text-white">TOTAL INV INV</th>
              <th class="table-th text-white">DISPONIBLE</th>
              <th class="table-th text-white">MERMA</th>
              <th class="table-th text-white">% MERMA</th>
              <th class="table-th text-white">UTILIDAD</th>
              <th class="table-th text-white">% MERMA</th> -->
            </tr>
          </thead>
          <tbody>
          </tbody>
          <tfoot>
            <tr>
              <th>Totales</th>
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
<script src="{{asset('code/js/inventory/code-index.js')}}"></script>
@endsection