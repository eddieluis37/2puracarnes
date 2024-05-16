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

function initializeDataTable(startDateId = "-1", endDateId = "-1") {
    dataTable = $("#tableInventory").DataTable({
        paging: false,
        pageLength: 150,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/showReportComprasPorProvee",
            type: "GET",
            data: {
                startDateId: startDateId,
                endDateId: endDateId,
            },
        },
        columns: [
            {
                data: "fecha_compra",
                name: "fecha_compra",
                render: function (data, type, row) {
                    return (
                        "<div style='text-align: center;'>" + data + "</div>"
                    );
                },
            },
            {
                data: "factura_compra",
                name: "factura_compra",
                render: function (data, type, row) {
                    return (
                        "<div style='text-align: center;'>" + data + "</div>"
                    );
                },
            },
            {
                data: "nombre_proveedor",
                name: "nombre_proveedor",
                render: function (data) {
                    let subStringData = data.substring(0, 25).toLowerCase();
                    let capitalizedSubString =
                        subStringData.charAt(0).toUpperCase() +
                        subStringData.slice(1);
                    if (data.length > 25) {
                        return `<span style="font-size: smaller;" title="${data}">${capitalizedSubString}.</span>`;
                    } else {
                        /*   return `<span style="font-size: smaller;">${data.toLowerCase()}</span>`; */
                        return `<span style="font-size: smaller; display: block; text-align: center;">${capitalizedSubString}</span>`;
                    }
                },
            },
            {
                data: "product_code",
                name: "product_code",
                render: function (data, type, row) {
                    return "<div style='text-align: right;'>" + data + "</div>";
                },
            },
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
                        return `<span style="font-size: smaller; display: block; text-align: center;">${capitalizedSubString}</span>`;
                    }
                },
            },
            {
                data: "category_name",
                name: "category_name",
                render: function (data, type, row) {
                    return (
                        "<div style='text-align: center;'>" + data + "</div>"
                    );
                },
            },
            {
                data: "cant_compras_lote",
                name: "cant_compras_lote",
                render: function (data, type, row) {
                    // Verificar si el valor es NaN y devolver 0 en ese caso
                    if (isNaN(data)) {
                        data = 0;
                    }

                    return (
                        "<div style='text-align: right;'>" +
                        formatCantidad(data) +
                        "</div>"
                    );
                },
            },
            {
                data: "costo_compras_lote",
                name: "costo_compras_lote",
                render: function (data, type, row) {
                    return (
                        "<div style='text-align: right;'>$" +
                        formatCantidadSinCero(data) +
                        "</div>"
                    );
                },
            },
            {
                data: "cant_compras_comp",
                name: "cant_compras_comp",
                render: function (data, type, row) {
                    return (
                        "<div style='text-align: right;'>" +
                        formatCantidad(data) +
                        "</div>"
                    );
                },
            },
            {
                data: "precio_compras_comp",
                name: "precio_compras_comp",
                render: function (data, type, row) {
                    return (
                        "<div style='text-align: right;'>$" +
                        formatCantidadSinCero(data) +
                        "</div>"
                    );
                },
            },
            {
                data: "subtotal_compras_comp",
                name: "subtotal_compras_comp",
                render: function (data, type, row) {
                    return (
                        "<div style='text-align: right;'>$" +
                        formatCantidadSinCero(data) +
                        "</div>"
                    );
                },
            },
            /* {
                data: "total_cantidades",
                name: "total_cantidades",
                render: function (data, type, row) {
                    return (
                        "<div style='text-align: right;'>" +
                        formatCantidad(data) +
                        "</div>"
                    );
                },
            },
            {
                data: "total_costo",
                name: "total_costo",
                render: function (data, type, row) {
                    return (
                        "<div style='text-align: right;'>$" +
                        formatCantidadSinCero(data) +
                        "</div>"
                    );
                },
            },
            {
                data: "costo_promedio",
                name: "costo_promedio",
                render: function (data, type, row) {
                    return (
                        "<div style='text-align: right;'>$" +
                        formatCantidadSinCero(data) +
                        "</div>"
                    );
                },
            }, */
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

            var totalCantComprasLote = api
                .column("cant_compras_lote:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);
            var totalCantComprasLoteFormatted =
                formatCantidad(totalCantComprasLote);

            var totalCostoComprasLote = api
                .column("costo_compras_lote:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);
            var totalCostoComprasCompFormatted =
                "$" + formatCantidadSinCero(totalCostoComprasLote);

            var totalCantComprasComp = api
                .column("cant_compras_comp:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);
            var totalCantComprasCompFormatted =
                formatCantidad(totalCantComprasComp);

            var totalPrecioComprasComp = api
                .column("precio_compras_comp:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);
            var totalPrecioComprasCompFormatted =
                "$" + formatCantidadSinCero(totalPrecioComprasComp);

            var totalSubtotalComprasComp = api
                .column("subtotal_compras_comp:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);
            var totalSubtotalComprasCompFormatted =
                "$" + formatCantidadSinCero(totalSubtotalComprasComp);

            /*    var totalCant = api
                .column("total_cantidades:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);
            var totalCantFormatted = formatCantidad(totalCant);

            var totalTotalCosto = api
                .column("total_costo:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);
            var totalTotalCostoFormatted =
                "$" + formatCantidadSinCero(totalTotalCosto);

            var totalCostoPromd = api
                .column("costo_promedio:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);
            var totalCostoPromdFormatted =
                "$" + formatCantidadSinCero(totalCostoPromd);
 */
            // Agregar los valores totales en el footer
            $(api.column("cant_compras_lote:name").footer())
                .html(totalCantComprasLoteFormatted)
                .css("text-align", "right");

            $(api.column("costo_compras_lote:name").footer())
                .html(totalCostoComprasCompFormatted)
                .css("text-align", "right");

            $(api.column("cant_compras_comp:name").footer())
                .html(totalCantComprasCompFormatted)
                .css("text-align", "right");

            $(api.column("precio_compras_comp:name").footer())
                .html(totalPrecioComprasCompFormatted)
                .css("text-align", "right");

            $(api.column("subtotal_compras_comp:name").footer())
                .html(totalSubtotalComprasCompFormatted)
                .css("text-align", "right");

            /*   $(api.column("total_cantidades:name").footer())
                .html(totalCantFormatted)
                .css("text-align", "right");

            $(api.column("total_costo:name").footer())
                .html(totalTotalCostoFormatted)
                .css("text-align", "right");

            $(api.column("costo_promedio:name").footer())
                .html(totalCostoPromdFormatted)
                .css("text-align", "right"); */
        },
    });

    // Agregar campos de búsqueda para la primera y cuarta columna de la tabla
    $("#tableInventory thead th").each(function (index) {
        if (index === 2 || index === 4) {
            var title = $(this).text();
            $(this).html(
                '<input type="text" placeholder="Buscar ' + title + '" />'
            );
        }
    });

    // Aplicar el filtro de búsqueda solo para la primera y cuarta columna
    dataTable.columns().every(function (index) {
        if (index === 2 || index === 4) {
            var that = this;
            $("input", this.header()).on("keyup change", function () {
                if (that.search() !== this.value) {
                    that.search(this.value).draw();
                }
            });
        }
    });
}

$(document).ready(function () {
    initializeDataTable("-1");

    $("#startDate, #endDate").on("change", function () {
        var startDateId = $("#startDate").val();
        var endDateId = $("#endDate").val();

        dataTable.destroy();
        initializeDataTable(startDateId, endDateId);
        cargarTotales(startDateId, endDateId);
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

                    const var_startDateId =
                        document.querySelector("#startDate");
                    const var_endDateId = document.querySelector("#endDate");

                    dataform.append(
                        "startDateId",
                        Number(var_startDateId.value)
                    );
                    dataform.append("endDateId", Number(var_endDateId.value));

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
