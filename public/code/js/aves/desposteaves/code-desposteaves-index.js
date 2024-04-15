console.log("Starting desposte aves");
import { sendData } from "../../exportModule/core/rogercode-core.js";
import {
    successToastMessage,
    errorMessage,
} from "../../exportModule/message/rogercode-message.js";
import {
    loadingStart,
    loadingEnd,
} from "../../exportModule/core/rogercode-core.js";

const table = document.querySelector("#tableDesposteaves");
const beneficioId = document.querySelector("#beneficioId");
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const tableTbody = document.querySelector("#tbody");
const tableTfoot = document.querySelector("#tfoot");
const downReg = document.querySelector("#tableDesposteaves tbody");

table.addEventListener("keydown", function (event) {
    if (event.keyCode === 13 || event.keyCode === 9) {
        const target = event.target;
        if (target.tagName === "INPUT" && target.closest("tr")) {
            //Execute your code here
            console.log("Enter key pressed on an input inside a table row");
            console.log(event.target.value);
            console.log(event.target.id);

            const inputValue = event.target.value;
            if (inputValue == "") {
                return false;
            }
            const trimValue = inputValue.trim();
            const dataform = new FormData();
            dataform.append("id", Number(event.target.id));
            dataform.append("peso_kilo", Number(trimValue));
            dataform.append("beneficioId", Number(beneficioId.value));
            sendData("/desposteavesUpdate", dataform, token).then((result) => {
                console.log(result);
                showDataTable(result);

                const inputs = Array.from(
                    table.querySelectorAll("input[type='text']")
                ); // Cuando se envie la data, el cursor salte al siguiente input id="${element.id}"
                const currentIndex = inputs.findIndex(
                    (input) => input.id === target.id
                );
                const nextIndex = currentIndex + 1;
                if (nextIndex < inputs.length) {
                    const nextInput = inputs[nextIndex];
                    nextInput.focus();
                    nextInput.select();
                }
            });
        }
    }
});

const showDataTable = (data) => {
    //console.log(data);
    let dataRow = data.desposte;
    //console.log(dataRow);
    let dataTotals = data.arrayTotales;
    //console.log(dataTotals);
    let dataBeneficiores = data.beneficiores;
    //console.log(dataBeneficiores);

    tableTbody.innerHTML = "";
    dataRow.forEach((element) => {
        //console.log(element);
        tableTbody.innerHTML += `
			<tr>
				<td>${element.name} </td>
				<td>${element.porcdesposte}%</td>
        <td> <input type="text" class="form-control-sm" id="${
            element.id
        }" value="${element.peso}" placeholder="0" size="4"></td>
				<td>$${formatCantidadSinCero(element.precio)}</td>			
				<td>$${formatCantidadSinCero(element.totalventa)}</td>
				<td>${element.porcventa}%</td>
				<td>$${formatCantidadSinCero(element.costo)} </td>
        <td>$${formatCantidadSinCero(element.costo_kilo)}</td>
        <td>$${formatCantidadSinCero(element.utilidad)}</td>    
        <td>${formatCantidad(element.porcutilidad)}%</td>              
      	<td class="text-center">
					<button type="button" name="btnDownReg" data-id="${
                        element.id
                    }" class="btn btn-dark btn-sm fas fa-trash" title="Cancelar">
					</button>
				</td>
			</tr>
    `;
    });

    tableTfoot.innerHTML = "";
    tableTfoot.innerHTML += `
		<tr>
			<td>Totales</td>
			<td>${dataTotals.TotalDesposte}%</td>	
			<td>${formatCantidad(dataTotals.pesoTotalGlobal)}</td>
      <td>--</td>
			<td>$${formatCantidadSinCero(dataTotals.TotalVenta)}</td>
			<td>${dataTotals.porcVentaTotal}%</td>
			<td>$${formatCantidadSinCero(dataTotals.costoTotalGlobal)}</td>
      <td>--</td>	
      <td>$${formatCantidadSinCero(dataTotals.TotalUtilidad)}</td>			
      <td>${formatCantidad(dataTotals.PorcUtilidad)}%</td>			
			<td class="text-center">
       <button id="cargarInventarioBtn" class="btn btn-success btn-sm">Cargar al inventario</button>
			</td>
		</tr>
    <tr>
				<td>MERMA</td>
				<td></td>
        <td>${formatCantidad(dataTotals.Merma)}</td>										
		</tr>
		<tr>
    	<td>%.MERMA</td>
			<td></td>
      <td>${formatCantidad(dataTotals.PorcMerma)}</td>										
		</tr>
  `;

    // Función para mostrar el SweetAlert de confirmación
    function showConfirmationAlert(element) {
        return swal.fire({
            title: "CONFIRMAR",
            text: "Estas seguro desea cargar el inventario ?",
            icon: "warning",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Acpetar",
            denyButtonText: `Cancelar`,
        });
    }

    // Evento click del botón "cargarInventarioBtn"
    tableTfoot.addEventListener("click", (e) => {
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
                        dataform.append(
                            "beneficioId",
                            Number(beneficioId.value)
                        );
                        return sendData("/cargarInventarioa", dataform, token);
                    }
                })
                .then((result) => {
                    console.log(result);
                    if (result && result.status == 1) {
                        loadingEnd(
                            element,
                            "success",
                            "Cargando al inventorio"
                        );
                        element.disabled = true;
                        return swal(
                            "EXITO",
                            "Inventario Cargado Exitosamente",
                            "success"
                        );
                    }
                    if (result && result.status == 0) {
                        loadingEnd(
                            element,
                            "success",
                            "Cargando al inventorio"
                        );
                        errorMessage(result.message);
                    }
                })
                .then(() => {
                    window.location.href = "/beneficioaves";
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    });
};
document
    .getElementById("cargarInventarioBtn")
    .addEventListener("click", function () {
        const beneficioId = document.querySelector("#beneficioId");
        cargarInventario(beneficioId);
    });

document
    .querySelector("#tableDespostere tbody")
    .addEventListener("click", (e) => {
        //console.log('Row clicked');
        //console.log(e.target);
        let element = e.target;
        if (element.name === "btnDownReg") {
            //console.log(element);
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
                    //console.log(id);
                    let url = "/getpaymentmoney/";
                    let btnId = element.getAttribute("id");

                    const dataform = new FormData();
                    dataform.append("id", Number(id));
                    dataform.append("beneficioId", Number(beneficioId.value));
                    sendData("/downdesposter", dataform, token).then(
                        (result) => {
                            //console.log(result);
                            showDataTable(result);
                        }
                    );
                }
            });
        }
    });
