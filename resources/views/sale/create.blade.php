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
                                <div class="col-md-5"  style="display:none">
                                    <label for="" class="form-label">Seleccionar categoría </label>
                                        <select class="form-control form-control-sm selectcategoria" name="categoria" id="categoria" required="">
                                             <option value="">Seleccione la categoria</option>
                                                @foreach($category as $option)
                                                    <option value="{{ $option['id'] }}" data="{{$option}}">{{ $option['name'] }}</option>
                                                @endforeach
                                        </select>
                                    
                                </div>
                                <div class="col-md-8">
                                    <label for="" class="form-label">Seleccionar producto </label>
                                        <select class="form-control form-control-sm selectPrroducto" name="producto" id="producto" required="">
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
                                        <button id="btnAdd" class="btn btn-primary">Aceptar</button>
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
								<table id="tableVentasDet" class="table table-sm table-striped table-bordered">
									<thead class="text-white" style="background: #3B3F5C">
										<tr>
											<!--th class="table-th text-white">Item</th>-->
											<th class="table-th text-white">1</th>											
											<th class="table-th text-white">2</th>
											<th class="table-th text-white">3</th>											
                                            <th class="table-th text-white">4</th>
                                            <th class="table-th text-white">5</th>
                                            <th class="table-th text-white">6</th>											
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

<script src="https://ajax.googleapis.com/ajax/libs/jquery/1.9.1/jquery.js">


</script> 


<script>


$(document).ready(initializeDataTable);
 function initializeDataTable() {
	new DataTable('#tableVentasDet', {
        "bFilter": false,
        "bLengthChange": false,        
		columns: [
			{ title: '#' },
			{ title: 'Producto' },
			{ title: 'Cant Kg' },
			{ title: 'Precio' },
            { title: 'Iva' },
			{ title: 'Total' },
		],		
	});    

    /***** SE QUITA EL FILTRO DE CATEGORÍA A LOS PRODUCTOS DESDE EL CONTROLADOR ******** */
   
    const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

    const send = async (dataform,ruta) => {
        
        let response = await fetch(ruta, {
        headers: {
            'X-CSRF-TOKEN': token
        },
        method: 'POST',
        body: dataform
        });
        let data = await response.json();
        //console.log(data);
        return data;
    }
    
    
    getProductos(0);
   
    function getProductos (categoryId)  {
        
        const dataform = new FormData();
        dataform.append("categoriaId", Number(categoryId));
        send(dataform,'/getproductosv').then((result) => {        
            let prod = result.products;
                    
            producto.innerHTML = "";
            producto.innerHTML += `<option value="">Seleccione el producto</option>`;
            
            prod.forEach(option => {
            const optionElement = document.createElement("option");
            optionElement.value = option.id;
            optionElement.text = option.name;
            producto.appendChild(optionElement);
            });
        });
    }   
    
}


/***** GUARDAR DETALLE ******** */
        
const btnAdd = document.querySelector("#btnAdd");

btnAdd.addEventListener("click", (e) => {
        e.preventDefault();
        const formDetail = document.querySelector("#form-detail");
        const dataformd = new FormData(formDetail);
        
        send(dataformd,'/salesavedetail').then((result) => {        
            if (result.status === 1) {
                alert('good');
                $("#producto").val("").trigger("change");
                //formDetail.reset();
                //showData(result);
            }
            if (result.status === 0) {
                Swal("Error!", "Tiene campos vacios!", "error");
            }
        });
    });



 
</script>