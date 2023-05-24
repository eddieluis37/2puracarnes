console.log("Starting")
const btnAddCompensadoRes = document.querySelector("#btnAddCompensadoRes");
const formCompensadoRes = document.querySelector("#form-compensado-res");
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');
const btnClose = document.querySelector("#btnModalClose");


$(document).ready(function () {
    $(function() {
        $('#tableCompensado').DataTable({
            "paging": true,
            "pageLength": 5,
            /*"lengthChange": false,*/
            "autoWidth": false,
            processing: true,
            serverSide: true,
            ajax: {
                url:'/showlistcompensado',
                type: 'GET',
            },
            columns: [
                { data:'namecategoria', name: 'namecategoria'},
                { data: 'namethird', name: 'namethird'},
                { data: 'namecentrocosto', name: 'namecentrocosto' },
                { data:'factura', name: 'factura'},
                { data: 'date', name: 'date' },
                {data: 'action', name:'action'}
            ],
            //order: [[0, 'ASC']],
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

btnAddCompensadoRes.addEventListener("click", async (e) => {
    e.preventDefault();
    const dataform = new FormData(formCompensadoRes);
    send(dataform,'/compensadosave').then((resp) => {
        console.log(resp);
        if (resp.status == 1) {
            formCompensadoRes.reset();   
            btnClose.click();
            refresh_table();
            //document.querySelector(".sds").innerHTML= "";
        }
        if (resp.status == 0) {
            let errors = resp.errors;
            console.log(errors);
            $.each(errors, function(field, messages) {
                console.log(field, messages)
                let $input = $('[name="' + field + '"]');
                let $errorContainer = $input.closest('.form-group').find('.error-message');
                $errorContainer.html(messages[0]);
                $errorContainer.show();
            });        
        }
    });
})

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

}

const editCompensado = (id) => {
    console.log(id);
    const dataform = new FormData();
    dataform.append('id', id);
    send(dataform,'/compensadoById').then((resp) => {
        console.log(resp);
        const modal = new bootstrap.Modal(document.getElementById('modal-create-compensado'));
        modal.show();
    });
}
