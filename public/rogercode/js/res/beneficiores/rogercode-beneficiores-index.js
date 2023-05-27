console.log("benedicore Starting")
$(document).ready(function () {
    $(function() {
        $('#tableBeneficiores').DataTable({
            "paging": true,
            "pageLength": 5,
            /*"lengthChange": false,*/
            "autoWidth": false,
            processing: true,
            serverSide: true,
            ajax: {
                url:'/showbeneficiores',
                type: 'GET',
            },
            columns: [
                { data:'namethird', name: 'namethird'},
                { data: 'date', name: 'date' },
                { data: 'factura', name: 'factura'},
                { data: 'lote', name: 'lote'},
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
    /*$('.select2Provider').select2({
	    placeholder: 'Busca un proveedor',
	    width: '100%',
	    theme: "bootstrap-5",
	    allowClear: true,
    });*/
});           