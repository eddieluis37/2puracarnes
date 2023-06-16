    
    const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
    const formBeneficio = document.querySelector("#form-beneficio-aves");
    const btnModalClose = document.querySelector("#btnModalClose");

    $(document).ready(function () {
        $(function () {
            $("#tableBeneficiores").DataTable({
                paging: true,
                pageLength: 5,
                /*"lengthChange": false,*/
                autoWidth: false,
                processing: true,
                serverSide: true,
                ajax: {
                    url: "/showbeneficioaves",
                    type: "GET",
                },
                columns: [
                    { data: "id", name: "id" },
                    { data: "namethird", name: "namethird" },
                    { data: "date", name: "date" },
                    { data: "factura", name: "factura" },
                    { data: "lote", name: "lote" },
                    { data: "action", name: "action" },
                ],
                order: [[0, 'DESC']],
                language: {
                    processing: "Procesando...",
                    lengthMenu: "Mostrar _MENU_ registros",
                    zeroRecords: "No se encontraron resultados",
                    emptyTable: "Ningún dato disponible en esta tabla",
                    sInfo: "Mostrando del _START_ al _END_ de total _TOTAL_ registros",
                    infoEmpty:
                        "Mostrando registros del 0 al 0 de un total de 0 registros",
                    infoFiltered: "(filtrado de un total de _MAX_ registros)",
                    search: "Buscar:",
                    infoThousands: ",",
                    loadingRecords: "Cargando...",
                    paginate: {
                        first: "Primero",
                        last: "Último",
                        next: "Siguiente",
                        previous: "Anterior",
                    },
                },
            });
        });
        $(".selectProvider").select2({
            placeholder: "Busca un proveedor",
            width: "100%",
            theme: "bootstrap-5",
            allowClear: true,
            dropdownParent: $("#modal-create-beneficioaves"),
        });
        $(".selectPieles").select2({
            placeholder: "Buscar un Cliente Piel",
            width: "100%",
            theme: "bootstrap-5",
            allowClear: true,
            dropdownParent: $("#modal-create-beneficioaves"),
        });
        $(".selectVisceras").select2({
            placeholder: "Buscar un Cliente Viscera",
            width: "100%",
            theme: "bootstrap-5",
            allowClear: true,
            dropdownParent: $("#modal-create-beneficioaves"),
        });
    });

    const refresh_table = () => {
        let table = $("#tableBeneficiores").dataTable();
        table.fnDraw(false);
    };