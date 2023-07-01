import {sendData} from '../exportModule/core/rogercode-core.js';
import { successToastMessage, errorMessage } from '../exportModule/message/rogercode-message.js';
import { loadingStart, loadingEnd } from '../exportModule/core/rogercode-core.js';
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const formDetail = document.querySelector('#form-detail');
const showRegTbody = document.querySelector("#tbodyDetail");
const tableAlistamiento = document.querySelector("#tableAlistamiento");
const tbodyTable = document.querySelector("#tableAlistamiento tbody")
const tfootTable = document.querySelector("#tableAlistamiento tfoot")
const stockPadre = document.querySelector("#stockCortePadre");
const pesokg = document.querySelector("#pesokg");

const newStockPadre = document.querySelector("#newStockPadre");
const meatcutId = document.querySelector("#meatcutId");
const tableFoot = document.querySelector("#tabletfoot");
const selectProducto = document.getElementById("producto");
const selectCategoria = document.querySelector("#productoCorte");
const btnAddAlist = document.querySelector('#btnAddAlistamiento');
const alistamientoId = document.querySelector("#alistamientoId");
const kgrequeridos = document.querySelector("#kgrequeridos");
const addShopping = document.querySelector("#addShopping");
const productoPadre = document.querySelector("#productopadreId");
const centrocosto = document.querySelector("#centrocosto");
const categoryId = document.querySelector("#categoryId");


$('.select2Prod').select2({
	placeholder: 'Busca un producto',
	width: '100%',
	theme: "bootstrap-5",
	allowClear: true,
});
$('.select2ProdHijos').select2({
	placeholder: 'Busca hijos',
	width: '100%',
	theme: "bootstrap-5",
	allowClear: true,
});
const dataform = new FormData();
dataform.append("categoriaId", Number(meatcutId.value));
sendData("/getproductos",dataform,token).then((result) => {
    console.log(result);
    let prod = result.products;
    console.log(prod);
    selectProducto.innerHTML = "";
    selectProducto.innerHTML += `<option value="">Seleccione el producto</option>`;
    prod.forEach(option => {
    const optionElement = document.createElement("option");
    optionElement.value = option.id;
    optionElement.text = option.name;
    selectProducto.appendChild(optionElement);
    });
});
/*$('.select2Prod').on('change', function() {
    const selectedValue = $(this).val();
    console.log("Selected value: " + selectedValue);
    const selectedOption = $(this).find('option:selected');
    const attributeStock = selectedOption.attr('data-stock');
    console.log("Attribute value: " + attributeStock);
    stockPadre.value = attributeStock;
    const dataform = new FormData();
    dataform.append("categoriaId", Number(selectedValue));
    sendData("/getproductos",dataform,token).then((result) => {
        console.log(result);
        let prod = result.products;
        console.log(prod);
        selectProducto.innerHTML = "";
        selectProducto.innerHTML += `<option value="">Seleccione el producto</option>`;
        prod.forEach(option => {
        const optionElement = document.createElement("option");
        optionElement.value = option.id;
        optionElement.text = option.name;
        selectProducto.appendChild(optionElement);
        });
    });
});*/

btnAddAlist.addEventListener('click', (e) => {
    e.preventDefault();  
    const dataform = new FormData(formDetail);
    sendData("/alistamientosavedetail",dataform,token).then((result) => {
        console.log(result);
        if (result.status === 1) {
            $('#producto').val('').trigger('change');
            formDetail.reset();
            showData(result)
        }
        if (result.status === 0) {
            errorMessage("Tienes campos vacios");
        }
    });
})

