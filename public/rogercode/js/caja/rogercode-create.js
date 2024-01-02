import {sendData} from '../exportModule/core/rogercode-core.js';
import { successToastMessage, errorMessage } from '../exportModule/message/rogercode-message.js';
import { loadingStart, loadingEnd } from '../exportModule/core/rogercode-core.js';
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const formDetail = document.querySelector('#form-detail');
const showRegTbody = document.querySelector("#tbodyDetail");
const tableAlistamiento = document.querySelector("#tableAlistamiento");
const tbodyTable = document.querySelector("#tableAlistamiento tbody")
const tfootTable = document.querySelector("#tableAlistamiento tfoot")
const stockPadre = document.querySelector("#stockCortePadre");
const pesokg = document.querySelector("#pesokg");

const newStockPadre = document.querySelector("#newStockPadre");

const tableFoot = document.querySelector("#tabletfoot");
const selectProducto = document.getElementById("producto");
const selectCategoria = document.querySelector("#productoCorte");
const btnAddAlist = document.querySelector('#btnAddAlistamiento');
const alistamientoId = document.querySelector("#alistamientoId");
const kgrequeridos = document.querySelector("#kgrequeridos");
const addShopping = document.querySelector("#addShopping");
const productoPadre = document.querySelector("#productopadreId");
const centrocosto = document.querySelector("#centrocosto");
const categoryId = document.querySelector("#categoryId");


$('.select2Prod').select2({
	placeholder: 'Busca un producto',
	width: '100%',
	theme: "bootstrap-5",
	allowClear: true,
});
$('.select2ProdHijos').select2({
	placeholder: 'Busca hijos',
	width: '100%',
	theme: "bootstrap-5",
	allowClear: true,
});


tbodyTable.addEventListener("click", (e) => {
    e.preventDefault(); 
    let element = e.target;
    if (element.name === 'btnDownReg') {
        console.log(element);
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
                dataform.append("alistamientoId", Number(alistamientoId.value));
                dataform.append("centrocosto", Number(centrocosto.value));
                dataform.append("stockPadre",stockPadre.value)
                sendData("/alistamientodown",dataform,token).then((result) => {
                    console.log(result);
                    showData(result)
                })
			}

		})
    }
});