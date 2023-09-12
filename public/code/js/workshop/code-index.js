console.log("Starting")
const btnAddWorkshop = document.querySelector("#btnAddWorkshop");
const formWorkshop = document.querySelector("#form-workshop");
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const btnClose = document.querySelector("#btnModalClose");

const selectCategory = document.querySelector("#categoria");
const selectCentrocosto = document.querySelector("#centrocosto");
const taller_id = document.querySelector("#tallerId");
const contentform = document.querySelector("#contentDisable");
const selectCortePadre = document.querySelector("#selectCortePadre");


$(document).ready(function () {
    $(function() {
        $('#tableWorkshop').DataTable({
            "paging": true,
            "pageLength": 5,
            "autoWidth": false,
            processing: true,
            serverSide: true,
            ajax: {
                url:'/showworkshop',
                type: 'GET',
            },
            columns: [
                { data:'id', name: 'id'},
                { data:'namecategoria', name: 'namecategoria'},
                { data: 'namecentrocosto', name: 'namecentrocosto' },
                { data: 'namecut', name: 'namecut' },
                { data: 'peso_producto_padre', name: 'namepeso_producto_padre' },
                {
                    data: 'costo_kilo_padre',
                    name: 'namecosto_kilo_padre',
                    render: function(data) {
                        return "$ " + parseFloat(data).toLocaleString(undefined, {
                            minimumFractionDigits: 0,
                            maximumFractionDigits: 0
                        });
                    }
                },              
                { data: 'date', name: 'date' },
                {data: 'action', name:'action'}
            ],
            order: [[0, 'DESC']],
            language:{
		        "processing": "Procesando...",
    		    "lengthMenu": "Mostrar _MENU_ registros",
    		    "zeroRecords": "No se encontraron resultados",
    		    "emptyTable": "Ningún dato disponible en esta tabla",
		        "sInfo":      "Mostrando del _START_ al _END_ de total _TOTAL_ registros",
    		    "infoEmpty": "Mostrando registros del 0 al 0 de un total de 0 registros",
    		    "infoFiltered": "(filtrado de un total de _MAX_ registros)",
    		    "search": "Buscar:",
    		    "infoThousands": ",",
    		    "loadingRecords": "Cargando...",
		        "paginate": {
        	        "first": "Primero",
        	        "last": "Último",
        	        "next": "Siguiente",
        	        "previous": "Anterior"
    		    },
            },
        });
    });
    $('.select2corte').select2({
	    placeholder: 'Busca un producto',
	    width: '100%',
	    theme: "bootstrap-5",
	    allowClear: true,
    });
});           


const showModalcreate = () => {
    if(contentform.hasAttribute('disabled')){
        contentform.removeAttribute('disabled');
        $('.select2corte').prop('disabled', false);
    }
    $('.select2corte').val('').trigger('change');
    selectCortePadre.innerHTML = "";
    formWorkshop.reset();
    taller_id.value = 0;
}

//const editAlistamiento = (id) => {
    //console.log(id);
    //const dataform = new FormData();
    //dataform.append('id', id);
    //send(dataform,'/alistamientoById').then((resp) => {
        //console.log(resp);
        //console.log(resp.reg);
        //showData(resp);
        //if(contentform.hasAttribute('disabled')){
            //contentform.removeAttribute('disabled');
            //$('#provider').prop('disabled', false);
        //}
    //});
//}

const showDataForm = (id) => {
    console.log(id);
    const dataform = new FormData();
    dataform.append('id', id);
    send(dataform,'/workshopById').then((resp) => {
        console.log(resp);
        console.log(resp.reg);
        showData(resp);
        setTimeout(() => {
            $('.select2corte').val(resp.reg.meatcut_id).trigger('change');
        }, 1000);
        $('.select2corte').prop('disabled', true);
        contentform.setAttribute('disabled','disabled');
    });
}

const showData = (resp) => {
    let register = resp.reg;
    //alistamiento_id.value = register.id;
    selectCategory.value = register.categoria_id;
    selectCentrocosto.value = register.centrocosto_id;
    getCortes(register.categoria_id);
    
    const modal = new bootstrap.Modal(document.getElementById('modal-create-workshop'));
    modal.show();
}

const send = async (dataform,ruta) => {
    let response = await fetch(ruta, {
    headers: {
        'X-CSRF-TOKEN': token
    },
    method: 'POST',
    body: dataform
    });
    let data = await response.json();
    //console.log(data);
    return data;
}

selectCategory.addEventListener("change", function() {
    const selectedValue = this.value;
    console.log("Selected value:", selectedValue);
    getCortes(selectedValue);
    
});

getCortes = (categoryId) => {
    const dataform = new FormData();
    dataform.append("categoriaId", Number(categoryId));
    send(dataform,'/getproductospadre').then((result) => {
        console.log(result);
        let prod = result.products;
        console.log(prod);
        //showDataTable(result);
        selectCortePadre.innerHTML = "";
        selectCortePadre.innerHTML += `<option value="">Seleccione el producto</option>`;
        // Create and append options to the select element
        prod.forEach(option => {
        const optionElement = document.createElement("option");
        optionElement.value = option.id;
        optionElement.text = option.name;
        selectCortePadre.appendChild(optionElement);
        });
    });

}

const downAlistamiento = (id) => { 
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
            console.log(id);
            const dataform = new FormData();
            dataform.append('id', id);
            send(dataform,'/downmmainworkshop').then((resp) => {
                console.log(resp);
                refresh_table();
            });
        }
    })
}


const refresh_table = () => {
    let table = $('#tableWorkshop').dataTable(); 
    table.fnDraw(false);
}