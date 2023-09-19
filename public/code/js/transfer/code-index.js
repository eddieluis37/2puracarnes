console.log("Starting");
const btnAddTransfer = document.querySelector("#btnAddTransfer");
const formTransfer = document.querySelector("#form-transfer");
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const btnClose = document.querySelector("#btnModalClose");

//const selectCategory = document.querySelector("#categoria");
const selectCentrocosto = document.querySelector("#centrocostoOrigen");
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

$(document).ready(initializeDataTable);
    function initializeDataTable() {
        $("#tableTransfer").DataTable({
            paging: true,
            pageLength: 50,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "/showtransfer",
                type: "GET",
            },
            columns: [
                { data: "id", name: "id" },
                { data: "date", name: "date" },                
                { data: "namecentrocostoOrigen", name: "namecentrocostoOrigen" },
                { data: "namecentrocostoDestino", name: "namecentrocostoDestino" },        
                { data: "inventory", name: "inventory" },             
                { data: "action", name: "action" },
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
            dom: 'Bfrtip',
            buttons: [
                'copy',
                'csv',
                'excel',
                'pdf'
            ],
        });
    
        $(".select2corte").select2({
            placeholder: "Busca un producto",
            width: "100%",
            theme: "bootstrap-5",
            allowClear: true,
        });
    }

const showModalcreate = () => {
    if (contentform.hasAttribute("disabled")) {
        contentform.removeAttribute("disabled");
        $(".select2corte").prop("disabled", false);
    }
    $(".select2corte").val("").trigger("change");
  //  selectCortePadre.innerHTML = "";
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

const showData = (resp) => {
    let register = resp.reg;
    //alistamiento_id.value = register.id;
  // selectCategory.value = register.categoria_id;
    selectCentrocosto.value = register.centrocostoOrigen_id;
    selectCentrocostoDestino.value = register.centrocostoDestino_id;
    getCortes(register.categoria_id);

    const modal = new bootstrap.Modal(
        document.getElementById("modal-create-transfer")
    );
    modal.show();
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
    //console.log(data);
    return data;
};

/* selectCategory.addEventListener("change", function () {
    const selectedValue = this.value;
    console.log("Selected value:", selectedValue);
    getCortes(selectedValue);
}); */

/* getCortes = (categoryId) => {
    const dataform = new FormData();
    dataform.append("categoriaId", Number(categoryId));
    send(dataform, "/productospadre").then((result) => {
        console.log(result);
        let prod = result.products;
        console.log(prod);
        //showDataTable(result);
        selectCortePadre.innerHTML = "";
        selectCortePadre.innerHTML += `<option value="">Seleccione el producto</option>`;
        // Create and append options to the select element
        prod.forEach((option) => {
            const optionElement = document.createElement("option");
            optionElement.value = option.id;
            optionElement.text = option.name;
            selectCortePadre.appendChild(optionElement);
        });
    });
}
 */
function validateCentroCosto() {
    if (centrocostoorigen.value === centrocostodestino.value) {
        alert(
            "El centro de costo origen debe ser diferente al centro de costo destino."
        );
        return false;
    }
    return true;
}

const form = document.getElementById("transferId");
form.addEventListener("submit", function (event) {
    if (!validateCentroCosto()) {
        event.preventDefault(); // Evitar el envío del formulario si la validación falla
    }
});

/* Proceso para obtener Stock actual centro costo origen */
/* function getProductsByCostcenterOrigin(costcenteroriginId) {
    console.log("centrocostoorigenId:", costcenteroriginId);
    const dataform = new FormData();
    dataform.append("centrocostoorigenId", Number(costcenteroriginId));
    send(dataform, "/getproductsbycostcenterorigin").then((result) => {
        console.log(result);
        let prod = result.productsorigin;
        console.log(prod);
    });
}
function handleCostcenterOriginChange() {
    const selectedValue = this.value;
    console.log("Centro de costo origen seleccionado:", selectedValue);
    getProductsByCostcenterOrigin(selectedValue);
}
selectCostcenterOrigin.addEventListener("change", handleCostcenterOriginChange);
function actualizarStockActualOrigen() {
    var selectCortePadre = document.getElementById("selectCortePadre");
    var stockActualCenterCostOrigin = document.getElementById(
        "stockActualCenterCostOrigin"
    );
}
 */
/* Proceso para obtener Stock actual centro costo destino */

/* function ProductsByCostcenterDest(costcenterdestId) {
    console.log("centrocostodestinoId:", costcenterdestId);
    const dataform = new FormData();
    dataform.append("centrocostodestinoId", Number(costcenterdestId));
    send(dataform, "/productsbycostcenterdest").then((result) => {
        console.log(result);
        let prodDest = result.productsdest;
        console.log(prodDest);
    });
}

function handleCostcenterDestChange() {
    const selectedValue = this.value;
    console.log("Centro de costo destino seleccionado:", selectedValue);
    ProductsByCostcenterDest(selectedValue); // Pass the selected value to the function
}

selectCostcenterDest.addEventListener("change", handleCostcenterDestChange);
function actualizarStockActualDest(seleccionado) {
    var selectCortePadre = document.getElementById("selectCortePadre");
    var stockActualCenterCostDest = document.getElementById(
        "stockActualCenterCostDest"
    );
} */

const downTransfer = (id) => {
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
            console.log(id);
            const dataform = new FormData();
            dataform.append("id", id);
            send(dataform, "/downmmaintransfer").then((resp) => {
                console.log(resp);
                refresh_table();
            });
        }
    });
};

const refresh_table = () => {
    let table = $("#tableTransfer").dataTable();
    table.fnDraw(false);
};
