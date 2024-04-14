console.log("Starting utilidad aves")
import {  sendData } from '../../exportModule/core/rogercode-core.js';
const table = document.querySelector("#tableDesposteaves");
const beneficioId = document.querySelector("#beneficioId");
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const tableTbody = document.querySelector("#tbody");
const tableTfoot = document.querySelector("#tfoot");
const downReg = document.querySelector("#tableDesposteaves tbody");

table.addEventListener("keydown", function(event) {
  if (event.keyCode === 13 || event.keyCode === 9) {
    const target = event.target;
    if (target.tagName === "INPUT" && target.closest("tr")) {
       //Execute your code here
      console.log("Enter key pressed on an input inside a table row");
      console.log(event.target.value);
      console.log(event.target.id);

      const inputValue = event.target.value;
      if (inputValue == "") {
        return false;
      }
      const trimValue = inputValue.trim();
      const dataform = new FormData();
      dataform.append("id", Number(event.target.id));
      dataform.append("precio_kg_venta", Number(trimValue));
      dataform.append("beneficioId", Number(beneficioId.value));
      sendData("/utilidadavesUpdate",dataform,token).then((result) => {
        console.log(result);
        showDataTable(result);

          const inputs = Array.from(table.querySelectorAll("input[type='text']")); // Cuando se envie la data, el cursor salte al siguiente input id="${element.id}" 
        const currentIndex = inputs.findIndex(input => input.id === target.id);
        const nextIndex = currentIndex + 1;
        if (nextIndex < inputs.length) {
          const nextInput = inputs[nextIndex];
          nextInput.focus();
          nextInput.select();
        }  
      });
    }
  }
});

const showDataTable = (data) => {
  //console.log(data);
  let dataRow = data.utilidad;
  //console.log(dataRow);
  let dataTotals = data.arrayTotales;
  //console.log(dataTotals);
  let dataBeneficiores = data.beneficiores;
  //console.log(dataBeneficiores);

  tableTbody.innerHTML = "";
  dataRow.forEach(element => {
    //console.log(element);
    tableTbody.innerHTML += `
			<tr>
				<td>${element.name} </td>
				<td>${element.kilos} </td>
        <td>${element.porcentaje_participacion}%</td>
        <td>$${formatCantidadSinCero(element.costo_unitario)}</td>
				<td>$${formatCantidadSinCero(element.costo_real)}</td>
				<td> <input type="text" class="form-control-sm" id="${element.id}" value="${element.precio_kg_venta}" placeholder="0" size="5"></td>
				<td>$${formatCantidadSinCero(element.ingresos_totales)}</td>
				<td>${element.participacion_venta}%</td>
				<td>$${formatCantidadSinCero(element.utilidad_dinero)}</td>
				<td>${formatCantidad(element.porcentaje_utilidad)}%</td>
        <td>$${formatCantidadSinCero(element.dinero_kilo)}</td>
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
		
      <td>${formatCantidad(dataTotals.TotalKilos)}</td>
			<td>${formatCantidad(dataTotals.TotalPorcPart)}%</td>
			<td>$${formatCantidadSinCero(dataTotals.TotalCostoUnit)}</td>
      <td>$${formatCantidadSinCero(dataTotals.TotalCostoReal)}</td>
      <td>--</td>
			<td>$${formatCantidadSinCero(dataTotals.TotalingresosTotales)}</td>
      <td>${formatCantidad(dataTotals.PorcVenta)}%</td>
      <td>$${formatCantidadSinCero(dataTotals.UtilidadDinero)}</td>			
      <td>--</td>
      <td>$${formatCantidadSinCero(dataTotals.DineroKilo)}</td>
			<td class="text-center">
			
			</td>
		</tr>
  `;
  /******************MERMA****************************** */
  /*let Peso_total_Desp = dataTotals.pesoTotalGlobal;
  mermaPesoTotal.innerHTML = "";
  mermaPesoTotal.innerHTML += `${formatCantidad(Peso_total_Desp)}`;*/

  /*let canalPlanta = Number(dataBeneficiores[0].canalplanta);
  let cantidad = Number(dataBeneficiores[0].cantidad);
  let costokilo = Number(dataBeneficiores[0].costokilo);
  let resultcanalPlantaCostoKilo = canalPlanta * costokilo;*/ 

  //console.log(resultcanalPlantaCostoKilo);
  //console.log(dd);
  /*mermaPesoInicial.innerHTML = `${formatCantidad(canalPlanta)}`;

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
  }*/

  //console.log("porc :" + porcMerma);
  /*mermaPorcentaje.innerHTML = "";
  mermaPorcentaje.innerHTML += `
  	<label>% Merma</label>
    <div class="form-control campo">
    ${formatCantidad(porcMerma)}
		</div>
  `;

  mermacantAnimal.innerHTML =  `${formatCantidad(cantidad)}`;*/
  
  /******************UTILIDAD****************************** */
  /*utilidadCostoKilo.innerHTML = `${formatCantidad(costokilo)}`;
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
  `;*/
};


downReg.addEventListener("click", (e) => {
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
          console.log(id);
          const dataform = new FormData();
          dataform.append("id", Number(id));
          dataform.append("beneficioId", Number(beneficioId.value));
          sendData("/downdesposteave",dataform,token).then((result) => {
            console.log(result);
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