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
            url: "/showConsolidadoUtilidad",
            type: "GET",
            data: {
                centrocostoId: centrocostoId,
                categoriaId: categoriaId,
            },
        },
        columns: [
            { data: "namecategoria", name: "namecategoria" },
            {
                data: "nameproducto",
                name: "nameproducto",
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
            {
                data: "invinicial",
                name: "invinicial",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },
            {
                data: "compraLote",
                name: "compraLote",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },
            /*   { data: "alistamiento", name: "alistamiento" }, */
            {
                data: "compensados",
                name: "compensados",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },
            {
                data: "trasladoing",
                name: "trasladoing",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },
            {
                data: "trasladosal",
                name: "trasladosal",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },
            {
                data: "invfinaltotal",
                name: "invfinaltotal",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },

            {
                data: null,
                name: "costo",
                render: function (data, type, row) {
                    var invinicial = parseFloat(row.invinicial);
                    var compraLote = parseFloat(row.compraLote);
                    var compensados = parseFloat(row.compensados);
                    var trasladoing = parseFloat(row.trasladoing);
                    var trasladosal = parseFloat(row.trasladosal);
                    var invfinaltotal = parseFloat(row.invfinaltotal);
                    var costo =
                        invinicial +
                        compraLote +
                        compensados +
                        trasladoing -
                        trasladosal -
                        invfinaltotal;
                    return "" + formatCantidadSinCero(costo);
                },
            },
            {
                data: "venta",
                name: "venta",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },
            {
                data: "notacredito",
                name: "notacredito",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },
            {
                data: "notadebito",
                name: "notadebito",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },

            {
                data: null,
                name: "totalventa",
                render: function (data, type, row) {
                    var venta = parseFloat(row.venta);
                    var notacredito = parseFloat(row.notacredito);
                    var notadebito = parseFloat(row.notadebito);
                    var totalventa = venta - notacredito + notadebito;
                    return "" + formatCantidadSinCero(totalventa);
                },
            },
            {
                data: null,
                name: "utilidad",
                render: function (data, type, row) {
                    var venta = parseFloat(row.venta);
                    var notacredito = parseFloat(row.notacredito);
                    var notadebito = parseFloat(row.notadebito);
                    var invinicial = parseFloat(row.invinicial);
                    var compraLote = parseFloat(row.compraLote);
                    var compensados = parseFloat(row.compensados);
                    var trasladoing = parseFloat(row.trasladoing);
                    var trasladosal = parseFloat(row.trasladosal);
                    var invfinaltotal = parseFloat(row.invfinaltotal);
                    var utilidad =
                        venta -
                        notacredito +
                        notadebito -
                        (invinicial +
                            compraLote +
                            compensados +
                            trasladoing -
                            trasladosal -
                            invfinaltotal);
                    return "" + formatCantidadSinCero(utilidad);
                },
            },
            {
                data: null,
                name: "utilidad_porcentaje",
                render: function (data, type, row) {
                    var venta = parseFloat(row.venta);
                    var notacredito = parseFloat(row.notacredito);
                    var notadebito = parseFloat(row.notadebito);
                    var invinicial = parseFloat(row.invinicial);
                    var compraLote = parseFloat(row.compraLote);
                    var compensados = parseFloat(row.compensados);
                    var trasladoing = parseFloat(row.trasladoing);
                    var trasladosal = parseFloat(row.trasladosal);
                    var invfinaltotal = parseFloat(row.invfinaltotal);
                    var utilidad =
                        venta -
                        notacredito +
                        notadebito -
                        (invinicial +
                            compraLote +
                            compensados +
                            trasladoing -
                            trasladosal -
                            invfinaltotal);
                    var totalventa = venta - notacredito + notadebito;
                    var utilidadPorcentaje = (utilidad / totalventa) * 100;
                    return "" + utilidadPorcentaje.toFixed(2) + "%";
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

            // Totalizar la columna "invinicial"
            var totalInvinicial = api
                .column("invinicial:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);

            // Totalizar la columna "compraLote"
            var totalCompraLote = api
                .column("compraLote:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);
            /* 
            // Totalizar la columna "alistamiento"
            var totalAlistamiento = api
                .column("alistamiento:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2); */

            // Totalizar la columna "compensados"
            var totalCompensados = api
                .column("compensados:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);

            // Totalizar la columna "trasladoing"
            var totalTrasladoing = api
                .column("trasladoing:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);

            // Totalizar la columna "trasladosal"
            var totalTrasladosal = api
                .column("trasladosal:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);

            /*        // Totalizar la columna "venta"
            var totalVenta = api
                .column("venta:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2); */

            // Totalizar la columna "stock"
            /*   var totalStock = api
                .column("stock:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);
 */
            // Totalizar la columna "fisico"
            /*     var totalFisico = api
                .column("fisico:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2); */

            // Totalizar la columna "disponible"
            var totalDisponible = api
                .column("totalventa:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    var value = parseFloat(b);
                    return isNaN(value) ? a : a + value;
                }, 0)
                .toFixed(2);

            // Agregar los valores totales en el footer
            $(api.column("invinicial:name").footer()).html(totalInvinicial);
            $(api.column("compraLote:name").footer()).html(totalCompraLote);
            /*     $(api.column("alistamiento:name").footer()).html(totalAlistamiento); */
            $(api.column("compensados:name").footer()).html(totalCompensados);
            $(api.column("trasladoing:name").footer()).html(totalTrasladoing);
            $(api.column("trasladosal:name").footer()).html(totalTrasladosal);
            /* $(api.column("venta:name").footer()).html(totalVenta); */
            $(api.column("stock:name").footer()).html(totalStock);
            /*  $(api.column("fisico:name").footer()).html(totalFisico); */
            $(api.column("disponible:name").footer()).html(totalDisponible);
        },
    });
}

function cargarTotales(centrocostoId = "-1", categoriaId = "-1") {
    $.ajax({
        type: "GET",
        url: "/totales",
        data: {
            centrocostoId: centrocostoId,
            categoriaId: categoriaId,
        },
        dataType: "JSON",
        success: function (data) {
            $("#totalStock").html(data.totalStock);
            $("#totalInvInicial").html(data.totalInvInicial);

            $("#totalCompraLote").html(data.totalCompraLote);
            /*          $("#totalAlistamiento").html(data.totalAlistamiento); */
            $("#totalCompensados").html(data.totalCompensados);
            $("#totalTrasladoing").html(data.totalTrasladoing);

            $("#totalVenta").html(data.totalVenta);
            $("#totalTrasladoSal").html(data.totalTrasladoSal);

            $("#totalIngresos").html(data.totalIngresos);
            $("#totalSalidas").html(data.totalSalidas);

            $("#totalConteoFisico").html(data.totalConteoFisico);

            $("#diferenciaKilos").html(data.diferenciaKilos);
            $("#difKilosPermitidos").html(data.difKilosPermitidos);
            $("#porcMerma").html(data.porcMerma);
            $("#porcMermaPermitida").html(data.porcMermaPermitida);
            $("#difKilos").html(data.difKilos);
            $("#difPorcentajeMerma").html(data.difPorcentajeMerma);
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
