import { sendData } from "../exportModule/core/rogercode-core.js";
import {
    successToastMessage,
    errorMessage,
} from "../exportModule/message/rogercode-message.js";
import {
    loadingStart,
    loadingEnd,
} from "../exportModule/core/rogercode-core.js";
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const formDetail = document.querySelector("#form-detail");
const btnAdd = document.querySelector("#btnAdd");
const showRegTbody = document.querySelector("#tbodyDetail");
let tbodyTable = document.querySelector("#tableDespostere tbody");
const compensado_id = document.querySelector("#compensadoId");
const centrocosto_id = document.querySelector("#centrocosto_id");
const pesokg = document.querySelector("#pesokg");
const pcompra = document.querySelector("#pcompra");
const regDetail = document.querySelector("#regdetailId");
const tableFoot = document.querySelector("#tabletfoot");
const cargarInventarioBtn = document.getElementById('cargarInventarioBtn');

cargarInventarioBtn.addEventListener('click', showConfirmationAlert);

$(".select2Prod").select2({
    placeholder: "Busca un producto",
    width: "100%",
    theme: "bootstrap-5",
    allowClear: true,
});

function showConfirmationAlert(element) {
    return swal.fire({
        title: "CONFIRMAR",
        text: "Estas seguro que desea cargar el inventario ?",
        icon: "warning",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonText: "Aceptar",
        denyButtonText: `Cancelar`,
    });
}

tbodyTable.addEventListener("click", (e) => {
    e.preventDefault();
    let element = e.target;
    if (element.name === "btnDown") {
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
                dataform.append("compensadoId", Number(compensado_id.value));
                sendData("/compensadodown", dataform, token).then((result) => {
                    console.log(result);
                    showData(result);
                });
            }
        });
    }
    if (element.name === "btnEdit") {
        console.log(element);
        let id = element.getAttribute("data-id");
        console.log(id);
        const dataform = new FormData();
        dataform.append("id", Number(id));
        sendData("/compensadogetById", dataform, token).then((result) => {
            console.log(result);
            let editReg = result.reg;
            console.log(editReg);
            regDetail.value = editReg.id;
            pcompra.value = formatCantidadSinCero(editReg.pcompra);
            pesokg.value = formatCantidad(editReg.peso);
            $(".select2Prod").val(editReg.products_id).trigger("change");
        });
    }
});

btnAdd.addEventListener("click", (e) => {
    e.preventDefault();
    const dataform = new FormData(formDetail);
    sendData("/compensadosavedetail", dataform, token).then((result) => {
        console.log(result);
        if (result.status === 1) {
            $("#producto").val("").trigger("change");
            formDetail.reset();
            showData(result);
        }
        if (result.status === 0) {
            Swal("Error!", "Tiene campos vacios!", "error");
        }
    });
});
   //<td>${formatDate(element.created_at)}</td>

const showData = (data) => {
    let dataAll = data.array;
    console.log(dataAll);
    showRegTbody.innerHTML = "";
    dataAll.forEach((element, indice) => {
        showRegTbody.innerHTML += `
            <tr>             
                <td>${element.code}</td>
                <td>${element.nameprod}</td>
                <td>$ ${formatCantidadSinCero(element.pcompra)}</td>
                <td>${formatCantidad(element.peso)} KG</td>
                <td>$ ${formatCantidadSinCero(element.subtotal)}</td>
                <td>${element.iva}</td>
                <td class="text-center">
                    <button class="btn btn-dark fas fa-edit" data-id="${
                        element.id
                    }" name="btnEdit" title="Editar"></button>
                    <button class="btn btn-dark fas fa-trash" name="btnDown" data-id="${
                        element.id
                    }" title="Borrar"></button>
                </td>
            </tr>
        `;
    });
    let arrayTotales = data.arrayTotales;
    console.log(arrayTotales);
    tableFoot.innerHTML = "";
    tableFoot.innerHTML += `
        <tr>
            <th>Totales</th>
            <td></td>
            <td></td>           
            <th>${formatCantidad(arrayTotales.pesoTotalGlobal)} KG</td>
            <th>$ ${formatCantidadSinCero(arrayTotales.totalGlobal)}</th>
            <td></td>
            <td class="text-center">
            <button id="cargarInventarioBtn" class="btn btn-success btn-sm">Cargar al inventario</button>
            </td>
        </tr>
    `;

    tableFoot.addEventListener("click", (e) => {
        e.preventDefault();
        let element = e.target;
        console.log(element);
        if (element.id === "cargarInventarioBtn") {
            showConfirmationAlert(element)
                .then((result) => {
                    if (result && result.value) {
                        loadingStart(element);
                        const dataform = new FormData();
                        dataform.append(
                            "compensadoId",
                            Number(compensado_id.value)
                        );
                        return sendData("/compensadoInvres", dataform, token);
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
                    window.location.href = "/compensado";
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    });
};

pcompra.addEventListener("change", function () {
    const enteredValue = formatMoneyNumber(pcompra.value);
    console.log("Entered value: " + enteredValue);
    pcompra.value = formatCantidadSinCero(enteredValue);
});

pesokg.addEventListener("change", function () {
    const enteredValue = formatkg(pesokg.value);
    console.log("Entered value: " + enteredValue);
    pesokg.value = enteredValue;
});