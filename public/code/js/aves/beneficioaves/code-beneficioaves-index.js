console.log("beneficioAves Starting");
$(document).ready(function () {
    $(function () {
        $("#tableBeneficioaves").DataTable({
            paging: true,
            pageLength: 5,
            /*"lengthChange": false,*/
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "/showbeneficioaves",
                type: "GET",
            },
            columns: [
                { data: "id", name: "id" },
                { data: "namethird", name: "namethird" },
                { data: "date", name: "date" },
                { data: "factura", name: "factura" },
                { data: "lote", name: "lote" },
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
    $(".selectProvider").select2({
        placeholder: "Busca un proveedor",
        width: "100%",
        theme: "bootstrap-5",
        allowClear: true,
        dropdownParent: $("#modal-create-beneficiopollo"),
    });
    $(".selectPieles").select2({
        placeholder: "Buscar un Cliente",
        width: "100%",
        theme: "bootstrap-5",
        allowClear: true,
        dropdownParent: $("#modal-create-beneficiopollo"),
    });
    $(".selectVisceras").select2({
        placeholder: "Buscar un Cliente",
        width: "100%",
        theme: "bootstrap-5",
        allowClear: true,
        dropdownParent: $("#modal-create-beneficiopollo"),
    });
});
/*****************************************************************************************/
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const formBeneficio = document.querySelector("#form-beneficiopollos-pollos");
const btnModalClose = document.querySelector("#btnModalClose");

const idBeneficio = document.querySelector("#idbeneficio");
const formBeneficioaves = document.querySelector("#formBeneficioaves");
const contentform = document.querySelector("#contentDisable");

inputplantasacrificioaves_id = document.querySelector(
    "#plantasacrificioaves_id"
);
inputfactura = document.querySelector("#factura");
inputclientsubproductos_uno_id = document.querySelector("#clientsubproductos_uno_id");
inputclientsubproductos_dos_id = document.querySelector("#clientsubproductos_dos_id");
inputsacrificio = document.querySelector("#sacrificio");
inputcantidad = document.querySelector("#cantidad");
inputfecha_beneficio = document.querySelector("#fecha_beneficio");

inputvalor_kg_pollo = document.querySelector("#valor_kg_pollo");
inputtotal_factura = document.querySelector("#total_factura");

inputpromedio_pie_kg = document.querySelector("#promedio_pie_kg");
inputpeso_pie_planta = document.querySelector("#peso_pie_planta");
inputpromedio_canal_fria_sala = document.querySelector("#promedio_canal_fria_sala");
inputpeso_canales_pollo_planta = document.querySelector("#peso_canales_pollo_planta");

inputmenudencia_pollo_kg = document.querySelector("#menudencia_pollo_kg");
inputmollejas_corazones_kg = document.querySelector("#mollejas_corazones_kg");
inputsubtotal = document.querySelector("#subtotal");
inputpromedio_canal_kg = document.querySelector("#promedio_canal_kg");

inputmenudencia_pollo_porc = document.querySelector("#menudencia_pollo_porc");
inputmollejas_corazones_porc = document.querySelector("#mollejas_corazones_porc");
inputdespojos_mermas = document.querySelector("#despojos_mermas");
inputporc_pollo = document.querySelector("#porc_pollo");

const refresh_table = () => {
    let table = $("#tableBeneficioaves").dataTable();
    table.fnDraw(false);
};

const edit = async (id) => {
    console.log(id);
    const response = await fetch(`/beneficioavesedit/${id}`);
    const data = await response.json();
    console.log(data);
    if (contentform.hasAttribute("disabled")) {
        contentform.removeAttribute("disabled");
        $("#thirds_id").prop("disabled", false);
        $("#clientsubproductos_uno_id").prop("disabled", false);
        $("#clientsubproductos_dos_id").prop("disabled", false);
    }
    showForm(data);
};

const showForm = (data) => {
    let resp = data.beneficiopollos;
    console.log(resp);
     idBeneficio.value = resp.id;
   $("#thirds_id").val(resp.thirds_id).trigger("change");
    $("#clientsubproductos_uno_id")
        .val(resp.clientsubproductos_uno_id)
        .trigger("change");
    $("#clientsubproductos_dos_id")
        .val(resp.clientsubproductos_dos_id)
        .trigger("change");
     $("#plantasacrificio_id").val(resp.plantasacrificio_id);
    inputcantidad.value = resp.cantidad;
    inputfecha_beneficio.value = resp.fecha_beneficio;
    inputfactura.value = resp.factura;
    inputclientsubproductos_uno_id.value = resp.clientsubproductos_uno_id;
    inputclientsubproductos_dos_id.value = resp.clientsubproductos_dos_id;

    inputsacrificio.value = formatCantidadSinCero(resp.sacrificio);
    inputvalor_kg_pollo.value = formatCantidad(resp.valor_kg_pollo);
    inputtotal_factura.value = formatCantidadSinCero(resp.total_factura);
 
    inputpromedio_pie_kg.value = formatCantidad(resp.promedio_pie_kg);
    inputpeso_pie_planta.value = formatCantidad(resp.peso_pie_planta);
    inputpromedio_canal_fria_sala.value = formatCantidad(resp.promedio_canal_fria_sala);
    inputpeso_canales_pollo_planta.value = formatCantidad(resp.peso_canales_pollo_planta);

    inputmenudencia_pollo_kg.value = formatCantidad(resp.menudencia_pollo_kg);
    inputmollejas_corazones_kg.value = formatCantidad(resp.mollejas_corazones_kg);
    inputsubtotal.value = formatCantidad(resp.subtotal);
    inputpromedio_canal_kg.value = formatCantidad(resp.promedio_canal_kg);

    inputmenudencia_pollo_porc.value = formatCantidad(resp.menudencia_pollo_porc);
    inputmollejas_corazones_porc.value = formatCantidad(resp.mollejas_corazones_porc);
    inputdespojos_mermas.value = formatCantidad(resp.despojos_mermas);
    inputporc_pollo.value = formatCantidad(resp.porc_pollo);
 
    const modal = new bootstrap.Modal(
        document.getElementById("modal-create-beneficiopollo")
    );
    modal.show();
};

const showModalcreate = () => {
    console.log("showModal");
    if (contentform.hasAttribute("disabled")) {
        contentform.removeAttribute("disabled");
        $("#thirds_id").prop("disabled", false);
        $("#clientsubproductos_uno_id").prop("disabled", false);
        $("#clientsubproductos_uno_id").prop("disabled", false);
    }
    const mySelectProvider = $("#thirds_id");
    mySelectProvider.val("").trigger("change");
    const mySelectPieles = $("#clientsubproductos_uno_id");
    mySelectPieles.val("").trigger("change");
    const mySelectVisceras = $("#clientsubproductos_uno_id");
    mySelectVisceras.val("").trigger("change");
    formBeneficio.reset();
    idBeneficio.value = 0;
};

function Confirm(id) {
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
            const waitOneSecond = async () => {
                let response = await fetch(`/downbeneficioaves/${id}`);
                let resp = await response.json();
                console.log(resp);
                return resp;
            };
            waitOneSecond().then((resp) => {
                console.log(resp); //
                if (resp.status === 201) {
                    swal({
                        title: "Exito",
                        text: resp.message,
                        type: "success",
                    });
                    refresh_table();
                }
            });
        }
    });
}

const showDataForm = async (id) => {
    const response = await fetch(`/edit/${id}`);
    const data = await response.json();
    console.log(data);
    showForm(data);
    $("#thirds_id").prop("disabled", true);
    $("#clientsubproductos_uno_id").prop("disabled", true);
    $("#clientsubproductos_dos_id").prop("disabled", true);
    contentform.setAttribute("disabled", "disabled");
}
