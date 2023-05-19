import {sendData} from '../exportModule/core/rogercode-core.js';
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const selectCategoria = document.querySelector("#categoria");
const selectProducto = document.getElementById("producto");

selectCategoria.addEventListener("change", function() {
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

});

$('.select2Prod').select2({
	placeholder: 'Busca un producto',
	width: '100%',
	theme: "bootstrap-5",
	allowClear: true,
});

$('.select2Provider').select2({
	placeholder: 'Busca un proveedor',
	width: '100%',
	theme: "bootstrap-5",
	allowClear: true,
});