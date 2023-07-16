console.log("Starting");
const btnAddAlistamiento = document.querySelector("#btnAddalistamiento");
const formAlistamiento = document.querySelector("#form-alistamiento");
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const btnClose = document.querySelector("#btnModalClose");

const selectCostcenterOrigin = document.querySelector("#centrocostoorigen");
const selectCostcenterDest = document.querySelector("#centrocostodestino");

const alistamiento_id = document.querySelector("#alistamientoId");
const contentform = document.querySelector("#contentDisable");

const selectCortePadre = document.querySelector("#selectCortePadre");

const stockActualCenterCostOrigin = document.getElementById(
    "stockActualCenterCostOrigin"
);
const stockActualCenterCostDest = document.getElementById(
    "stockActualCenterCostDest"
);

$(document).ready(function () {
    $(function () {
        $("#tableAlistamiento").DataTable({
            paging: true,
            pageLength: 5,
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "/showtransfer",
                type: "GET",
            },
            columns: [
                { data: "id", name: "id" },
                { data: "namecategoria", name: "namecategoria" },
                { data: "namecentrocosto", name: "namecentrocosto" },
                { data: "namecut", name: "namecut" },
                { data: "nuevo_stock_padre", name: "nuevo_stock_padre" },
                { data: "inventory", name: "inventory" },
                { data: "date", name: "date" },
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
        });
    });
    $(".select2corte").select2({
        placeholder: "Busca un producto",
        width: "100%",
        theme: "bootstrap-5",
        allowClear: true,
    });
});

const showModalcreate = () => {
    if (contentform.hasAttribute("disabled")) {
        contentform.removeAttribute("disabled");
        $(".select2corte").prop("disabled", false);
    }
    $(".select2corte").val("").trigger("change");
    selectCortePadre.innerHTML = "";
    formAlistamiento.reset();
    alistamiento_id.value = 0;
};

const showDataForm = (id) => {
    console.log(id);
    const dataform = new FormData();
    dataform.append("id", id);
    send(dataform, "/alistamientoById").then((resp) => {
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
    selectCategory.value = register.categoria_id;
    selectCentrocosto.value = register.centrocosto_id;
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

function validateCentroCosto() {
    if (centrocostoorigen.value === centrocostodestino.value) {
        alert(
            "El centro de costo origen debe ser diferente al centro de costo destino."
        );
        return false;
    }
    return true;
}

const form = document.getElementById("alistamientoId");
form.addEventListener("submit", function (event) {
    if (!validateCentroCosto()) {
        event.preventDefault(); // Evitar el envío del formulario si la validación falla
    }
});

/* Proceso para obtener Stock actual centro costo origen */
function getProductsByCostcenterOrigin(costcenteroriginId) {
    const dataform = new FormData();
    dataform.append("centrocostoorigenId", Number(costcenteroriginId));
    send(dataform, "/getproductsbycostcenterorigin").then((result) => {
        console.log(result);
        let prod = result.productsorigin;
        console.log(prod);
        selectCortePadre.innerHTML = "";
        selectCortePadre.innerHTML += `<option value="">Select the product</option>`;
        prod.forEach((option) => {
            const optionElement = document.createElement("option");
            optionElement.value = option.id;
            optionElement.text = option.name;
            selectCortePadre.appendChild(optionElement);
        });
    });
}

function handleCostcenterOriginChange() {
    const selectedValue = this.value;
    console.log("Selected cost center origin:", selectedValue);
    getProductsByCostcenterOrigin(selectedValue);
}

selectCostcenterOrigin.addEventListener("change", handleCostcenterOriginChange);

function actualizarStockActualOrigen() {
    var selectCortePadre = document.getElementById("selectCortePadre");
    var stockActualCenterCostOrigin = document.getElementById(
        "stockActualCenterCostOrigin"
    );

    // Obtener el valor seleccionado en el select
    var seleccionado = selectCortePadre.value;

    // Actualizar el valor del campo stockActualCenterCostOrigin
    stockActualCenterCostOrigin.value = seleccionado;
}

/* Proceso para obtener Stock actual centro costo destino */
function getProductsByCostcenterDest(costcenterdestId) {
    const dataform = new FormData();
    dataform.append("centrocostodestId", Number(costcenterdestId));
    send(dataform, "/getproductsbycostcenterdest").then((result) => {
        console.log(result);
        let prodDest = result.productsdest;
        console.log(prodDest);
      /*   selectCortePadre.innerHTML = ""; */
    /*     selectCortePadre.innerHTML += `<option value="">Select the product</option>`; */
        prodDest.forEach((option) => {
            const optionElement = document.createElement("option");
            optionElement.value = option.id;
            optionElement.text = option.name;
            selectCortePadre.appendChild(optionElement);
        });
    });
}

function handleCostcenterDestChange() {
    const selectedValue = this.value;
    console.log("Selected cost center dest:", selectedValue);
    getProductsByCostcenterDest(selectedValue);
}

selectCostcenterDest.addEventListener("change", handleCostcenterDestChange);

function actualizarStockActualDest() {
    var selectCortePadre = document.getElementById("selectCortePadre");
    var stockActualCenterCostDest = document.getElementById(
        "stockActualCenterCostDest"
    );

    // Obtener el valor seleccionado en el select
    var seleccionado = selectCortePadre.value;

    // Actualizar el valor del campo stockActualCenterCostOrigin
    stockActualCenterCostDest.value = seleccionado;
}


const downAlistamiento = (id) => {
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
            send(dataform, "/downmmainalistamiento").then((resp) => {
                console.log(resp);
                refresh_table();
            });
        }
    });
};

const refresh_table = () => {
    let table = $("#tableAlistamiento").dataTable();
    table.fnDraw(false);
};
