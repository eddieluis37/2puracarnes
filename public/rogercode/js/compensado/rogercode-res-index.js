console.log("Starting")
const btnAddCompensadoRes = document.querySelector("#btnAddCompensadoRes");
const formCompensadoRes = document.querySelector("#form-compensado-res");
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const btnClose = document.querySelector("#btnModalClose");

const selectCategory = document.querySelector("#categoria");
const selectProvider = document.querySelector("#provider");
const selectCentrocosto = document.querySelector("#centrocosto");
const inputFactura = document.querySelector("#factura");
const compensado_id = document.querySelector("#compensadoId");
const contentform = document.querySelector("#contentDisable");


$(document).ready(function () {
    $(function() {
        $('#tableCompensado').DataTable({
            "paging": true,
            "pageLength": 50,
            /*"lengthChange": false,*/
            "autoWidth": false,
            processing: true,
            serverSide: true,
            ajax: {
                url:'/showlistcompensado',
                type: 'GET',
            },
            columns: [
                { data:'id', name: 'id'},                
                { data: 'namethird', name: 'namethird'},
                { data: 'namecentrocosto', name: 'namecentrocosto' },
                { data:'factura', name: 'factura'},
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
    $('.select2Provider').select2({
	    placeholder: 'Busca un proveedor',
	    width: '100%',
	    theme: "bootstrap-5",
	    allowClear: true,
    });
});           


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

const refresh_table = () => {
    let table = $('#tableCompensado').dataTable(); 
    table.fnDraw(false);
}
const showModalcreate = () => {
    if(contentform.hasAttribute('disabled')){
        contentform.removeAttribute('disabled');
        $('#provider').prop('disabled', false);
    }
    $('#provider').val('').trigger('change');
    formCompensadoRes.reset();
    compensado_id.value = 0;
}

const showDataForm = (id) => {
    console.log(id);
    const dataform = new FormData();
    dataform.append('id', id);
    send(dataform,'/compensadoById').then((resp) => {
        console.log(resp);
        console.log(resp.reg);
        showData(resp);
        $('#provider').prop('disabled', true);
        contentform.setAttribute('disabled','disabled');
    });
}

const editCompensado = (id) => {
    console.log(id);
    const dataform = new FormData();
    dataform.append('id', id);
    send(dataform,'/compensadoById').then((resp) => {
        console.log(resp);
        console.log(resp.reg);
        showData(resp);
        if(contentform.hasAttribute('disabled')){
            contentform.removeAttribute('disabled');
            $('#provider').prop('disabled', false);
        }
    });
}

const showData = (resp) => {
    let register = resp.reg;
    compensado_id.value = register.id;
   /*  selectCategory.value = register.categoria_id; */
    $('#provider').val(register.thirds_id).trigger('change');
    selectCentrocosto.value = register.centrocosto_id;
    inputFactura.value = register.factura;
    const modal = new bootstrap.Modal(document.getElementById('modal-create-compensado'));
    modal.show();
}

const downCompensado = (id) => { 
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
            send(dataform,'/downmaincompensado').then((resp) => {
                console.log(resp);
                refresh_table();
            });
        }

    })
}