@extends('layouts.theme.app')
@section('content')
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
  <div class="col-sm-12">
    <div class="widget widget-chart-one">
      <div class="row">
        <div class="col-md-5">
          <form>
            <div class="row mb-3">
              <label for="" class="col-sm-2 col-form-label">SECCION</label>
              <div class="col-sm-10 ">
								<select class="form-control form-control-sm " name="" id="" required="">
									<option value="">Seleccione el proveedor</option>
								</select>
              </div>
            </div>

            <div class="row mb-3">
              <label for="date1" class="col-sm-2 col-form-label">Del</label>
              <div class="col-sm-10 d-flex">
                <input type="date" class="form-control mr-2" id="">
                <input type="date" class="form-control" id="">
              </div>
            </div>

            <!--div class="row mb-3">
              <label for="date1" class="col-sm-2 col-form-label">Del</label>
              <div class="col-sm-10">
                <input type="date" class="form-control" id="">
              </div>
            </div>
            <div class="row mb-3">
              <label for="date1" class="col-sm-2 col-form-label">Al</label>
              <div class="col-sm-10">
                <input type="date" class="form-control" id="">
              </div>
            </div>-->
            
            <div class="row mb-3">
              <label for="" class="col-sm-2 col-form-label">PUNTO</label>
              <div class="col-sm-10 ">
								<select class="form-control form-control-sm " name="" id="" required="">
									<option value="">Seleccione el proveedor</option>
								</select>
              </div>
            </div>
          </form>          
        </div>
        <div class="col-md-7">
          <div class="row">
            <div class="col-3 mb-1 bg-danger">
              <span>Total ingresos</span><br>
              <span>Total salidas</span><br>
              <span>Total stock ideal</span><br>
              <span>Total conteo fisico</span>
            </div>
            <div class="col-3 mb-1 bg-success">
              <span>234567</span><br>
              <span>234567</span><br>
              <span>234567</span><br>
              <span>234567</span>
            </div>
            <div class="col-3 mb-1 bg-primary">
              <span>Diferencia en kilos</span><br>
              <span>40.09</span>
            </div>
            <div class="col-3 mb-1 bg-warning">
              <span>Dif. En kilos permitida</span><br>
              <span>143</span>
            </div>
            <div class="col-3 mb-1 bg-info">
              <span>Merma</span><br>
              <span>0.26%</span>
            </div>
            <div class="col-3 mb-1 bg-warning">
              <span>Merma permitida</span><br>
              <span>1.26%</span>
            </div>
            <div class="col-3 mb-1 bg-danger">
              <span>Dif. en kilos</span><br>
              <span>1.26%</span>
            </div>
            <div class="col-3 mb-1 bg-success">
              <span>Dif. en %</span><br>
              <span>1.26%</span>
            </div>
          </div>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table">
          <thead>
            <tr>
              <th scope="col">PRODUCTO</th>
              <th scope="col">UNID DE MEDIDA</th>
              <th scope="col">INVENTARIO INICIAL</th>
              <th scope="col">LOTES</th>
              <th scope="col">COMPENSADO</th>
              <th scope="col">TRASLADO INGRESOS</th>
              <th scope="col">VENTAS</th>
              <th scope="col">TRASLADO DE SALIDA</th>
              <th scope="col">STOCK IDEAL</th>
              <th scope="col">CONTEO FISICO</th>
              <th scope="col">DIFERENCIA EN KILOS</th>
              <th scope="col">DECOMISO</th>
              <th scope="col">DE BAJA</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>rogero</td>
              <td>tedskdjskdjksdjskjdskdjksdjs</td>
            </tr>
            <tr>
              <th scope="row">1</th>
              <td>Mark</td>
              <td>Otto</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>@mdo</td>
              <td>rogero</td>
              <td>tedskdjskdjksdjskjdskdjksdjs</td>
            </tr>
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>
@endsection