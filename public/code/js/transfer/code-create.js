import { sendData } from "../../../rogercode/js/exportModule/core/rogercode-core.js";
import {
    successToastMessage,
    errorMessage,
} from "../../../rogercode/js/exportModule/message/rogercode-message.js";
import {
    loadingStart,
    loadingEnd,
} from "../../../rogercode/js/exportModule/core/rogercode-core.js";
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const formDetail = document.querySelector("#form-detail");
const showRegTbody = document.querySelector("#tbodyDetail");
const tableTransfer = document.querySelector("#tableTransfer");
const tbodyTable = document.querySelector("#tableTransfer tbody");
const tfootTable = document.querySelector("#tableTransfer tfoot");
const stockPadre = document.querySelector("#stockCortePadre");
const pesokg = document.querySelector("#pesokg");

const newStockOrigen = document.querySelector("#newStockOrigen");
const meatcutId = document.querySelector("#meatcutId");
const tableFoot = document.querySelector("#tabletfoot");
const selectProducto = document.getElementById("producto");
const selectCategoria = document.querySelector("#productoCorte");
const btnAddTrans = document.querySelector("#btnAddTransfer");
const transferId = document.querySelector("#transferId");
const kgrequeridos = document.querySelector("#kgrequeridos");
const addShopping = document.querySelector("#addShopping");
const productoPadre = document.querySelector("#productopadreId");
const centrocostoOrigen = document.querySelector("#centrocostoOrigen");
const centrocostoDestino = document.querySelector("#centrocostoDestino");
const categoryId = document.querySelector("#categoryId");

// Obtén el valor del campo
var centrocostoOrigenId = document.getElementById("centrocostoOrigen").value;
var centrocostoDestinoId = document.getElementById("centrocostoDestino").value;

console.log('origen ' + centrocostoOrigenId);
console.log('destino ' + centrocostoDestinoId);
console.log('pesokg ' + pesokg);
console.log('stockOrigen ' + stockOrigen.value);


$(".select2Prod").select2({
    placeholder: "Busca un producto",
    width: "100%",
    theme: "bootstrap-5",
    allowClear: true,
});

$(document).ready(function () {
    $("#producto").change(function () {
        var productId = $(this).val();
        // Llama a una función para actualizar los valores en función del producto seleccionado
        actualizarValoresProducto(productId);
        actualizarValoresProductoDestino(productId);
    });
});

function actualizarValoresProducto(productId) {
    $.ajax({
        url: "/obtener-valores-producto", // Reemplaza con tu ruta o URL para obtener los valores del producto
        type: "GET",
        data: {
            productId: productId,
            centrocostoOrigen: $("#centrocostoOrigen").val(), // Obtén el valor del campo centrocostoOrigen
        },
        success: function (response) {
            // Actualiza los valores en los campos de entrada del centro de costo origen
            $("#stockOrigen").val(response.stock);
            $("#pesoKgOrigen").val(response.fisico);
        },
        error: function (xhr, status, error) {
            // Maneja el error si la solicitud AJAX falla
            console.log(error);
        },
    });
}

function actualizarValoresProductoDestino(productId) {
    $.ajax({
        url: "/obtener-valores-producto-destino", // Reemplaza con tu ruta o URL para obtener los valores del producto
        type: "GET",
        data: {
            productId: productId,
            centrocostoDestino: $("#centrocostoDestino").val(), // Obtén el valor del campo centrocostoDestino
        },
        success: function (response) {
            // Actualiza los valores en los campos de entrada del centro de consto destino
            $("#stockDestino").val(response.stock);
            $("#pesoKgDestino").val(response.fisico);
        },
        error: function (xhr, status, error) {
            // Maneja el error si la solicitud AJAX falla
            console.log(error);
        },
    });
}

/* Insertar registros al tableTransfer del detalle. Se activa al darle enter en KG a trasladar o boton btnAddTransfer */
btnAddTrans.addEventListener("click", (e) => {
    e.preventDefault();
    const dataform = new FormData(formDetail);
    dataform.append("stockOrigen", stockOrigen.value);
    dataform.append("centrocostoDestino", centrocostoDestino.value);
    dataform.append("stockDestino", stockDestino.value);
    sendData("/transfersavedetail", dataform, token).then((result) => {
        console.log(result);
        if (result.status === 1) {
            $("#producto").val("").trigger("change");
            formDetail.reset();
            showData(result);
        }
        if (result.status === 0) {
            errorMessage("Tienes vacios");
        }
    });
});

{
    /* <tbody id="tbodyDetail"></tbody> insertado con transfersavedetail a la vista create http://2puracarnes.test:8080/transfer/create/4 */
}

