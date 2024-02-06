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
const venta_id = document.querySelector("#recibocajaId");
const centrocosto_id = document.querySelector("#centrocosto_id");
const quantity = document.querySelector("#quantity");
const price = document.querySelector("#price");
const total_bruto = document.querySelector("#total_bruto");
const iva = document.querySelector("#iva");
const regDetail = document.querySelector("#regdetailId");
const tableFoot = document.querySelector("#tabletfoot");
const cargarInventarioBtn = document.getElementById("cargarInventarioBtn");

/* var centrocosto = document.getElementById("centrocosto").value;
console.log("centro " + centrocosto); */

var cliente = document.getElementById("cliente").value;
console.log("cliente " + cliente);

$(".select2Prod").select2({
    placeholder: "Busca una factura",
    width: "100%",
    theme: "bootstrap-5",
    allowClear: true,
});

$(document).ready(function () {
    $("#producto").change(function () {
        var productId = $(this).val();
        // Llama a una función para actualizar los valores en función del producto seleccionado
        actualizarValoresProducto(productId);
    });
});

function actualizarValoresProducto(productId) {
    $.ajax({
        url: "/obtener-valores", // Reemplaza con tu ruta o URL para obtener los valores
        type: "GET",
        data: {
            productId: productId,
            centrocosto: $("#centrocosto").val(), // Obtén el valor del campo centrocosto
            cliente: $("#cliente").val(), // Obtén el valor del campo centrocosto
        },
        success: function (response) {
            // Actualiza los valores en los campos de entrada del centro de costo
            $("#price").val(response.precio);
            $("#porc_otro_impuesto").val(response.otro_impuesto);
            /*       $("#saldo_visual").val(formatCantidadSinCero(response.total_bruto)); */
            $("#saldo").val(formatCantidadSinCero(response.total_bruto));
            calculaSaldo();
        },
        error: function (xhr, status, error) {
            // Maneja el error si la solicitud AJAX falla
            console.log(error);
        },
    });
}

btnAdd.addEventListener("click", (e) => {
    e.preventDefault();
    const dataform = new FormData(formDetail);
    sendData("/salesavedetail", dataform, token).then((result) => {
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

const showData = (data) => {
    let dataAll = data.array;
    console.log(dataAll);
    showRegTbody.innerHTML = "";
    dataAll.forEach((element, indice) => {
        showRegTbody.innerHTML += `
            <tr>                              
                <td>${element.nameprod}</td>
                <td>${formatCantidad(element.quantity)} KG</td>
                <td>$ ${formatCantidadSinCero(element.price)}</td>  
                <td>${formatCantidadSinCero(element.porc_desc)}</td>
                <td>$ ${formatCantidadSinCero(element.descuento)}</td> 
                <td>$ ${formatCantidadSinCero(element.descuento_cliente)}</td>
                <td>$ ${formatCantidadSinCero(element.total_bruto)}</td>   
                <td>${formatCantidad(element.porc_iva)}%</td> 
                <td>$ ${formatCantidadSinCero(element.iva)}</td> 
                <td>${element.porc_otro_impuesto}%</td>     
                <td>$ ${formatCantidadSinCero(
                    element.otro_impuesto
                )}</td>             
                <td>$ ${formatCantidadSinCero(element.total)}</td>        
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
            <td></td>    
            <td></td>
            <td></td>                               
            <th>$ ${formatCantidadSinCero(arrayTotales.TotalBruto)}</th> 
            <td></td>
            <td></td>
            <td></td>
            <td></td>          
            <th>$ ${formatCantidadSinCero(
                arrayTotales.TotalValorAPagar
            )}</th>            
            <td class="text-center">
            
            </td>
        </tr>
    `;

    function showConfirmationAlert(element) {
        return swal.fire({
            title: "CONFIRMAR",
            text: "Estas seguro que desea facturar ?",
            icon: "warning",
            showDenyButton: true,
            showCancelButton: true,
            confirmButtonText: "Aceptar",
            denyButtonText: `Cancelar`,
        });
    }

    /*   // Evento click del botón "facturarBtn"
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
                        dataform.append("ventaId", Number(venta_id.value));
                        return sendData("/registrar_pago", dataform, token);
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
                    window.location.href = 'registrar_pago/{{$id}}';
                })
                .catch((error) => {
                    console.error(error);
                });
        }
    }); */
};

abono.addEventListener("change", function () {
    const enteredValue = formatMoneyNumber(abono.value);
    console.log("Entered value: " + enteredValue);
    abono.value = formatCantidadSinCero(enteredValue);
    calculaSaldo();
});

nuevo_saldo.addEventListener("change", function () {
    const enteredValue = formatMoneyNumber(nuevo_saldo.value);
    console.log("Entered value: " + enteredValue);
    nuevo_saldo.value = formatCantidadSinCero(enteredValue);
});

/* const totalSaldoInput = document.getElementById('total_bruto');

// Add an event listener for the 'input' event
totalBrutoInput.addEventListener('input', function() {
  // Get the value of the input field
  const totalBruto = this.value;

  // Check if the value is a number
  if (isNaN(totalBruto)) {
    // If the value is not a number, display an error message
    alert('Please enter a valid number.');
  } else {
    // If the value is a number, format it as currency
    const formattedTotalBruto = formatCantidadSinCero(total_bruto.value);

    // Update the display
    totalBrutoInput.value = formattedTotalBruto;
  }
}); */

/* const totalSaldoInput = document.getElementById("saldo");
console.log(totalSaldoInput);
const abonoInput = document.getElementById("abono");
const nuevoSaldoInput = document.getElementById("nuevo_saldo");

// Add an event listener for the 'input' event on the price input
abonoInput.addEventListener("input", function () {
    // Get the values of the total_bruto and abono inputs
    const totalSaldo = parseFloat(
        totalSaldoInput.value.replace(/[^0-9.]/g, "")
    );
    const abono = parseFloat(abonoInput.value.replace(/[^0-9.]/g, ""));
    console.log(totalSaldo);
    // Calculate the nuevo_saldo
    const nuevoSaldo = totalSaldo - abono;

    // Update the display
    nuevoSaldoInput.value = formatCantidadSinCero(nuevoSaldo);
}); */

function calculaSaldo() {
    let saldo = $("#saldo").val();
    console.log(saldo);
    saldo = parseFloat(saldo.replace(/[.]/g, ""));
    let abono = $("#abono").val();
    abono = parseFloat(abono.replace(/[.]/g, ""));
    const nuevoSaldoInput = document.getElementById("nuevo_saldo");
    if (isNaN(saldo) || isNaN(abono)) {
        // Handle invalid input
    } else {
        console.log(saldo);
        console.log(abono);
        // Calculate the nuevo_saldo
        let nuevoSaldo = saldo - abono;
        // Update the display
        nuevoSaldoInput.value = formatCantidadSinCero(nuevoSaldo);
    }
}
