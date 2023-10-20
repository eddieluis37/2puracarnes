@extends('layouts.theme.app')
@section('content')
<style>
.input {
  height: 38px;
}
</style>
<meta name="csrf-token" content="{{ csrf_token() }}">
<div class="row sales layout-top-spacing">
    <div class="col-sm-7">        
        
        <div class="widget widget-chart-one">              
            <div class="widget-content mt-3" >
                
                <div class="card">                           
                    <div class="card-body">
                        <form id="form-detail">						
                            
                            <div class="row">
                                <div class="col-md-5">
                                    <label for="" class="form-label">Seleccionar categoría </label>
                                        <select class="form-control form-control-sm selectcategoria" name="categoria" id="categoria" required="">
                                             <option value="">Seleccione la categoria</option>
                                                @foreach($category as $option)
                                                    <option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
                                                @endforeach
                                        </select>
                                    
                                </div>
                                <div class="col-md-7">
                                    <label for="" class="form-label">Seleccionar producto </label>
                                        <select class="form-control form-control-sm select2ProdHijos" name="producto" id="producto" required="">
                                        </select>
                                </div>
                            </div>

                            <div class="row g-3">							
                                <div class="col-md-5">
                                    <label for="" class="form-label">Precio Venta</label>
                                    <div class="input-group flex-nowrap">
                                        <input type="text" id="precioventa" name="precioventa" class="form-control input" >
                                        <span class="input-group-text" id="addon-wrapping">$</span>
                                    </div>
                                </div>
                                <div class="col-md-5">
                                    <label for="" class="form-label">KG requeridos</label>
                                    <div class="input-group flex-nowrap">
                                        <input type="text" id="kgrequeridos" name="kgrequeridos" class="form-control input" placeholder="EJ: 10,00">
                                        <span class="input-group-text" id="addon-wrapping">KG</span>
                                    </div>
                                </div>
                                <div class="col-md-2 text-center">
                                    <div class="" style="margin-top:30px;">
                                    <div class="d-grid gap-2">
                                        <button id="btnAddAlistamiento" class="btn btn-primary">Aceptar</button>
                                    </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>                            
                </div>

            </div>
        </div>
    
        
        <div class="widget widget-chart-one">
              
            <div class="widget-content mt-3">
                <div class="card">
                    <div class="card-body">
							<div class="table-responsive mt-3">
								<table id="tableAlistamiento" class="table table-sm table-striped table-bordered">
									<thead class="text-white" style="background: #3B3F5C">
										<tr>
											<!--th class="table-th text-white">Item</th>-->
											<th class="table-th text-white">#</th>											
											<th class="table-th text-white">Producto</th>
											<th class="table-th text-white">Cant Kg</th>											
                                            <th class="table-th text-white">Precio</th>
                                            <th class="table-th text-white">Iva</th>
                                            <th class="table-th text-white">Total</th>											
										</tr>
									</thead>
									<tbody id="tbodyDetail">
										@foreach($ventasdetalle as $proddetail)
										<tr>
											<td>{{$proddetail->id}}</td>											
											<td>{{$proddetail->nameprod}}</td>
											<td>{{ number_format($proddetail->quantity, 2, ',', '.')}} KG</td>																							
											<td>{{number_format($proddetail->price, 2, ',', '.')}} $</td>
                                            <td>{{number_format($proddetail->iva, 2, ',', '.')}} $</td>
                                            <td>{{number_format($proddetail->total, 2, ',', '.')}} $</td>											
											
										</tr>
										@endforeach
									</tbody>
									<tfoot id="tabletfoot" >
										<tr>
											<th></th>
											<th></th>
											<th>Totales</th>
											<th></th>
											<th></th>
											<th> {{number_format($arrayTotales['kgTotalventa'], 2, ',', '.')}} </th>											
											<th class="text-center">
												
												
												
											</th>
										</tr>
									</tfoot>
								</table>
							</div>
                    </div>
                </div>
            </div>

        </div>
    </div> 



    <div class="col-sm-5">
        <div class="widget widget-chart-one">
        
        	<div class="widget-content mt-3">
				<div class="card">
					<div class="card-body">
						<div class="row g-3">
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Fecha de venta</label>
										<p>{{$venta->fecha}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Tercero</label>										
										<p>{{$venta->third->nam}}</p>
									</div>
								</div>
							</div>
							<div class="col-md-4">
								<div class="task-header">
									<div class="form-group">
                                        <label for="" class="form-label">Centro de costo</label>
										<p>{{$venta->centrocosto->name}}</p>
									</div>
								</div>
							</div>
						</div>
                        <button class="btn btn-success" id="addShopping">Facturar</button>
					</div>
				</div>
            </div>	         
        </div>
    </div>
        

</div> 


@endsection
@section('script')
<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js"></script> 
<script src="{{asset('rogercode/js/alistamiento/rogercode-create.js')}}" type="module"></script>
@endsection

<script>

$(document).ready(initializeDataTable);
 function initializeDataTable() {
	new DataTable('#tableAlistamiento', {
		columns: [
			{ title: '#' },
			{ title: 'Producto' },
			{ title: 'Cant Kg' },
			{ title: 'Precio' },
			{ title: 'Iva' },			
		],
		
	});
}


$('.producto').select2({
	placeholder: 'Busca un producto',
	width: '100%',
	theme: "bootstrap-5",
	allowClear: true,
});
const dataform = new FormData();
const categoryId = document.querySelector("#categoryId");
dataform.append("categoriaId", Number(categoryId.value));
sendData("/getproductos",dataform,token).then((result) => {
    
    let prod = result.products;    
    selectProducto.innerHTML = "";
    selectProducto.innerHTML += `<option value="">Seleccione el producto</option>`;
    prod.forEach(option => {
    const optionElement = document.createElement("option");
    optionElement.value = option.id;
    optionElement.text = option.name;
    selectProducto.appendChild(optionElement);
    });
});
</script>