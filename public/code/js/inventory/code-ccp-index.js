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
                url: "/showCcpInventory",
                type: "GET",
                data: {
                    centrocostoId: centrocostoId,
                    categoriaId: categoriaId,
                },
                dataSrc: function (response) {
                    // Modificar los datos antes de que se procesen en la tabla
                    var modifiedData = response.data.map(function (item) {
                        var subtotal =  (item.fisico * item.costo);
                        return {
                            namecategoria: item.namecategoria,
                            nameproducto: item.nameproducto,
                            fisico:
                                '<input type="text" class="edit-fisico text-right" value="' +
                                item.fisico +
                                '" size="4" />',

                            productId: item.productId,
                            costo: item.costo,
                            subtotal: subtotal,
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
                {
                    data: "costo",
                    name: "costo",
                    render: function (data, type, row) {
                        return "$ " + formatCantidadSinCero(data);
                    },
                },
                {
                    data: "subtotal",
                    name: "subtotal",
                    render: function (data, type, row) {
                        return "$ " + formatCantidadSinCero(data);
                    },
                },
                
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

    function updateCcpInventory(productId, fisico, centrocostoId) {
        console.log("productId:", productId);
        console.log("fisico:", fisico);
        console.log("centrocostoId:", centrocostoId);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/updateCcpInventory",
            type: "POST",
            data: {
                productId: productId,
                fisico: fisico,
                centrocostoId: centrocostoId,
            },
            success: function (response) {
                console.log("Update successful");
                dataTable.ajax.reload();
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

        $(document).on("keydown", ".edit-fisico", function (event) {
            if (event.which === 13 || event.which === 9) {
                event.preventDefault();
                var fisico = $(this).val().replace(",", ".");

                // Expresion Regular para validar que solo acepte numeros enteros y decimales
                var regex = /^[0-9]+(\.[0-9]{1,2})?$/;

                if (regex.test(fisico)) {
                    var productId = $(this)
                        .closest("tr")
                        .find("td:eq(1)")
                        .text();
                    var centrocostoId = $("#centrocosto").val();
                    updateCcpInventory(productId, fisico, centrocostoId);

                    $(this)
                        .closest("tr")
                        .next()
                        .find(".edit-fisico")
                        .focus()
                        .select();
                } else {
                    Swal.fire({
                        icon: "error",
                        title: "Número incorrecto",
                        text: "Solo acepta Números enteros con decimales de (2) dos cifras, separados por . o por ,",
                    });
                    console.error("Solo acepta numero enteros y decimales");
                }
            }
        });
    });
});
