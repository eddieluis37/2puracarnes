import  {sendData} from '../../exportModule/core/rogercode-core.js';

const table = document.querySelector("#tableDespostece");
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const beneficioId = document.querySelector("#beneficioId");
const tableTbody = document.querySelector("#tbody");
const tableTfoot = document.querySelector("#tfoot");
const mermaPesoTotal = document.querySelector("#pesoTotalDesposte");
const mermaPesoInicial = document.querySelector("#pesoInicial");
const mermaPesoAnimal = document.querySelector("#pesoAnimal");
const mermaMerma = document.querySelector("#merma");
const mermaPorcentaje = document.querySelector("#porcentajeMerma");
const mermacantAnimal = document.querySelector("#cantAnimal");
const utilidadCostoKilo = document.querySelector("#costoKilo");
const utilidadValorDesposte = document.querySelector("#valorDesposte");
const utilidadTotalCostoKilo = document.querySelector("#totalCostoKilo");
const utilidadUtilidad = document.querySelector("#utilidad");
const utilidadPorcentajeUtilidad = document.querySelector("#porcentajeUtilidad");
const utilidadAnimal = document.querySelector("#utilidadAnimal");










table.addEventListener("keydown", function(event) {
  if (event.keyCode === 13) {
    const target = event.target;
    if (target.tagName === "INPUT" && target.closest("tr")) {
      // Execute your code here
      //console.log("Enter key pressed on an input inside a table row");
      //console.log(event.target.value);
      //console.log(event.target.id);
      const inputValue = event.target.value;
      if (inputValue == "") {
        return false;
      }
      const trimValue = inputValue.trim();
      const dataform = new FormData();
      dataform.append("id", Number(event.target.id));
      dataform.append("peso_kilo", Number(trimValue));
      dataform.append("beneficioId", Number(beneficioId.value));
      sendData("/despostecerdoUpdate",dataform,token).then((result) => {
        //console.log(result);
        showDataTable(result);
      });
    }
  }
});

