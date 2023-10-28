console.log("Comenzando");
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");

$(document).ready(function () {
    var dataTable;

    function initializeDataTable(centrocostoId = "-1", categoriaId = "-1") {
        dataTable = $("#tableInventory").DataTable({
            paging: true,
            pageLength: 15,
            autoWidth: false,
            processing: true,
            serverSide: true,
            lengthMenu: [
                [10, 15, 25, 50, -1],
                [10, 15, 25, 50, "Todos"],
            ],
            ajax: {
                url: "/showCcpSwitch",
                type: "GET",
                data: {
                    centrocostoId: centrocostoId,
                    categoriaId: categoriaId,
                },
                dataSrc: function (response) {
                    // Modificar los datos antes de que se procesen en la tabla
                    var modifiedData = response.data.map(function (item) {
                        var statusButton = item.status ? '<button class="btn btn-success">Activo</button>' : '<button class="btn btn-danger">Inactivo</button>';
                
                        return {
                            namecategoria: item.namecategoria,
                            nameproducto: item.nameproducto,
                            status: '<div class="text-center">' + statusButton + '</div>',
                            price_fama: '<input type="text" class="edit-price_fama" value="' + new Intl.NumberFormat('es-CO', { style: 'currency', currency: 'COP', minimumFractionDigits: 0 }).format(item.price_fama) + '" size="8" />',
                            productId: item.productId,
                        };
                    });
                    return modifiedData;
                },
            },
            columns: [
                { data: "namecategoria", name: "namecategoria" },
                { data: "productId", name: "productId" },
                { data: "nameproducto", name: "nameproducto" },
                { data: "price_fama", name: "price_fama" },
                { data: "status", name: "status" },
            ],
            order: [[2, "ASC"]],
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
            /*  dom: "Bfrtip",
            buttons: ["copy", "csv", "excel", "pdf"], */
        });
    }

    function updateCcpSwitch(productId, price_fama, centrocostoId, status) {
        console.log("productId:", productId);
        console.log("price_fama:", price_fama);
        console.log("centrocostoId:", centrocostoId);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/updateCcpSwitch",
            type: "POST",
            data: {
                productId: productId,
                price_fama: price_fama,
                status: status,
                centrocostoId: centrocostoId,
            },
            success: function (response) {
                console.log("Update successful");
            },
            error: function (xhr, status, error) {
                console.error("Error updating");
            },
        });
    }

    $(document).ready(function () {
        initializeDataTable("-1");

        $("#centrocosto, #categoria").on("change", function () {
            var centrocostoId = $("#centrocosto").val();
            var categoriaId = $("#categoria").val();

            dataTable.destroy();
            initializeDataTable(centrocostoId, categoriaId);
        });

        $(document).on("keydown", ".edit-price_fama", function (event) {
            if (event.which === 13 || event.which === 9) {
                event.preventDefault();
                var price_fama = $(this).val().replace(/[$\s.,]/g, '');
               
                var regex = /^(?:\d{1,3}(?:,\d{3})*(?:\.\d{2})?|\d{1,6})$/;
                
                if (regex.test(price_fama)) {
                    var productId = $(this)
                        .closest("tr")
                        .find("td:eq(1)")
                        .text();
                    var centrocostoId = $("#centrocosto").val();
                    updateCcpSwitch(productId, price_fama, centrocostoId);

                    $(this).closest("tr").next().find(".edit-price_fama").focus().select();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Número incorrecto",
                        text: "Solo acepta Números enteros hasta el 100.000",
                    });
                    console.error("Solo acepta numero enteros y decimales");
                }
            }
        });
    });
});
