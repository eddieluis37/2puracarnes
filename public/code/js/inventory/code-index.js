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



$(document).ready(function () {
    var dataTable = $("#tableInventory").DataTable({
        paging: true,
        pageLength: 5,
        autoWidth: false,
        processing: true,
        serverSide: true,
        ajax: {
            url: "/showinventory",
            type: "GET",
            data: function (d) {
                d.categoria = $("#categoria").val();
                d.centrocosto = $("#centrocosto").val();
            },
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

    $(".select2corte").select2({
        placeholder: "Busca un producto",
        width: "100%",
        theme: "bootstrap-5",
        allowClear: true,
    });
    $("#categoria, #centrocosto").on("change", function () {
        dataTable.ajax.reload(function () {
            dataTable.draw();
        });
    });
});

const showModalcreate = () => {
    if (contentform.hasAttribute("disabled")) {
        contentform.removeAttribute("disabled");
        $(".select2corte").prop("disabled", false);
    }
    $(".select2corte").val("").trigger("change");
    formTransfer.reset();
    transfer_id.value = 0;
};

const showDataForm = (id) => {
    console.log(id);
    const dataform = new FormData();
    dataform.append("id", id);
    send(dataform, "/transferById").then((resp) => {
        console.log(resp);
        console.log(resp.reg);
        showData(resp);
        setTimeout(() => {
            $(".select2corte").val(resp.reg.meatcut_id).trigger("change");
        }, 1000);
        $(".select2corte").prop("disabled", true);
        contentform.setAttribute("disabled", "disabled");
    });
};

const send = async (dataform, ruta) => {
    let response = await fetch(ruta, {
        headers: {
            "X-CSRF-TOKEN": token,
        },
        method: "POST",
        body: dataform,
    });
    let data = await response.json();
    return data;
};

const refresh_table = () => {
    let table = $("#tableInventory").dataTable();
    table.fnDraw(true);
};

const centrocostoSelect = document.getElementById("centrocosto");

centrocostoSelect.addEventListener("change", function () {
    const centrocostoId = this.value;
    console.log(centrocostoId);
    filterByCentroCosto(centrocostoId);
});

function filterByCentroCosto(centrocostoId) {
    fetch("/showinvent", {
        method: "POST",
        headers: {
            "Content-Type": "application/json",
            "X-CSRF-TOKEN": document
                .querySelector('meta[name="csrf-token"]')
                .getAttribute("content"),
        },
        body: JSON.stringify({ centrocostoId: centrocostoId }),
    })
        .then((response) => response.json())
        .then((data) => {
            console.log(data);
            // Manipular los datos recibidos, por ejemplo, actualizar la tabla HTML
            // con los resultados filtrados

            function initializeDataTable() {
                var dataTable = $("#tableInventory").DataTable({
                    // Resto de la configuración del DataTable
                });

                $("#centrocosto").on("change", function () {
                    // Obtén el valor seleccionado del centrocosto
                    var centrocostoId = $(this).val();

                    // Aplica el filtro al DataTable
                    dataTable.column(0).search().draw();
                });
            }
        })
        .catch((error) => {
            console.error("Error:", error);
        });
}
$(document).ready(function () {
    $("#centrocosto").on("change", function () {
        // Get the selected centrocosto value
        var centrocostoId = $(this).val();

        // Reinitialize the DataTable with the new centrocosto value
        $("#tableInventory").DataTable({
            // Your DataTable configuration options
            ajax: {
                url: "/inventory/diario",
                data: { centrocosto: centrocostoId },
                // Other data parameters if needed
            },
            // Other DataTable configurations
            
        });
    });
});

categoriaSelect.addEventListener("change", function () {
    const categoriaId = this.value;
    console.log('valorCategoria: ' + categoriaId);  
    // Make an AJAX request to the controller
    const xhr = new XMLHttpRequest();
    xhr.open('GET', '/showinventory'); // Replace with your actual controller route
    xhr.setRequestHeader('Content-Type', 'application/json');
    xhr.setRequestHeader('X-CSRF-TOKEN', '{{ csrf_token() }}'); // If using Laravel's CSRF protection
    xhr.onload = function () {
        if (xhr.status === 200) {
            // Handle the response from the controller
            console.log(xhr.responseText);
        }
    };
    const data = JSON.stringify({ categoriaId: categoriaId });
    xhr.send(data);
});
