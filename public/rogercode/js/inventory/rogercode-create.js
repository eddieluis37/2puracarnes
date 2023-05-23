import {sendData} from '../exportModule/core/rogercode-core.js';
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const formDetail = document.querySelector('#form-detail');
const btnAdd = document.querySelector('#btnAdd');
const showRegTbody = document.querySelector("#tbodyDetail");
let tbodyTable = document.querySelector("#tableDespostere tbody")
const compensado_id = document.querySelector("#compensadoId");
const pesokg = document.querySelector("#pesokg");
const pcompra = document.querySelector("#pcompra");
const regDetail = document.querySelector("#regdetailId");
const tableFoot = document.querySelector("#tabletfoot");


$('.select2Prod').select2({
	placeholder: 'Busca un producto',
	width: '100%',
	theme: "bootstrap-5",
	allowClear: true,
});

tbodyTable.addEventListener("click", (e) => {
    e.preventDefault(); 
    let element = e.target;
    if (element.name === 'btnDown') {
        console.log(element);
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
                dataform.append("compensadoId", Number(compensado_id.value));
                sendData("/compensadodown",dataform,token).then((result) => {
                    console.log(result);
                    showData(result)
                })

			}

		})
    }

    if (element.name === 'btnEdit') {
        console.log(element);
        let id = element.getAttribute('data-id');
        console.log(id);
        const dataform = new FormData();
        dataform.append("id", Number(id));
        sendData("/compensadogetById",dataform,token).then((result) => {
            console.log(result);
            let editReg = result.reg;
            console.log(editReg);
            regDetail.value = editReg.id;
            pcompra.value = editReg.pcompra;
            pesokg.value = editReg.peso;
            $('.select2Prod').val(editReg.products_id).trigger('change');
        })
    }
});

btnAdd.addEventListener('click', (e) => {
    e.preventDefault();  
    const dataform = new FormData(formDetail);
    sendData("/compensadosavedetail",dataform,token).then((result) => {
        console.log(result);
        if (result.status === 1) {
            formDetail.reset();
            showData(result)
        }
        if (result.status === 0) {
            Swal(
            'Error!',
            'Tiene campos vacios!',
            'error'
            )
        }
    });
})

const showData = (data) => {
    let dataAll = data.array;
    console.log(dataAll);
	showRegTbody.innerHTML = "";
    //let cantArt = 0;
	dataAll.forEach((element,indice) => {
	    showRegTbody.innerHTML += `
    	    <tr>
      	    <td>${element.created_at}</td>
      	    <td>${element.code}</td>
      	    <td>${element.nameprod}</td>
      	    <td>$ ${formatCantidadSinCero(element.pcompra)}</td>
      	    <td>${formatCantidad(element.peso)} KG</td>
      	    <td>$ ${formatCantidadSinCero(element.subtotal)}</td>
      	    <td>${element.iva}</td>
			<td class="text-center">
				<button class="btn btn-dark fas fa-edit" data-id="${element.id}" name="btnEdit" title="Editar" >
				</button>
				<button class="btn btn-dark fas fa-trash" name="btnDown" data-id="${element.id}" title="Borrar" >
				</button>
			</td>
    	    </tr>
	    `;
        //cantArt = cantArt + Number(element.cantidad);
	});
    let arrayTotales = data.arrayTotales; 
    console.log(arrayTotales);
    tableFoot.innerHTML = '';
    tableFoot.innerHTML += `
	    <tr>
		    <th>Totales</th>
		    <td></td>
		    <td></td>
		    <td></td>
		    <th>${formatCantidad(arrayTotales.pesoTotalGlobal)} KG</td>
		    <th>$ ${formatCantidadSinCero(arrayTotales.totalGlobal)} </th>
		    <td></td>
		    <td></td>
	    </tr>
    `;
}
//const selectCategoria = document.querySelector("#categoria");
//const selectProducto = document.getElementById("producto");
/*selectCategoria.addEventListener("change", function() {
    const selectedValue = this.value;
    console.log("Selected value:", selectedValue);

    const dataform = new FormData();
    dataform.append("categoriaId", Number(selectedValue));
    sendData("/getproductos",dataform,token).then((result) => {
        console.log(result);
        let prod = result.products;
        console.log(prod);
        //showDataTable(result);
        selectProducto.innerHTML = "";
        selectProducto.innerHTML += `<option value="">Seleccione el producto</option>`;
        // Create and append options to the select element
        prod.forEach(option => {
        const optionElement = document.createElement("option");
        optionElement.value = option.id;
        optionElement.text = option.name;
        selectProducto.appendChild(optionElement);
        });
    });

});*/

