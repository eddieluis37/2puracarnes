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
const tableWorkshop = document.querySelector("#tableWorkshop");
const tbodyTable = document.querySelector("#tableWorkshop tbody");
const tfootTable = document.querySelector("#tableWorkshop tfoot");

pesoProductoPadre;

const stockPadre = document.querySelector("#stockCortePadre");
const pesokg = document.querySelector("#pesokg");
const merma = document.querySelector("#merma");

const newStockPadre = document.querySelector("#newStockPadre");
const meatcutId = document.querySelector("#meatcutId");
const tableFoot = document.querySelector("#tabletfoot");
const selectProducto = document.getElementById("producto");
const selectCategoria = document.querySelector("#productoCorte");
const btnAddWork = document.querySelector("#btnAddWorkshop");
const tallerId = document.querySelector("#tallerId");
const peso_producto_hijo = document.querySelector("#peso_producto_hijo");
const porcventa = document.querySelector("#porcventa");
const addShopping = document.querySelector("#addShopping");
const productoPadre = document.querySelector("#productopadreId");
const centrocosto = document.querySelector("#centrocosto");
const categoryId = document.querySelector("#categoryId");
var costoKiloPadre = document
    .getElementById("costoKiloPadre")
    .getAttribute("data-id");

console.log("costoKiloPadre = " + costoKiloPadre);
/* $porcventa = 0; */