const showData = (data) => {
    let dataAll = data.array;
    console.log(dataAll);
    showRegTbody.innerHTML = "";
    dataAll.forEach((element, indice) => {
        showRegTbody.innerHTML += `
    	    <tr>      	
      	    <td>${element.code}</td>
      	    <td>${element.nameprod}</td>
      	    <td>${formatCantidad(element.stock)} KG</td>
              <td>
              <input type="text" class="form-control-sm" data-id="${
                  element.products_id
              }" id="${element.id}" value="${
            element.kgrequeridos
        }" placeholder="Ingresar" size="10">
              </td>
      	    <td>${formatCantidad(element.nuevo_stock_origen)} KG</td>
      	    
      	    <td>${formatCantidad(element.actual_stock_destino)} KG</td>
            <td>${formatCantidad(element.nuevo_stock_destino)} KG</td>
			<td class="text-center">
				<button class="btn btn-dark fas fa-trash" name="btnDownReg" data-id="${
                    element.id
                }" title="Borrar" >
				</button>
			</td>
    	    </tr>
	    `;
    });

    let arrayTotales = data.arrayTotales;
    console.log(arrayTotales);
    tableFoot.innerHTML = "";
    tableFoot.innerHTML += `
	    <tr>
		    <td></td>
		    <td></td>           
		    <th>Totales</th>		  		   
		    <th>${formatCantidad(arrayTotales.kgTotalRequeridos)} KG</td>
		    <th>${formatCantidad(arrayTotales.newTotalStock)} KG</th>
            <td></td>
            <td></td>	    
		    <td class="text-center">
                <button class="btn btn-success btn-sm" id="addShopping">Afectar inventario</button>
            </td>
	    </tr>
    `;
    /*  let newTotalStockPadre = stockOrigen.value - arrayTotales.kgTotalRequeridos;
    newStockOrigen.value = newTotalStockPadre; */
    newStockOrigen.value = newTotalStock;
};

kgrequeridos.addEventListener("change", function () {
    const enteredValue = formatkg(kgrequeridos.value);
    console.log("Entered value: " + enteredValue);
    kgrequeridos.value = enteredValue;
});

tableTransfer.addEventListener("keydown", function (event) {
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

            let productoId = target.getAttribute("data-id");
            console.log("prodDestino test id: " + transferId.value);
            console.log(productoId);
            console.log('origen' + centrocostoOrigen.value);
            console.log(centrocostoDestino.value);
            const trimValue = inputValue.trim();
            const dataform = new FormData();
            dataform.append("id", Number(event.target.id));
            dataform.append("newkgrequeridos", Number(trimValue));
            dataform.append("transferId", Number(transferId.value));
            dataform.append("productoId", Number(productoId));
            dataform.append(
                "centrocostoOrigen",
                Number(centrocostoOrigen.value)
            );
            dataform.append(
                "centrocostoDestino",
                Number(centrocostoDestino.value)
            );
            dataform.append("stockOrigen", stockOrigen.value);

            sendData("/transferUpdate", dataform, token).then((result) => {
                console.log(result);
                showData(result);
            });
        }
    }
});

tbodyTable.addEventListener("click", (e) => {
    e.preventDefault();
    let element = e.target;
    if (element.name === "btnDownReg") {
        console.log(element);
        console.log(element);
        swal({
            title: "CONFIRMAR",
            text: "¿CONFIRMAS ELIMINAR EL REGISTRO?",
            type: "warning",
            showCancelButton: true,
            cancelButtonText: "Cerrar",
            cancelButtonColor: "#fff",
            confirmButtonColor: "#3B3F5C",
            confirmButtonText: "Aceptar",
        }).then(function (result) {
            if (result.value) {
                let id = element.getAttribute("data-id");
                console.log(id);
                const dataform = new FormData();
                dataform.append("id", Number(id));
                dataform.append("transferId", Number(transferId.value));
                dataform.append(
                    "centrocostoOrigen",
                    Number(centrocostoOrigen.value)
                );
                dataform.append(
                    "centrocostoDestino",
                    Number(centrocostoDestino.value)
                );
                dataform.append("stockOrigen", stockOrigen.value);
                sendData("/transferdown", dataform, token).then((result) => {
                    console.log(result);
                    showData(result);
                });
            }
        });
    }
});

/* Accciona el boton Cargar Inventario */
tfootTable.addEventListener("click", (e) => {
    e.preventDefault();
    let element = e.target;
    console.log(element);
    if (element.id === "addShopping") {
        //added to inventory
        console.log("click");
        loadingStart(element);
        const dataform = new FormData();
        dataform.append("transferId", Number(transferId.value));

     
       // dataform.append("newStockOrigen", Number(newStockOrigen.value));
      //  dataform.append("pesokg", Number(pesokg.value));
        dataform.append("stockOrigen", Number(stockOrigen.value));
     //   dataform.append("productoPadre", Number(productoPadre.value));
        dataform.append("centrocostoOrigen", Number(centrocostoOrigen.value));
        dataform.append("centrocostoDestino", Number(centrocostoDestino.value));
     //   dataform.append("categoryId", Number(categoryId.value));
        sendData("/transferAddShoping", dataform, token).then((result) => {
            console.log(result);
            if (result.status == 1) {
                loadingEnd(element, "success", "Cargar al inventario");
                element.disabled = true;
                window.location.href = `/transfer`;
            }
            if (result.status == 0) {
                loadingEnd(element, "success", "Cargar al inventario");
                errorMessage(result.message);
            }
        });
    }
});

document.getElementById('addShopping').addEventListener('click', function() {
    Swal.fire({
      title: 'Confirmación',
      text: '¿Desea afectar el inventario?',
      icon: 'warning',
      showCancelButton: true,
      confirmButtonColor: '#3085d6',
      cancelButtonColor: '#d33',
      confirmButtonText: 'Aceptar',
      cancelButtonText: 'Cancelar'
    }).then((result) => {
      if (result.isConfirmed) {
        // Affect inventory logic here
      }
    });
  });
