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
const venta_id = document.querySelector("#ventaId");
const centrocosto_id = document.querySelector("#centrocosto_id");
const quantity = document.querySelector("#quantity");
const price = document.querySelector("#price");
const porc_descuento = document.querySelector("#porc_descuento");
const iva = document.querySelector("#iva");
const regDetail = document.querySelector("#regdetailId");
const tableFoot = document.querySelector("#tabletfoot");
const cargarInventarioBtn = document.getElementById("cargarInventarioBtn");
const btnRemove = document.querySelector("#btnRemove");

var centrocosto = document.getElementById("centrocosto").value;
console.log("centro " + centrocosto);

var cliente = document.getElementById("cliente").value;
console.log("cliente " + cliente);

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
    });
});

function actualizarValoresProducto(productId) {
    $.ajax({
        url: "/order-obtener-valores", // Reemplaza con tu ruta o URL para obtener los valores del producto
        type: "GET",
        data: {
            productId: productId,
            centrocosto: $("#centrocosto").val(), // Obtén el valor del campo centrocosto
            cliente: $("#cliente").val(), // Obtén el valor del campo centrocosto
        },
        success: function (response) {
            // Actualiza los valores en los campos de entrada 
            $("#price").val(response.precio);
            $("#porc_iva").val(response.iva);
            $("#porc_otro_impuesto").val(response.otro_impuesto);
            $("#porc_descuento").val(response.porc_descuento);
            $("#costo_prod").val(response.costo_prod);
        },
        error: function (xhr, status, error) {
            // Maneja el error si la solicitud AJAX falla
            console.log(error);
        },
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
                dataform.append("ventaId", Number(venta_id.value));
                sendData("/orderdown", dataform, token).then((result) => {
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
        sendData("/orderById", dataform, token).then((result) => {
            console.log(result);
            let editReg = result.reg;
            console.log(editReg);
            regDetail.value = editReg.id;
            price.value = formatCantidadSinCero(editReg.price);
            quantity.value = formatCantidad(editReg.quantity);
            observaciones.value = editReg.observaciones;

            $(".select2Prod").val(editReg.product_id).trigger("change");
        });
    }
});

btnAdd.addEventListener("click", (e) => {
    e.preventDefault();
    const dataform = new FormData(formDetail);
    sendData("/ordersavedetail", dataform, token).then((result) => {
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
                <td>${formatCantidad(element.quantity)}KG</td>              
                <td>$${formatCantidadSinCero(element.costo_prod)}</td>  
                <td>$${formatCantidadSinCero(element.price)}</td>  
                <td>${formatCantidad(element.porc_desc_prod)}%</td>
                <td>$${formatCantidadSinCero(element.descuento_prod)}</td> 
                <td>$${formatCantidadSinCero(element.descuento_cliente)}</td>
                <td>$${formatCantidadSinCero(element.total_bruto)}</td>  
                <td>$${formatCantidadSinCero(element.total_costo)}</td>  
                <td>$${formatCantidadSinCero(element.utilidad)}</td> 
                <td>${formatCantidad(element.porc_utilidad)}%</td>				
                <td>${formatCantidad(element.porc_iva)}%</td> 
                <td>$${formatCantidadSinCero(element.iva)}</td> 
                <td>${element.porc_otro_impuesto}%</td>     
                <td>${formatCantidadSinCero(
                    element.otro_impuesto
                )}</td>             
                <td>$${formatCantidadSinCero(element.total)}</td>  
                <td>${element.observaciones}</td>		
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
            <td></td>
            <th>$${formatCantidadSinCero(arrayTotales.TotalBruto)}</th> 
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>             
            <th>$${formatCantidadSinCero(
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

price.addEventListener("change", function () {
    const enteredValue = formatMoneyNumber(price.value);
    console.log("Entered value: " + enteredValue);
    price.value = formatCantidadSinCero(enteredValue);
});

quantity.addEventListener("change", function () {
    const enteredValue = formatkg(quantity.value);
    console.log("Entered value: " + enteredValue);
    quantity.value = enteredValue;
});

// Get the current date
const date = new Date();

// Create a dynamic password by combining letters and the current date
const passwordHoy =
    "admin" + date.getFullYear() + (date.getMonth() + 1) + date.getDate();

btnRemove.addEventListener("click", (e) => {
    e.preventDefault();
    const priceInput = document.querySelector("#price");
    const passwordInput = document.querySelector("#password");
    const password = passwordInput.value;

    // Check if the password is correct
    if (password === passwordHoy) {
        // Disable the readonly attribute of the price input field
        priceInput.removeAttribute("readonly");
    } else {
        // Set the readonly attribute of the price input field
        priceInput.setAttribute("readonly", true);
        // Display an error message
        alert("Contraseña incorrecta");
    }
});
