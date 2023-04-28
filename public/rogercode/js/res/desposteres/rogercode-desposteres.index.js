import  {sendData} from '../../exportModule/core/rogercode-core.js';

const table = document.querySelector("#tableDespostere");
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const beneficioId = document.querySelector("#beneficioId");
const tableTbody = document.querySelector("#tbody");
const tableTfoot = document.querySelector("#tfoot");


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
      sendData("/desposteresUpdate",dataform,token).then((result) => {
        console.log(result);
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
  tableTbody.innerHTML = "";
  dataRow.forEach(element => {
    //console.log(element);
    tableTbody.innerHTML += `
			<tr>
				<td>${element.name} </td>
				<td>${element.porcdesposte} </td>
				<td>${element.precio}</td>
				<td> <input type="number" class="form-control-sm" id="${element.id}" value="${element.peso}" placeholder="Ingresar" size="10"></td>
				<td>${element.totalventa}</td>
				<td>${element.porcventa} </td>
				<td>${element.costo} </td>
				<td class="text-center">
					<button type="button" class="btn btn-dark btn-sm" title="Cancelar">
						<i class="fas fa-trash"></i>
					</button>
				</td>
			</tr>
    `;
  });

  tableTfoot.innerHTML = "";
  tableTfoot.innerHTML += `
		<tr>
			<td>Totales</td>
			<td>${dataTotals.TotalDesposte}</td>
			<td>--</td>
			<td>${dataTotals.pesoTotalGlobal}</td>
			<td>${dataTotals.TotalVenta}</td>
			<td>${dataTotals.porcVentaTotal}</td>
			<td>--</td>
			<td></td>
		</tr>
  `;

};
