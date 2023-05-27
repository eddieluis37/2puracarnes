console.log("benedicore Starting")
const idBeneficio = document.querySelector("#idbeneficio");
const formBeneficiores = document.querySelector("#formBeneficiores");
const contentform = document.querySelector("#contentDisable");

inputvalortotalhembra = document.querySelector("#valorTotalHembra");
inputvalortotalmacho = document.querySelector("#valorTotalMacho");

inputvalorunitariohembra = document.querySelector("#valorUnitarioHembra");
inputvalorunitariomacho = document.querySelector("#valorUnitarioMacho");

inputcantidadhembra = document.querySelector("#cantidadHembra");
inputcantidadmacho = document.querySelector("#cantidadMacho");

inputfecha_beneficio = document.querySelector("#fecha_beneficio");
inputfactura = document.querySelector("#factura");
inputclientpieles_id = document.querySelector("#clientpieles_id");
inputclientvisceras_id = document.querySelector("#clientvisceras_id");
inputfinca = document.querySelector("#finca");
inputlote = document.querySelector("#lote");
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

/*inputcantidad = document.querySelector("#");
inputcreated_at = document.querySelector("#");
inputfecha_cierre = document.querySelector("#");
inputid = document.querySelector("#");
inputplantasacrificio_id = document.querySelector("#");
inputstatus_beneficio = document.querySelector("#");
inputthirds_id = document.querySelector("#");
inputupdated_at = document.querySelector("#");
/** */
const edit = async (id) => {
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
}

const showForm = (data) => {
  let resp = data.beneficiores;
  console.log(resp);
  //inputcantidadmacho.value =  resp.cantidadmacho;
  idBeneficio.value = resp.id;
  $('#thirds_id').val(resp.thirds_id).trigger('change');
  $('#clientpieles_id').val(resp.clientpieles_id).trigger('change');
  $('#clientvisceras_id').val(resp.clientvisceras_id).trigger('change');
  $('#plantasacrificio_id').val(resp.plantasacrificio_id);
  inputcantidadhembra.value = resp.cantidadhembra;
  inputcantidadmacho.value = resp.cantidadmacho;
  inputvalortotalhembra.value = formatCantidadSinCero(resp.valortotalhembra);
  inputvalortotalmacho.value = formatCantidadSinCero(resp.valortotalmacho);
  inputvalorunitariohembra.value = formatCantidadSinCero(resp.valorunitariohembra);
  inputvalorunitariomacho.value = formatCantidadSinCero(resp.valorunitariomacho);

  inputfecha_beneficio.value = resp.fecha_beneficio;
  inputfactura.value = resp.factura;
  inputclientpieles_id.value = resp.clientpieles_id;
  inputclientvisceras_id.value = resp.clientvisceras_id;
  inputfinca.value = resp.finca;
  inputlote.value = resp.lote;
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
  inputvisceras.value = formatCantidad(resp.visceras);

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

  const modal = new bootstrap.Modal(document.getElementById('modal-create-beneficiore'));
  modal.show();
  /*
  .value = resp.cantidad
  .value = resp.created_at
  .value = resp.fecha_cierre
  .value = resp.id
  .value = 
  .value = resp.status_beneficio
  .value = resp.thirds_id
  .value = resp.updated_at

  */
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

const showModalcreate = () => {
  console.log('showModal');
  if(contentform.hasAttribute('disabled')){
    contentform.removeAttribute('disabled');
    $('#thirds_id').prop('disabled', false);
    $('#clientpieles_id').prop('disabled', false);
    $('#clientvisceras_id').prop('disabled', false);
  }
  const mySelectProvider = $('#thirds_id');
  mySelectProvider.val('').trigger('change');
  const mySelectPieles = $('#clientpieles_id');
  mySelectPieles.val('').trigger('change');
  const mySelectVisceras = $('#clientvisceras_id');
  mySelectVisceras.val('').trigger('change');
  formBeneficiores.reset();
  
}

	function Confirm(id) {
		swal({
			title: 'CONFIRMAR',
			text: '¿CONFIRMAS ELIMINAR EL REGISTRO?',
			type: 'warning',
			showCancelButton: true,
			cancelButtonText: 'Cerrar',
			cancelButtonColor: '#fff',
			confirmButtonColor: '#3B3F5C',
			confirmButtonText: 'Aceptar'
		}).then(function(result) {
			if (result.value) {
        console.log(id)
				const waitOneSecond = async () => {
					let response = await fetch(`/downbeneficiores/${id}`);
					let resp = await response.json();
          console.log(resp);
          return resp;
				};
        waitOneSecond().then(resp => {
          console.log(resp); //
					if (resp.status === 201) {
						swal({
							title: "Exito",
							text: resp.message,
							type: "success",
						});
						setTimeout(() => {
							location.reload();
						}, 1000);
					}
        });
			}
		})
	}