const showData = (data) => {
    let dataAll = data.array;
    console.log(dataAll);
	showRegTbody.innerHTML = "";
	dataAll.forEach((element,indice) => {
	    showRegTbody.innerHTML += `
    	    <tr>
      	    <td>${element.id}</td>
      	    <td>${element.code}</td>
      	    <td>${element.nameprod}</td>
      	    <td>${formatCantidad(element.stock)} KG</td>
      	    <td>${formatCantidad(element.fisico)} KG</td>
      	    <td>
            <input type="text" class="form-control-sm" data-id="${element.products_id}" id="${element.id}" value="${element.kgrequeridos}" placeholder="Ingresar" size="10">
            </td>
      	    <td>${formatCantidad(element.newstock)} KG</td>
			<td class="text-center">
				<button class="btn btn-dark fas fa-trash" name="btnDownReg" data-id="${element.id}" title="Borrar" >
				</button>
			</td>
    	    </tr>
	    `;
	});

    let arrayTotales = data.arrayTotales; 
    console.log(arrayTotales);
    tableFoot.innerHTML = '';
    tableFoot.innerHTML += `
	    <tr>
		    <td></td>
		    <td></td>
		    <th>Totales</th>
		    <td></td>
		    <td></td>
		    <th>${formatCantidad(arrayTotales.kgTotalRequeridos)} KG</td>
		    <th>${formatCantidad(arrayTotales.newTotalStock)} KG</th>
		    <td class="text-center">
                <button class="btn btn-success btn-sm" id="addShopping">Cargar al inventario</button>
            </td>
	    </tr>
    `;
    let newTotalStockPadre = arrayTotales.kgTotalRequeridos - stockPadre.value;
    newStockPadre.value = newTotalStockPadre;
}

kgrequeridos.addEventListener("change", function() {
  const enteredValue = formatkg(kgrequeridos.value);
  console.log("Entered value: " + enteredValue);
  kgrequeridos.value = enteredValue;
});

tableAlistamiento.addEventListener("keydown", function(event) {
  if (event.keyCode === 13) {
    const target = event.target;
    console.log(target);
    if (target.tagName === "INPUT" && target.closest("tr")) {
      console.log("Enter key pressed on an input inside a table row");
      console.log(event.target.value);
      console.log(event.target.id);
      
      const inputValue = event.target.value;
      if (inputValue == "") {
        return false;
      }

      let productoId = target.getAttribute('data-id');
      console.log("prod test id: " + alistamientoId.value);
      console.log(productoId);
      console.log(centrocosto.value);
      const trimValue = inputValue.trim();
      const dataform = new FormData();
      dataform.append("id", Number(event.target.id));
      dataform.append("newkgrequeridos", Number(trimValue));
      dataform.append("alistamientoId", Number(alistamientoId.value));
      dataform.append("productoId", Number(productoId));
      dataform.append("centrocosto", Number(centrocosto.value));
      
      sendData("/alistamientoUpdate",dataform,token).then((result) => {
        console.log(result);
        showData(result);
      });

    }
  }
});

tbodyTable.addEventListener("click", (e) => {
    e.preventDefault(); 
    let element = e.target;
    if (element.name === 'btnDownReg') {
        console.log(element);
        console.log(element);
		swal({
			title: 'CONFIRMAR',
			text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Cerrar',
			cancelButtonColor: '#fff',
			confirmButtonColor: '#3B3F5C',
			confirmButtonText: 'Aceptar'
		}).then(function(result) {
			if (result.value) {
                let id = element.getAttribute('data-id');
                console.log(id);
                const dataform = new FormData();
                dataform.append("id", Number(id));
                dataform.append("alistamientoId", Number(alistamientoId.value));
                dataform.append("centrocosto", Number(centrocosto.value));
                sendData("/alistamientodown",dataform,token).then((result) => {
                    console.log(result);
                    showData(result)
                })
			}

		})
    }
});