const showDataTable = (data) => {
  //console.log(data);
  let dataRow = data.desposte;
  //console.log(dataRow);
  let dataTotals = data.arrayTotales;
  //console.log(dataTotals);
  let dataBeneficiocerdos = data.beneficiocerdos;
  //console.log(dataBeneficiocerdos);

  tableTbody.innerHTML = "";
  dataRow.forEach(element => {
    //console.log(element);
    tableTbody.innerHTML += `
			<tr>
				<td>${element.name} </td>
				<td>${element.porcdesposte} %</td>
				<td>$ ${formatCantidadSinCero(element.precio)}</td>
				<td> <input type="text" class="form-control-sm" id="${element.id}" value="${element.peso}" placeholder="Ingresar" size="10"></td>
				<td>$ ${formatCantidadSinCero(element.totalventa)}</td>
				<td>${element.porcventa} %</td>
				<td>$ ${formatCantidadSinCero(element.costo)} </td>
				<td>${formatCantidad(element.costo_kilo)} </td>
				<td class="text-center">
					<button type="button" name="btnDownReg" data-id="${element.id}" class="btn btn-dark btn-sm fas fa-trash" title="Cancelar">
					</button>
				</td>
			</tr>
    `;
  });

  tableTfoot.innerHTML = "";
  tableTfoot.innerHTML += `
		<tr>
			<td>Totales</td>
			<td>${dataTotals.TotalDesposte} %</td>
			<td>$ --</td>
			<td>${formatCantidad(dataTotals.pesoTotalGlobal)}</td>
			<td>$ ${formatCantidadSinCero(dataTotals.TotalVenta)}</td>
			<td>${dataTotals.porcVentaTotal} %</td>
			<td>$ ${formatCantidadSinCero(dataTotals.costoTotalGlobal)}</td>
			<td>${dataTotals.costoKiloTotal}</td>
			<td class="text-center">
				<button class="btn btn-success btn-sm">Cargar al inventario</button>
			</td>
		</tr>
  `;
  /******************MERMA****************************** */
  let Peso_total_Desp = dataTotals.pesoTotalGlobal;
  mermaPesoTotal.innerHTML = "";
  mermaPesoTotal.innerHTML += `${formatCantidad(Peso_total_Desp)}`;

  let canalPlanta = Number(dataBeneficiocerdos[0].canalplanta);
  //console.log(canalPlanta);
  let cantidad = Number(dataBeneficiocerdos[0].cantidad);
  let costokilo = Number(dataBeneficiocerdos[0].costokilo);
  //console.log(cantidad);
  let resultcanalPlantaCostoKilo = canalPlanta * costokilo;  
  //console.log(resultcanalPlantaCostoKilo);
  //console.log(dd);
  mermaPesoInicial.innerHTML = `${formatCantidad(canalPlanta)}`;

  let Peso_por_Animal = canalPlanta / cantidad;
  mermaPesoAnimal.innerHTML = `${formatCantidad(Peso_por_Animal)}`;

  let merma = Peso_total_Desp - canalPlanta;
  mermaMerma.innerHTML = `${formatCantidad(merma)}`;

  let porcMerma;
  if (Peso_total_Desp == 0) {
    porcMerma = Peso_total_Desp;
  }
  if (Peso_total_Desp != 0) {
    porcMerma = ((Peso_total_Desp - canalPlanta) / Peso_total_Desp) * 100;
  }

  //console.log("porc :" + porcMerma);
  mermaPorcentaje.innerHTML = "";
  mermaPorcentaje.innerHTML += `
  	<label>% Merma</label>
    <div class="form-control campo">
    ${formatCantidad(porcMerma)}
		</div>
  `;

  mermacantAnimal.innerHTML =  `${formatCantidad(cantidad)}`;
  
  /******************UTILIDAD****************************** */
  utilidadCostoKilo.innerHTML = `${formatCantidad(costokilo)}`;
  utilidadValorDesposte.innerHTML = `${formatCantidadSinCero(dataTotals.TotalVenta)}`;
  utilidadTotalCostoKilo.innerHTML = `${formatCantidad(resultcanalPlantaCostoKilo)}`;
  let utilid = dataTotals.TotalVenta - resultcanalPlantaCostoKilo;
  utilidadUtilidad.innerHTML = `${formatCantidadSinCero(utilid)}`;
  let porcUtilidad;
  if (dataTotals.TotalVenta == 0) {
    porcUtilidad = dataTotals.TotalVenta;
  }
  if (dataTotals.TotalVenta != 0) {
    porcUtilidad = ((dataTotals.TotalVenta - resultcanalPlantaCostoKilo) / dataTotals.TotalVenta) * 100;
  }
  utilidadPorcentajeUtilidad.innerHTML = "";
  utilidadPorcentajeUtilidad.innerHTML += `
    <label>% Utilidad</label>
    <div class="form-control campo">
    ${formatCantidad(porcUtilidad)}
		</div>
  `;

  let utilidadAnim;
  if (dataTotals.TotalVenta == 0) {
    utilidadAnim = dataTotals.TotalVenta;
  }
  if (dataTotals.TotalVenta != 0) {
    utilidadAnim = ((dataTotals.TotalVenta - resultcanalPlantaCostoKilo) / cantidad);
  }
  utilidadAnimal.innerHTML = ``;
  utilidadAnimal.innerHTML = `
    <label>Utilidad por anima</label>
    <div class="form-control campo">
    ${formatCantidad(utilidadAnim)}
		</div>
  `;
};

document.querySelector("#tableDespostece tbody").addEventListener("click", (e) => {
    //console.log('Row clicked');
    //console.log(e.target);
    let element = e.target;
    if (element.name === 'btnDownReg') {
      //console.log(element);
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
          let id = element.getAttribute('data-id');
          //console.log(id);
          let url = "/getpaymentmoney/";
          let btnId = element.getAttribute("id");

          const dataform = new FormData();
          dataform.append("id", Number(id));
          dataform.append("beneficioId", Number(beneficioId.value));
          sendData("/downdesposter",dataform,token).then((result) => {
            //console.log(result);
            showDataTable(result);
          });

			  }

		  })

        /*getdata(url,Number(id)).then((response) => {
            if (response.status === 1) {
              console.log(response);
            }
        });*/

    }
});