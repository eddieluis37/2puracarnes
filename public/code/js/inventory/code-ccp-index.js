console.log("Starting");

const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

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
        },
        columns: [
            { data: "namecategoria", name: "namecategoria" },
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
});