tfootTable.addEventListener('click', (e) => {
    e.preventDefault();
    let element = e.target;
    console.log(element);
    if (element.id === 'addShopping') {//added to inventory
        console.log("click");
        loadingStart(element)
        const dataform = new FormData();
        dataform.append("alistamientoId", Number(alistamientoId.value));
        dataform.append("newStockPadre", Number(newStockPadre.value));
        dataform.append("pesokg", Number(pesokg.value));
        dataform.append("stockPadre", Number(stockPadre.value));
        dataform.append("productoPadre", Number(productoPadre.value));
        dataform.append("centrocosto", Number(centrocosto.value));
        dataform.append("categoryId", Number(categoryId.value));
        sendData("/alistamientoAddShoping",dataform,token).then((result) => {
            console.log(result);
            if (result.status == 1) {
                loadingEnd(element,"success","Cargar al inventario")
                element.disabled = true;
                window.location.href = `/alistamiento`;
            }
            if (result.status == 0) {
                loadingEnd(element,"success","Cargar al inventario")
                errorMessage(result.message);
            }
        })
    }
})

//if (addShopping) {
    /*addShopping.addEventListener('click', (e) => {
        e.preventDefault();
        const dataform = new FormData();
        loadingStart(addShopping)
        dataform.append("alistamientoId", Number(alistamientoId.value));
        dataform.append("newStockPadre", Number(newStockPadre.value));
        dataform.append("pesokg", Number(pesokg.value));
        dataform.append("stockPadre", Number(stockPadre.value));

        sendData("/alistamientoAddShoping",dataform,token).then((result) => {
            console.log(result);
            loadingEnd(addShopping,"success","Cargar al inventario")
            //showData(result)
        })
    });*/
//}

/*selectCategoria.addEventListener("change", function() {
    const selectedValue = this.value;
    console.log("Selected value:", selectedValue);*/

    /*const dataform = new FormData();
    dataform.append("categoriaId", Number(selectedValue));
    sendData("/getproductos",dataform,token).then((result) => {
        console.log(result);
        let prod = result.products;
        console.log(prod);
        selectProducto.innerHTML = "";
        selectProducto.innerHTML += `<option value="">Seleccione el producto</option>`;
        prod.forEach(option => {
        const optionElement = document.createElement("option");
        optionElement.value = option.id;
        optionElement.text = option.name;
        selectProducto.appendChild(optionElement);
        });
    });*/

//});

/*tbodyTable.addEventListener("click", (e) => {
    e.preventDefault(); 
    let element = e.target;
    if (element.name === 'btnDown') {
        console.log(element);
		swal({
			title: 'CONFIRMAR',
			text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Cerrar',
			cancelButtonColor: '#fff',
			confirmButtonColor: '#3B3F5C',
			confirmButtonText: 'Aceptar'
		}).then(function(result) {
			if (result.value) {
                let id = element.getAttribute('data-id');
                console.log(id);
                const dataform = new FormData();
                dataform.append("id", Number(id));
                dataform.append("compensadoId", Number(compensado_id.value));
                sendData("/compensadodown",dataform,token).then((result) => {
                    console.log(result);
                    showData(result)
                })

			}

		})
    }

    if (element.name === 'btnEdit') {
        console.log(element);
        let id = element.getAttribute('data-id');
        console.log(id);
        const dataform = new FormData();
        dataform.append("id", Number(id));
        sendData("/compensadogetById",dataform,token).then((result) => {
            console.log(result);
            let editReg = result.reg;
            console.log(editReg);
            regDetail.value = editReg.id;
            pcompra.value = formatCantidadSinCero(editReg.pcompra);
            pesokg.value = formatCantidad(editReg.peso);
            $('.select2Prod').val(editReg.products_id).trigger('change');
        })
    }
});



pcompra.addEventListener("change", function() {
  const enteredValue = formatMoneyNumber(pcompra.value);
  console.log("Entered value: " + enteredValue);
  pcompra.value = formatCantidadSinCero(enteredValue);
});

pesokg.addEventListener("change", function() {
  const enteredValue = formatkg(pesokg.value);
  console.log("Entered value: " + enteredValue);
  pesokg.value = enteredValue;
});*/


