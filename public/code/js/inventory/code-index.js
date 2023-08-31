console.log("Starting");

const btnAddTransfer = document.querySelector("#btnAddTransfer");
const formTransfer = document.querySelector("#form-transfer");
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const btnClose = document.querySelector("#btnModalClose");

/* const selectCategory = document.querySelector("#categoria"); */
const selectCentrocosto = document.querySelector("#centrocosto");
const selectCentrocostoDestino = document.querySelector("#centrocostoDestino");

const selectCostcenterOrigin = document.querySelector("#centrocostoorigen");
const selectCostcenterDest = document.querySelector("#centrocostodestino");

const transfer_id = document.querySelector("#transferId");
const contentform = document.querySelector("#contentDisable");

const selectCortePadre = document.querySelector("#selectCortePadre");

const stockActualCenterCostOrigin = document.getElementById(
    "stockActualCenterCostOrigin"
);
const stockActualCenterCostDest = document.getElementById(
    "stockActualCenterCostDest"
);

const tbodyTable = document.querySelector("#tableInventory tbody");
const tfootTable = document.querySelector("#tableInventory tfoot");

const btnGetInventory = document.querySelector("#btnGetInventory");

const catego = document.getElementById("categoria");

const categoriaSelect = document.getElementById("categoria");

var  dataTable ;

function initializeDataTable(centrocostoId) {
    
    dataTable = $("#tableInventory").DataTable({
        paging: true,
        pageLength: 5,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/showinventory",
            type: "GET",
            data: { centrocostoId: centrocostoId },
        },
        columns: [
            { data: "namecategoria", name: "namecategoria" },
            { data: "nameproducto", name: "nameproducto" },
            { data: "namefisico", name: "namefisico" },
            {
                data: "costo_kilo",
                name: "costo_kilo",
                render: function (data, type, row) {
                    return "$ " + formatCantidadSinCero(data);
                },
            },
            {
                data: "total_inv_ini",
                name: "total_inv_ini",
                render: function (data, type, row) {
                    return "$ " + formatCantidadSinCero(data);
                },
            },
            { data: "compraLote", name: "compraLote" },
            {
                data: "costo_uni_lote",
                name: "costo_uni_lote",
                render: function (data, type, row) {
                    return "$ " + formatCantidadSinCero(data);
                },
            },
            {
                data: null,
                name: "total_lote",
                render: function (data, type, row) {
                    var compraLote = parseFloat(row.compraLote);
                    var costoUniLote = parseFloat(row.costo_uni_lote);
                    var totalLote = compraLote * costoUniLote;
                    return "$" + formatCantidadSinCero(totalLote);
                },
            },
            { data: "total_weight", name: "total_weight" },
        ],
        order: [[0, "DESC"]],
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

    $("#centrocosto").on("change", function () {
        var centrocostoId = $(this).val();        
        //filterByCentroCosto(centrocostoId);
        dataTable.destroy();
        initializeDataTable(centrocostoId);
    });
});

//function filterByCentroCosto(centrocostoId) {
  //  $.ajax({
    //  url: "/showinventory",     
     // type: "POST",
      //contentType: "application/json",
     // headers: {
     //   "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
    //  },
      //data: JSON.stringify({ centrocostoId: centrocostoId }),
     // data: { centrocostoId: centrocostoId },
     // success: function (data) {
    
       // $("#tableInventory").DataTable().ajax.reload();
        //data.draw = 1; // Set draw value to 1
       /*  dataTable.clear().draw();*/
           //dataTable.draw();
       //dataTable.clear().draw();
      // dataTable.rows.add(data).draw(false); 
      // dataTable.columns.adjust().draw();
        
       // console.log(data);
     // },
     // error: function (xhr, status, error) {
      //  console.error("Error:", xhr.status);
     // },
  //  });
  //}