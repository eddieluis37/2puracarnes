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
                data: "cto_invinicial",
                name: "cto_invinicial",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },
            {
                data: "cto_compraLote",
                name: "cto_compraLote",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },
            {
                data: "cto_compensados",
                name: "cto_compensados",
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
                data: "costos",
                name: "costos",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
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
                data: "totalventa",
                name: "totalventa",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },
            {
                data: "utilidad",
                name: "utilidad",
                render: function (data, type, row) {
                    return "" + formatCantidadSinCero(data);
                },
            },
            {
                data: "porc_utilidad",
                name: "porc_utilidad",
                render: function (data, type, row) {
                    return "" + formatCantidad(data);
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

            // Totalize the "cto_invinicial" column
            var totalInvinicial = api
                .column("cto_invinicial:name", { search: "applied" })
                .data()
                .reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);

            // Format the total using the formatCantidadSinCero function
            var formattedTotalInvinicial =
                formatCantidadSinCero(totalInvinicial);

            // Totalizar la columna "cto_compraLote"
            var totalCompraLote = api
                .column("cto_compraLote:name", { search: "applied" })
                .data()
                .reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);
            // Format the total using the formatCantidadSinCero function
            var formattedCompraLote = formatCantidadSinCero(totalCompraLote);

            // Totalizar la columna "cto_compensados"
            var totalCompensados = api
                .column("cto_compensados:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);
            var formattedCompensados = formatCantidadSinCero(totalCompensados);

            var totalTrasladoing = api
                .column("trasladoing:name", { search: "applied" })
                .data()
                .reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);

            var formattedtrasladoing = formatCantidadSinCero(totalTrasladoing);

            // Totalizar la columna "trasladosal"
            var totalTrasladosal = api
                .column("trasladosal:name", { search: "applied" })
                .data()
                .reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);

            var formattedTotalTrasladosal =
                formatCantidadSinCero(totalTrasladosal);

            var totalInvFinal = api
                .column("invfinaltotal:name", { search: "applied" })
                .data()
                .reduce(function (acc, val) {
                    return acc + parseFloat(val);
                }, 0);

            var formattedTotalInvFinal = formatCantidadSinCero(totalInvFinal);

            var totalCosto = api
                .column("costos:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);

            var formattedTotalCosto = formatCantidadSinCero(totalCosto);

            var venta = api
                .column("venta:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);

            var formattedVenta = formatCantidadSinCero(venta);

            var notacredito = api
                .column("notacredito:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);

            var formattedNotacredito = formatCantidadSinCero(notacredito);

            var notadebito = api
                .column("notadebito:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);

            var formattedNotadebito = formatCantidadSinCero(notadebito);

            var totalventa = api
                .column("totalventa:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);

            var formattedTotalVenta = formatCantidadSinCero(totalventa);

            var utilidad = api
                .column("utilidad:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);

            var formattedUtilidad = formatCantidadSinCero(utilidad);

            var porc_utilidad = api
                .column("porc_utilidad:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);

            var formattedPorcUtilidad = formatCantidadSinCero(porc_utilidad);

            // Sumatoria de totalventa
            var sumTotalVenta = api
                .column("totalventa:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);

            // Sumatoria de utilidad
            var sumUtilidad = api
                .column("utilidad:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0);

            // Calcular la porc_utilidad
            var porcUtilidad = sumTotalVenta / sumUtilidad;
            var formattedPorcUtilidad = formatCantidadSinCero(porcUtilidad);

            // Agregar los valores totales en el footer
            $(api.column("cto_invinicial:name").footer()).html(
                formattedTotalInvinicial
            );
            $(api.column("cto_compraLote:name").footer()).html(
                formattedCompraLote
            );
            $(api.column("cto_compensados:name").footer()).html(
                formattedCompensados
            );
            $(api.column("trasladoing:name").footer()).html(
                formattedtrasladoing
            );
            $(api.column("trasladosal:name").footer()).html(
                formattedTotalTrasladosal
            );
            $(api.column("invfinaltotal:name").footer()).html(
                formattedTotalInvFinal
            );
            $(api.column("costos:name").footer()).html(formattedTotalCosto);
            $(api.column("venta:name").footer()).html(formattedVenta);
            $(api.column("notacredito:name").footer()).html(
                formattedNotacredito
            );
            $(api.column("notadebito:name").footer()).html(formattedNotadebito);
            $(api.column("totalventa:name").footer()).html(formattedTotalVenta);
            $(api.column("utilidad:name").footer()).html(formattedUtilidad);
            // Agregar el valor calculado en el footer de la columna "porc_utilidad"
            $(api.column("porc_utilidad:name").footer()).html(
                formattedPorcUtilidad
            );
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
