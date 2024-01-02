console.log("Comenzando");
const token = document.querySelector('meta[name="csrf-token"]').getAttribute("content");
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
                        return {
                            namecategoria: item.namecategoria,
                            nameproducto: item.nameproducto,
                            status: getStatusCheckbox(item.status, item.productId),
                            level_product_id: item.level_product_id,
                            costo: item.costo,
                            price_fama: getPriceInput(item.price_fama),
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
                { data: "level_product_id", name: "level_product_id" },
                {
                    data: "costo",
                    name: "costo",
                    render: function (data, type, row) {
                        return "$ " + formatCantidadSinCero(data);
                    },
                },
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
                infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros",
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
    }

    function getStatusCheckbox(status, productId) {
        var checkboxChecked = status ? "checked" : "";
        return '<input type="checkbox" class="edit-status" data-product-id="' + productId + '" ' + checkboxChecked + ' />';
    }

    function getPriceInput(price_fama) {
        return '<input type="text" class="edit-price_fama" value="' + new Intl.NumberFormat("es-CO", { style: "currency", currency: "COP", minimumFractionDigits: 0 }).format(price_fama) + '" size="8" />';
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

    function handlePriceFamaInput(event) {
        if (event.which === 13 || event.which === 9) {
            event.preventDefault();
            var price_fama = $(this).val().replace(/[$\s.,]/g, "");
            var regex = /^(?:\d{1,2}(?:,\d{3})*(?:\.\d{2})?|\d{1,5}(?:\.\d{2})?)$/;
            if (regex.test(price_fama)) {
                var productId = $(this).closest("tr").find("td:eq(1)").text();
                var centrocostoId = $("#centrocosto").val();
                updateCcpSwitch(productId, price_fama, centrocostoId, null);
                $(this).closest("tr").next().find(".edit-price_fama").focus().select();
            } else {
                Swal.fire({
                    icon: "error",
                    title: "Precio mínimo incorrecto",
                    text: "Solo acepta valores menores a $ 99.999",
                });
                console.error("Solo acepta números enteros y decimales");
            }
        }
    }

    function handleStatusChange() {
        var productId = $(this).data("product-id");
        var centrocostoId = $("#centrocosto").val();
        var status = $(this).is(":checked") ? 1 : 0;
        updateCcpSwitch(productId, null, centrocostoId, status);
        /* dataTable.ajax.reload(); */
    }

    initializeDataTable("-1");
    $("#centrocosto, #categoria").on("change", function () {
        var centrocostoId = $("#centrocosto").val();
        var categoriaId = $("#categoria").val();
        dataTable.destroy();
        initializeDataTable(centrocostoId, categoriaId);
    });

    $(document).on("keydown", ".edit-price_fama", handlePriceFamaInput);
    $(document).on("change", ".edit-status", handleStatusChange);
});