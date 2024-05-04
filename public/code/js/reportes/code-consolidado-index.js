import { sendData } from "../exportModule/core/rogercode-core.js";
import {
    successToastMessage,
    errorMessage,
} from "../exportModule/message/rogercode-message.js";
import {
    loadingStart,
    loadingEnd,
} from "../exportModule/core/rogercode-core.js";

console.log("Starting");

const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

var dataTable;

function initializeDataTable(centrocostoId = "-1", categoriaId = "-1") {
    dataTable = $("#tableInventory").DataTable({
        paging: true,
        pageLength: 150,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/showReportVentasPorProd",
            type: "GET",
            data: {
                centrocostoId: centrocostoId,
                categoriaId: categoriaId,
            },
        },
        columns: [
            { data: "product_code", name: "product_code" },
            {
                data: "product_name",
                name: "product_name",
                render: function (data) {
                    let subStringData = data.substring(0, 25).toLowerCase();
                    let capitalizedSubString =
                        subStringData.charAt(0).toUpperCase() +
                        subStringData.slice(1);
                    if (data.length > 25) {
                        return `<span style="font-size: smaller;" title="${data}">${capitalizedSubString}.</span>`;
                    } else {
                        /*   return `<span style="font-size: smaller;">${data.toLowerCase()}</span>`; */
                        return `<span style="font-size: smaller;">${capitalizedSubString}</span>`;
                    }
                },
            },
            { data: "category_name", name: "category_name" },
            { data: "cantidad_venta", name: "cantidad_venta" },
            { data: "notacredito_quantity", name: "notacredito_quantity" },
            { data: "notadebito_quantity", name: "notadebito_quantity" },
            { data: "cantidad_venta_real", name: "cantidad_venta_real" },
            {
                data: "dinero_venta_real",
                name: "dinero_venta_real",
                render: function (data, type, row) {
                    return "" + "$" + formatCantidadSinCero(data);
                },
            },
            {
                data: "descuento_producto",
                name: "descuento_producto",
                render: function (data, type, row) {
                    return "" + "$" + formatCantidadSinCero(data);
                },
            },
            {
                data: "descuento_cliente",
                name: "descuento_cliente",
                render: function (data, type, row) {
                    return "" + "$" + formatCantidadSinCero(data);
                },
            },
            {
                data: "sub_total",
                name: "sub_total",
                render: function (data, type, row) {
                    return "" + "$" + formatCantidadSinCero(data);
                },
            },
            {
                data: "impuesto_salud",
                name: "impuesto_salud",
                render: function (data, type, row) {
                    return "" + "$" + formatCantidadSinCero(data);
                },
            },
            {
                data: "iva",
                name: "iva",
                render: function (data, type, row) {
                    return "" + "$" + formatCantidadSinCero(data);
                },
            },
            {
                data: "total",
                name: "total",
                render: function (data, type, row) {
                    return "" + "$" + formatCantidadSinCero(data);
                },
            },
        ],
        order: [[1, "ASC"]],
        language: {
            processing: "Procesando...",
            lengthMenu: "Mostrar _MENU_ registros",
            zeroRecords: "No se encontraron resultados",
            emptyTable: "Ningún dato disponible en esta tabla",
            sInfo: "Mostrando del _START_ al _END_ de total _TOTAL_ registros",
            infoEmpty:
                "Mostrando registros del 0 al 0 de un total de 0 registros",
            infoFiltered: "(filtrado de un total de _MAX_ registros)",
            search: "Buscar:",
            infoThousands: ",",
            loadingRecords: "Cargando...",
            paginate: {
                first: "Primero",
                last: "Último",
                next: "Siguiente",
                previous: "Anterior",
            },
        },
        dom: "Bfrtip",
        buttons: ["copy", "csv", "excel", "pdf"],
        footerCallback: function (row, data, start, end, display) {
            var api = this.api();

            // Totalizar la columna "totalCantVent"
            var totalCantVent = api
                .column("cantidad_venta:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);

            // Totalizar la columna "cantidad notacredito"
            var totalCantNC = api
                .column("notacredito_quantity:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);

            // Totalizar la columna "cantidad nota debito"
            var totalCantND = api
                .column("notadebito_quantity:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);

            // Totalizar la columna "cantidad venta real"
            var totalCantVR = api
                .column("cantidad_venta_real:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);

            var totalDineroVR = api
                .column("dinero_venta_real:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);

            var totalDineroVRFormatted =
                "$" + formatCantidadSinCero(totalDineroVR);

            var totalDescProd = api
                .column("descuento_producto:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);
            var totalDescProdVRFormatted =
                "$" + formatCantidadSinCero(totalDescProd);

            var totalDescCliente = api
                .column("descuento_cliente:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);
            var totalDescClienteFormatted =
                "$" + formatCantidadSinCero(totalDescCliente);

            var totalSubTotal = api
                .column("sub_total:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);
            var totalSubTotalFormatted =
                "$" + formatCantidadSinCero(totalSubTotal);

            var totalImpSalud = api
                .column("impuesto_salud:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);
            var totalImpSaludFormatted =
                "$" + formatCantidadSinCero(totalImpSalud);

            var totalIva = api
                .column("iva:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);
            var totalIvaFormatted = "$" + formatCantidadSinCero(totalIva);

            var totalTotal = api
                .column("total:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);

            var totalTotalFormatted = "$" + formatCantidadSinCero(totalTotal);

            // Agregar los valores totales en el footer
            $(api.column("cantidad_venta:name").footer()).html(totalCantVent);
            $(api.column("notacredito_quantity:name").footer()).html(
                totalCantNC
            );
            $(api.column("notadebito_quantity:name").footer()).html(
                totalCantND
            );
            $(api.column("cantidad_venta_real:name").footer()).html(
                totalCantVR
            );
            $(api.column("dinero_venta_real:name").footer()).html(
                totalDineroVRFormatted
            );
            $(api.column("descuento_producto:name").footer()).html(
                totalDescProdVRFormatted
            );
            $(api.column("descuento_cliente:name").footer()).html(
                totalDescClienteFormatted
            );
            $(api.column("sub_total:name").footer()).html(totalSubTotalFormatted);
            $(api.column("impuesto_salud:name").footer()).html(totalImpSaludFormatted);
            $(api.column("iva:name").footer()).html(totalIvaFormatted);
            $(api.column("total:name").footer()).html(totalTotalFormatted);
        },
    });
}

$(document).ready(function () {
    initializeDataTable("-1");

    $("#centrocosto, #categoria").on("change", function () {
        var centrocostoId = $("#centrocosto").val();
        var categoriaId = $("#categoria").val();

        dataTable.destroy();
        initializeDataTable(centrocostoId, categoriaId);
        cargarTotales(centrocostoId, categoriaId);
    });
});

document
    .getElementById("cargarInventarioBtn")
    .addEventListener("click", (e) => {
        e.preventDefault();
        let element = e.target;
        showConfirmationAlert(element)
            .then((result) => {
                if (result && result.value) {
                    loadingStart(element);
                    const dataform = new FormData();

                    const var_centrocostoId =
                        document.querySelector("#centrocosto");
                    const var_categoriaId =
                        document.querySelector("#categoria");

                    dataform.append(
                        "centrocostoId",
                        Number(var_centrocostoId.value)
                    );
                    dataform.append(
                        "categoriaId",
                        Number(var_categoriaId.value)
                    );

                    return sendData("/cargarInventariohist", dataform, token);
                }
            })
            .then((result) => {
                console.log(result);
                if (result && result.status == 1) {
                    loadingEnd(element, "success", "Cargando al inventorio");
                    element.disabled = true;
                    return swal(
                        "EXITO",
                        "Inventario Cargado Exitosamente",
                        "success"
                    );
                }
                if (result && result.status == 0) {
                    loadingEnd(element, "success", "Cargando al inventorio");
                    errorMessage(result.message);
                }
            })
            .then(() => {
                window.location.href = "/inventory/consolidado";
            })
            .catch((error) => {
                console.error(error);
            });
    });

function showConfirmationAlert(element) {
    return swal.fire({
        title: "CONFIRMAR",
        text: "Estas seguro que desea cargar el inventario ?",
        icon: "warning",
        showDenyButton: true,
        showCancelButton: true,
        confirmButtonColor: "#3085d6",
        cancelButtonColor: "#d33",
        confirmButtonText: "Acpetar",
        denyButtonText: `Cancelar`,
    });
}
