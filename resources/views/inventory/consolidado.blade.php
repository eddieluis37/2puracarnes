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
          <h4 style="color:white;"><strong>Inventario semanal</strong></h3>
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
          <label for="date1" class="form-label">Fecha inicio</label>
          <input type="date" class="form-control" value="{{$startDate}}" placeholder="Last name" >
        </div>
        <div class="col-md-4">
          <label for="date1" class="form-label">Fecha fin</label>
          <input type="date" class="form-control" value="{{$endDate}}" placeholder="Last name" >
        </div>
        <div class="col-md-4">
          <label for="" class="form-label">Punto</label>
					<select class="form-control form-control-sm " name="" id="" required="">
						<option value="">Seleccione el punto</option>
					</select>
        </div>
        <div class="col-md-4">
          <label for="date1" class="form-label">Responsable</label>
					<select class="form-control form-control-sm " name="" id="" required="">
						<option value="">Seleccione el responsable</option>
					</select>
        </div>
        <div class="col-md-4">
          <div style="margin-top:28px;" clas="">
            <button class="btn btn-primary btn-lg" type="button">Aceptar</button>
          </div>
        </div>
      </div>
      <div class="card border-0">
        <div class="m-3">

          <div class="row">
            <div class="col-3 mb-1 bg-success">
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
            <div class="col-3 mb-1 bg-primary text-center">
              <span>Diferencia en kilos</span><br>
              <span>40.09</span>
            </div>
            <div class="col-3 mb-1 bg-warning text-center">
              <span>Dif. En kilos permitida</span><br>
              <span>143</span>
            </div>
            <div class="col-3 mb-1 bg-info text-center">
              <span>Merma</span><br>
              <span>0.26%</span>
            </div>
            <div class="col-3 mb-1 bg-warning text-center">
              <span>Merma permitida</span><br>
              <span>1.26%</span>
            </div>
            <div class="col-3 mb-1 bg-info text-center">
              <span>Dif. en kilos</span><br>
              <span>1.26%</span>
            </div>
            <div class="col-3 mb-1 bg-success text-center">
              <span>Dif. en %</span><br>
              <span>1.26%</span>
            </div>
          </div>

        </div>
      </div>
      <!--div class="row">
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
      </div>-->
      <!--div class="table-responsive">
        <table class="table table-totales" style="">
          <tbody>
            <tr>
              <td colspan="2" class="">Totales</td>
              <td colspan="4" class="">Ingresos</td>
              <td colspan="2" class="">Salidas</td>
              <td colspan="5" class="">Inventario</td>
            </tr>
            <tr>
              <td colspan="2" >Totales</td>
              <td class="">0.00</td>
              <td class="">460.00</td>
              <td class="">0.00</td>
              <td class="">0.00</td>
              <td class="">323.89</td>
              <td class="">26.95</td>
              <td class="">109.68</td>
              <td class="">151.88</td>
              <td class="">41.97</td>
              <td class="">0.00</td>
              <td class="">0.00</td>
            </tr>
          </tbody>
        </table>
      </div>-->
      <div class="table-responsive">
        <table class="table table-sm table-inventario">
          <thead class="text-white" style="background: #3B3F5C">
            <tr>
              <td colspan="2" class=""></td>
              <td colspan="4" class="">Ingresos</td>
              <td colspan="2" class="">Salidas</td>
              <td colspan="4" class="">Inventario</td>
            </tr>
            <tr>
              <td colspan="2" >Totales</td>
              <td class="">0.00</td>
              <td class="">460.00</td>
              <td class="">0.00</td>
              <td class="">0.00</td>
              <td class="">323.89</td>
              <td class="">26.95</td>
              <td class="">109.68</td>
              <td class="">151.88</td>
              <td class="">41.97</td>
              <td class="">0.00</td>
            </tr>
            <tr>
              <th class="table-th text-white">PRODUCTO</th>
              <th class="table-th text-white">UNID DE MEDIDA</th>
              <th class="table-th text-white">INVENTARIO INICIAL</th>
              <th class="table-th text-white">LOTES</th>
              <th class="table-th text-white">COMPENSADO</th>
              <th class="table-th text-white">TRASLADO INGRESOS</th>
              <th class="table-th text-white">VENTAS</th>
              <th class="table-th text-white">TRASLADO DE SALIDA</th>
              <th class="table-th text-white">STOCK IDEAL</th>
              <th class="table-th text-white">CONTEO FISICO</th>
              <th class="table-th text-white">DIFERENCIA EN KILOS</th>
              <th class="table-th text-white">% MERMA</th>
            </tr>
          </thead>
          <tbody>
            <tr>
              <td>Bola de pierna</td>
              <td>Kilos</td>
              <td>0.00</td>
              <td>460.00</td>
              <td>0.00</td>
              <td>323.89</td>
              <td>26.95</td>
              <td>109.68</td>
              <td>151.88</td>
              <td>41.97</td>
              <td>0.00</td>
              <td>0.00</td>
            </tr>
            <tr>
              <td>Brazo completo</td>
              <td>Kilos</td>
              <td>0.00</td>
              <td>460.00</td>
              <td>0.00</td>
              <td>323.89</td>
              <td>26.95</td>
              <td>109.68</td>
              <td>151.88</td>
              <td>41.97</td>
              <td>0.00</td>
              <td>0.00</td>
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
              <td>109.68</td>
              <td>151.88</td>
              <td>0.00</td>
              <td>0.00</td>
            </tr>
          </tbody>
          <tfoot>
            <tr>
              <td>Cadera completa test</td>
              <td>Kilos</td>
              <td>0.00</td>
              <td>460.00</td>
              <td>0.00</td>
              <td>0.00</td>
              <td>323.89</td>
              <td>109.68</td>
              <td>151.88</td>
              <td>41.97</td>
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