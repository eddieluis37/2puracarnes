console.log("Starting");
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

//   $(document).ready(function () {
var dataTable;

function initializeDataTable(centrocostoId = "-1", categoriaId = "-1") {
    dataTable = $("#tableInventory").DataTable({
        paging: true,
        pageLength: 15,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/showCcpInventory",
            type: "GET",
            data: {
                centrocostoId: centrocostoId,
                categoriaId: categoriaId,
            },

            dataSrc: function (response) {
                // Modify the data before processing it in the table
                var modifiedData = response.data.map(function (item) {
                    return {
                        namecategoria: item.namecategoria,
                        nameproducto: item.nameproducto,
                        fisico:
                            '<input type="text" class="edit-fisico" value="' +
                            item.fisico +
                            '" size="4" />',
                        productId: item.productId,
                    };
                });
                return modifiedData;
            },
        },
        columns: [
            { data: "namecategoria", name: "namecategoria" },
            { data: "productId", name: "productId" },
            { data: "nameproducto", name: "nameproducto" },
            { data: "fisico", name: "fisico" },
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

            // Totalizar la columna "fisico"
            var totalFisico = api
                .column("fisico:name", { search: "applied" })
                .data()
                .reduce(function (a, b) {
                    return parseFloat(a) + parseFloat(b);
                }, 0)
                .toFixed(2);

            // Agregar los valores totales en el footer
            $(api.column("fisico:name").footer()).html(totalFisico);
        },
    });
}
function updateCcpInventory(productId, fisico, centrocostoId) {
    console.log("productId:", productId);
    console.log("fisico:", fisico);
    console.log("centrocostoId:", centrocostoId);
    $.ajax({
        headers: {
            "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
        },
        url: "/updateCcpInventory",
        type: "POST",
        data: {
            productId: productId,
            fisico: fisico,
            centrocostoId: centrocostoId,
        },
        success: function (response) {
            console.log("Update successful");
        },
        error: function (xhr, status, error) {
            console.error("Error updating");
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
    });

    $(document).on("keypress", ".edit-fisico", function (event) {
        if (event.which === 13) {
            event.preventDefault();
            var fisico = $(this).val();
            var productId = $(this).closest("tr").find("td:eq(1)").text();
            var centrocostoId = $("#centrocosto").val();

            updateCcpInventory(productId, fisico, centrocostoId);
        }
    });
});