$(".select2Prod").select2({
    placeholder: "Busca un producto",
    width: "100%",
    theme: "bootstrap-5",
    allowClear: true,
});
$(".select2ProdHijos").select2({
    placeholder: "Busca hijos",
    width: "100%",
    theme: "bootstrap-5",
    allowClear: true,
});
const dataform = new FormData();
dataform.append("categoriaId", Number(meatcutId.value));
sendData("/getproductos", dataform, token).then((result) => {
    console.log(result);
    let prod = result.products;
    console.log(prod);
    selectProducto.innerHTML = "";
    selectProducto.innerHTML += `<option value="">Seleccione el producto</option>`;
    prod.forEach((option) => {
        const optionElement = document.createElement("option");
        optionElement.value = option.id;
        optionElement.text = option.name;
        selectProducto.appendChild(optionElement);
    });
});
btnAddWork.addEventListener("click", (e) => {
    e.preventDefault();
    const dataform = new FormData(formDetail);
    //  dataform.append("stockPadre", stockPadre.value);
    dataform.append("peso_producto_hijo", peso_producto_hijo.value);

    var costoKiloPadre = document
        .getElementById("costoKiloPadre")
        .getAttribute("data-id");
    dataform.append("costo_kilo_padre", costoKiloPadre);
    console.log(costoKiloPadre);
    let porcventa = 1; // Initializing porcventa to 0
    dataform.append("porcventa", porcventa.value);

    sendData("/workshopsavedetail", dataform, token).then((result) => {
        console.log(result);
        if (result.status === 1) {
            $("#producto").val("").trigger("change");
            formDetail.reset();
            showData(result);
            location.reload();           
        }
        if (result.status === 0) {
            errorMessage("Tienes campos vacios");
        }
    });
});
const showData = (data) => {
    console.log(data);
    let dataAll = data.array;
    console.log(dataAll);
    showRegTbody.innerHTML = "";
    dataAll.forEach((element, indice) => {
        showRegTbody.innerHTML += `
    	    <tr>      	  
      	    <td>${element.code}</td>
      	    <td>${element.nameprod}</td>           
            <td>$ ${formatCantidadSinCero(element.precio)}</td>
            <td>
            <input type="text" class="form-control-sm" data-id="${
                element.products_id
            }" id="${element.id}" value="${
            element.peso_producto_hijo
        }" placeholder="Ingresar" size="4">
            </td>
      	    <td>$ ${formatCantidadSinCero(element.total)}</td>
      	    <td>${formatCantidad(element.porcventa)} %</td>      	    
      	    <td>$ ${formatCantidadSinCero(element.costo)}</td>
            <td>$ ${formatCantidadSinCero(element.costo_kilo)}</td>
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
    //  console.log('Console ' + arrayTotales);
    tableFoot.innerHTML = "";
    tableFoot.innerHTML += `
	    <tr>
		    <th>Merma</th>
            <th>${formatCantidad(arrayTotales.totalMerma)}</th>		
		    <td></td>		
		    <th>${formatCantidad(arrayTotales.totalPesoProductoHijo)} KG</td>
		    <th>$ ${formatCantidadSinCero(arrayTotales.totalPrecioVenta)}</th>
            <th>U.$ ${formatCantidadSinCero(arrayTotales.totalUtilidad)}</th>
            <th>${formatCantidad(arrayTotales.porcUtilidad)} %.U</td>
            <td></td>	
            <td class="text-center">
            <button id="cargarInventarioBtn" class="btn btn-success btn-sm">Afectar costos</button>
            </td>   
	    </tr>
    `;
    let newTotalStockPadre =
        pesoProductoPadre.value - arrayTotales.totalPesoProductoHijo;
    //  newStockPadre.value = newTotalStockPadre;

    tableFoot.addEventListener("click", (e) => {
        e.preventDefault();
        let element = e.target;
        console.log(element);
        if (element.id === "cargarInventarioBtn") {
            console.log("click");
            showConfirmationAlert(element)
                .then((result) => {
                    if (result && result.value) {
                        loadingStart(element);
                        const dataform = new FormData();
                        dataform.append("tallerId", Number(tallerId.value));
                        return sendData("/afectarCostos", dataform, token);
                    }
                })
                .then((result) => {
                    console.log(result);
                    if (result && result.status == 1) {
                        loadingEnd(element, "success", "Afectando a costos");
                        element.disabled = true;
                        return swal(
                            "EXITO",
                            "Costos afectado exitosamente",
                            "success"
                        );
                    }
                    if (result && result.status == 0) {
                        loadingEnd(element, "success", "Afectando a costos");
                        errorMessage(result.message);
                    }
                })
                .then(() => {
                    window.location.href = "/workshop";
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    });

    function showConfirmationAlert(element) {
        return swal.fire({
            title: "CONFIRMAR",
            text: "Estas seguro que desea afectar a costos ?",
            icon: "warning",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Acpetar",
            denyButtonText: `Cancelar`,
        });
    }
};

peso_producto_hijo.addEventListener("change", function () {
    const enteredValue = formatkg(peso_producto_hijo.value);
    console.log("Entered value: " + enteredValue);
    peso_producto_hijo.value = enteredValue;
});

tableWorkshop.addEventListener("keydown", function (event) {
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
            console.log("prod test id: " + tallerId.value);
            console.log(productoId);
            console.log(centrocosto.value);
            const trimValue = inputValue.trim();
            const dataform = new FormData();
            dataform.append("id", Number(event.target.id));
            dataform.append("newpeso_producto_hijo", Number(trimValue));
            dataform.append("tallerId", Number(tallerId.value));
            dataform.append("productoId", Number(productoId));
            dataform.append("centrocosto", Number(centrocosto.value));
            dataform.append("pesoProductoPadre", pesoProductoPadre.value);

            sendData("/workshopUpdate", dataform, token).then((result) => {
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
                dataform.append("tallerId", Number(tallerId.value));
                dataform.append("centrocosto", Number(centrocosto.value));
                dataform.append("pesoProductoPadre", pesoProductoPadre.value);
                sendData("/workshopdown", dataform, token).then((result) => {
                    console.log(result);
                    showData(result);
                });
            }
        });
    }
});

tfootTable.addEventListener("click", (e) => {
    e.preventDefault();
    let element = e.target;
    console.log(element);
    if (element.id === "addShopping") {
        //added to inventory
        console.log("click");
        loadingStart(element);
        const dataform = new FormData();
        dataform.append("tallerId", Number(tallerId.value));
        /*  dataform.append("newStockPadre", Number(newStockPadre.value)); */
        dataform.append("pesokg", Number(pesokg.value));
        dataform.append("pesoProductoPadre", Number(pesoProductoPadre.value));
        dataform.append("productoPadre", Number(productoPadre.value));
        dataform.append("centrocosto", Number(centrocosto.value));
        dataform.append("categoryId", Number(categoryId.value));
        sendData("/alistamientoAddShoping", dataform, token).then((result) => {
            console.log(result);
            if (result.status == 1) {
                loadingEnd(element, "success", "Cargar al inventario");
                element.disabled = true;
                window.location.href = `/alistamiento`;
            }
            if (result.status == 0) {
                loadingEnd(element, "success", "Cargar al inventario");
                errorMessage(result.message);
            }
        });
    }
});

if (!sessionStorage.getItem("pageLoaded")) {
    sessionStorage.setItem("pageLoaded", "true");
    location.reload();
}

/* window.onload = function() {
    location.reload();
} */

/* if (!document.cookie.includes('pageLoaded=true')) {
    document.cookie = 'pageLoaded=true; expires=Fri, 31 Dec 9999 23:59:59 GMT';
    location.reload();
} */

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
