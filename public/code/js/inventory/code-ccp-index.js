console.log("Starting");

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
            ajax: {
                url: "/showCcpInventory",
                type: "GET",
                data: {
                    centrocostoId: centrocostoId,
                    categoriaId: categoriaId,                   
                },
                dataSrc: function (response) {
                    // Modificar los datos antes de que se procesen en la tabla
                    var modifiedData = response.data.map(function (item) {
                        return {
                            namecategoria: item.namecategoria,
                            nameproducto: item.nameproducto,
                            fisico:
                                '<input type="text" class="edit-fisico" value="' +
                                item.fisico +
                                '" />',
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
                { data: "fisico", name: "fisico" },
            ],
            order: [[2, "ASC"]],
            language: {
                processing: "Procesando...",
                lengthMenu: "Mostrar _MENU_ registros",
                zeroRecords: "No se encontraron resultados",
                emptyTable: "Ningún dato disponible en esta tabla",
                info: "Mostrando del _START_ al _END_ de un total de _TOTAL_ registros",
                infoEmpty:
                    "Mostrando registros del 0 al 0 de un total de 0 registros",
                infoFiltered: "(filtrado de un total de _MAX_ registros)",
                search: "Buscar:",
                paginate: {
                    first: "Primero",
                    last: "Último",
                    next: "Siguiente",
                    previous: "Anterior",
                },
            },
            dom: "Bfrtip",
            buttons: ["copy", "csv", "excel", "pdf"],
        });
    }

    function updateCcpInventory(productId, fisico) {
        console.log("Updating inventory with productId:", productId);
        console.log("New fisico value:", fisico);

        $.ajax({
            url: "/updateCcpInventory",
            type: "POST",
            data: {
                productId: productId,
                fisico: fisico,
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

        $(document).on("keypress", ".edit-fisico", function (event) {
            if (event.which === 13) {
                event.preventDefault();
                var fisico = $(this).val();
                 var productId = $(this).closest("tr").find(".productId").val();
                //var productId = $(this).val();

                console.log("Enter key pressed");
                console.log("fisico value:", fisico);
                console.log("productId:", productId);

                updateCcpInventory(productId, fisico);
            }
        });
    });
});
