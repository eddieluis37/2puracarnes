console.log("benedicore Starting");
$(document).ready(function () {
    $(function () {
        $("#tableBeneficiores").DataTable({
            paging: true,
            pageLength: 5,
            /*"lengthChange": false,*/
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "/showbeneficiores",
                type: "GET",
            },
            columns: [
                { data: "id", name: "id" },
                { data: "namecentrocosto", name: "namecentrocosto" },
                { data: "namethird", name: "namethird" },
                { data: "date", name: "date" },
                { data: "factura", name: "factura" },
                { data: "lote", name: "lote" },
                { data: "action", name: "action" },
            ],
            order: [[0, 'DESC']],
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
        dropdownParent: $("#modal-create-beneficiore"),
        //https://select2.org/troubleshooting/common-problems
    });
    $(".selectPieles").select2({
        placeholder: "Buscar un Cliente Piel",
        width: "100%",
        theme: "bootstrap-5",
        allowClear: true,
        dropdownParent: $("#modal-create-beneficiore"),
    });
    $(".selectVisceras").select2({
        placeholder: "Buscar un Cliente Viscera",
        width: "100%",
        theme: "bootstrap-5",
        allowClear: true,
        dropdownParent: $("#modal-create-beneficiore"),
    });
});
/*****************************************************************************************/
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const formBeneficio = document.querySelector("#form-beneficiores-res");
const btnModalClose = document.querySelector("#btnModalClose");

const idBeneficio = document.querySelector("#idbeneficio");
const formBeneficiores = document.querySelector("#formBeneficiores");
const contentform = document.querySelector("#contentDisable");

inputvalortotalhembra = document.querySelector("#valorTotalHembra");
inputvalortotalmacho = document.querySelector("#valorTotalMacho");

inputvalorunitariohembra = document.querySelector("#valorUnitarioHembra");
inputvalorunitariomacho = document.querySelector("#valorUnitarioMacho");

inputcantidadhembra = document.querySelector("#cantidadHembra");
inputcantidadmacho = document.querySelector("#cantidadMacho");

//inputfecha_beneficio = document.querySelector("#fecha_beneficio");
inputfactura = document.querySelector("#factura");
inputclientpieles_id = document.querySelector("#clientpieles_id");
inputclientvisceras_id = document.querySelector("#clientvisceras_id");
inputfinca = document.querySelector("#finca");
//inputlote = document.querySelector("#lote");
inputsacrificio = document.querySelector("#sacrificio");
inputfomento = document.querySelector("#fomento");
inputdeguello = document.querySelector("#deguello");
inputbascula = document.querySelector("#bascula");
inputtransporte = document.querySelector("#transporte");
inputpesopie1 = document.querySelector("#pesopie1");
inputpesopie2 = document.querySelector("#pesopie2");
inputpesopie3 = document.querySelector("#pesopie3");
inputcostoanimal1 = document.querySelector("#costoanimal1");
inputcostoanimal2 = document.querySelector("#costoanimal2");
inputcostoanimal3 = document.querySelector("#costoanimal3");

inputcanalcaliente = document.querySelector("#canalcaliente");
inputcanalfria = document.querySelector("#canalfria");
inputcanalplanta = document.querySelector("#canalplanta");
inputpieleskg = document.querySelector("#pieleskg");
inputpielescosto = document.querySelector("#pielescosto");
inputvisceras = document.querySelector("#visceras");

inputcostopie1 = document.querySelector("#costopie1");
inputcostopie2 = document.querySelector("#costopie2");
inputcostopie3 = document.querySelector("#costopie3");

inputtsacrificio = document.querySelector("#tsacrificio");
inputtfomento = document.querySelector("#tfomento");
inputtdeguello = document.querySelector("#tdeguello");
inputtbascula = document.querySelector("#tbascula");
inputttransporte = document.querySelector("#ttransporte");
inputtpieles = document.querySelector("#tpieles");
inputtvisceras = document.querySelector("#tvisceras");
inputtcanalfria = document.querySelector("#tcanalfria");

inputvalorfactura = document.querySelector("#valorfactura");
inputcostokilo = document.querySelector("#costokilo");
inputcosto = document.querySelector("#costo");
inputtotalcostos = document.querySelector("#totalcostos");

inputpesopie = document.querySelector("#pesopie");
inputrtcanalcaliente = document.querySelector("#rtcanalcaliente");
inputrtcanalplanta = document.querySelector("#rtcanalplanta");
inputrtcanalfria = document.querySelector("#rtcanalfria");
inputrendcaliente = document.querySelector("#rendcaliente");
inputrendplanta = document.querySelector("#rendplanta");
inputrendfrio = document.querySelector("#rendfrio");

const refresh_table = () => {
    let table = $("#tableBeneficiores").dataTable();
    table.fnDraw(false);
};

const edit = async (id) => {
    console.log(id);
    const response = await fetch(`/edit/${id}`);
    const data = await response.json();
    console.log(data);
    if(contentform.hasAttribute('disabled')){
    	contentform.removeAttribute('disabled');
    	$('#thirds_id').prop('disabled', false);
    	$('#clientpieles_id').prop('disabled', false);
    	$('#clientvisceras_id').prop('disabled', false);
    }
    showForm(data);
};

const showForm = (data) => {
    let resp = data.beneficiores;
    console.log(resp);
    idBeneficio.value = resp.id;
    $("#thirds_id").val(resp.thirds_id).trigger("change");
    $("#clientpieles_id").val(resp.clientpieles_id).trigger("change");
    $("#clientvisceras_id").val(resp.clientvisceras_id).trigger("change");
    $("#plantasacrificio_id").val(resp.plantasacrificio_id);
    inputcantidadhembra.value = resp.cantidadhembra;
    inputcantidadmacho.value = resp.cantidadmacho;
    inputvalortotalhembra.value = formatCantidadSinCero(resp.valortotalhembra);
    inputvalortotalmacho.value = formatCantidadSinCero(resp.valortotalmacho);
    inputvalorunitariohembra.value = formatCantidadSinCero(
        resp.valorunitariohembra
    );
    inputvalorunitariomacho.value = formatCantidadSinCero(
        resp.valorunitariomacho
    );

    //inputfecha_beneficio.value = resp.fecha_beneficio;
    inputfactura.value = resp.factura;
    inputclientpieles_id.value = resp.clientpieles_id;
    inputclientvisceras_id.value = resp.clientvisceras_id;
    inputfinca.value = resp.finca;
    //inputlote.value = resp.lote;
    inputsacrificio.value = formatCantidadSinCero(resp.sacrificio);
    inputfomento.value = formatCantidadSinCero(resp.fomento);
    inputdeguello.value = formatCantidadSinCero(resp.deguello);
    inputbascula.value = formatCantidadSinCero(resp.bascula);
    inputtransporte.value = formatCantidadSinCero(resp.transporte);
    inputpesopie1.value = formatCantidad(resp.pesopie1);
    inputpesopie2.value = formatCantidad(resp.pesopie2);
    inputpesopie3.value = formatCantidad(resp.pesopie3);
    inputcostoanimal1.value = formatCantidadSinCero(resp.costoanimal1);
    inputcostoanimal2.value = formatCantidadSinCero(resp.costoanimal2);
    inputcostoanimal3.value = formatCantidadSinCero(resp.costoanimal3);

    inputcanalcaliente.value = formatCantidad(resp.canalcaliente);
    inputcanalfria.value = formatCantidad(resp.canalfria);
    inputcanalplanta.value = formatCantidad(resp.canalplanta);
    inputpieleskg.value = formatCantidadSinCero(resp.pieleskg);
    inputpielescosto.value = formatCantidadSinCero(resp.pielescosto);
    inputvisceras.value = formatCantidadSinCero(resp.visceras);

    inputcostopie1.value = formatCantidadSinCero(resp.costopie1);
    inputcostopie2.value = formatCantidadSinCero(resp.costopie2);
    inputcostopie3.value = formatCantidadSinCero(resp.costopie3);

    inputtsacrificio.value = formatCantidadSinCero(resp.tsacrificio);
    inputtfomento.value = formatCantidadSinCero(resp.tfomento);
    inputtdeguello.value = formatCantidadSinCero(resp.tdeguello);
    inputtbascula.value = formatCantidadSinCero(resp.tbascula);
    inputttransporte.value = formatCantidadSinCero(resp.ttransporte);
    inputtpieles.value = formatCantidadSinCero(resp.tpieles);
    inputtvisceras.value = formatCantidadSinCero(resp.tvisceras);
    inputtcanalfria.value = formatCantidadSinCero(resp.tcanalfria);

    inputvalorfactura.value = formatCantidadSinCero(resp.valorfactura);
    inputcostokilo.value = formatCantidadSinCero(resp.costokilo);
    inputcosto.value = formatCantidadSinCero(resp.costo);
    inputtotalcostos.value = formatCantidadSinCero(resp.totalcostos);

    inputpesopie.value = formatCantidad(resp.pesopie);
    inputrtcanalcaliente.value = formatCantidad(resp.rtcanalcaliente);
    inputrtcanalplanta.value = formatCantidad(resp.rtcanalplanta);
    inputrtcanalfria.value = formatCantidad(resp.rtcanalfria);
    inputrendcaliente.value = formatCantidad(resp.rendcaliente);
    inputrendplanta.value = formatCantidad(resp.rendplanta);
    inputrendfrio.value = formatCantidad(resp.rendfrio);

    const modal = new bootstrap.Modal(
        document.getElementById("modal-create-beneficiore")
    );
    modal.show();
};

const showModalcreate = () => {
    console.log("showModal");
    if (contentform.hasAttribute("disabled")) {
        contentform.removeAttribute("disabled");
        $("#thirds_id").prop("disabled", false);
        $("#clientpieles_id").prop("disabled", false);
        $("#clientvisceras_id").prop("disabled", false);
    }
    const mySelectProvider = $("#thirds_id");
    mySelectProvider.val("").trigger("change");
    const mySelectPieles = $("#clientpieles_id");
    mySelectPieles.val("").trigger("change");
    const mySelectVisceras = $("#clientvisceras_id");
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
                let response = await fetch(`/downbeneficiores/${id}`);
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
  $('#thirds_id').prop('disabled', true);
  $('#clientpieles_id').prop('disabled', true);
  $('#clientvisceras_id').prop('disabled', true);
  contentform.setAttribute('disabled','disabled');
}