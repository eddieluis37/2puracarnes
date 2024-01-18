console.log("Comenzando");

const valor_a_pagar_efectivo = document.querySelector(
    "#valor_a_pagar_efectivo"
);
const valor_a_pagar_tarjeta = document.querySelector("#valor_a_pagar_tarjeta");

const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
$(document).ready(function () {
    var dataTable;

    function initializeDataTable(listaprecioId = "-1", categoriaId = "-1") {
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
                url: "/showAPPSwitch",
                type: "GET",
                data: {
                    listaprecioId: listaprecioId,
                    categoriaId: categoriaId,
                },
                dataSrc: function (response) {
                    // Modificar los datos antes de que se procesen en la tabla
                    var modifiedData = response.data.map(function (item) {
                        return {
                            namecategoria: item.namecategoria,
                            nameproducto: item.nameproducto,
                            costo: item.costo,
                            porc_util_proyectada: item.porc_util_proyectada,
                            precio_proyectado: item.precio_proyectado,
                            precio: getPriceInput(item.precio),
                            porc_iva: item.porc_iva,
                            utilidad: item.utilidad,
                            porc_utilidad: item.porc_utilidad,
                            productId: item.productId,
                            status: getStatusCheckbox(
                                item.status,
                                item.productId
                            ),
                        };
                    });
                    return modifiedData;
                },
            },
            columns: [
                { data: "namecategoria", name: "namecategoria" },
                { data: "productId", name: "productId" },
                { data: "nameproducto", name: "nameproducto" },
                { data: "costo", name: "costo" },
                { data: "porc_util_proyectada", name: "porc_util_proyectada" },
                { data: "precio_proyectado", name: "precio_proyectado" },
                { data: "precio", name: "precio" },
                { data: "porc_iva", name: "porc_iva" },
                { data: "utilidad", name: "utilidad" },
                { data: "porc_utilidad", name: "porc_utilidad" },
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
        });
    }

    function getStatusCheckbox(status, productId) {
        var checkboxChecked = status ? "checked" : "";
        return (
            '<input type="checkbox" class="edit-status" data-product-id="' +
            productId +
            '" ' +
            checkboxChecked +
            " />"
        );
    }

    function getPriceInput(precio) {
        return (
            '<input type="text" class="edit-precio" value="' +
            new Intl.NumberFormat("es-CO", {
                style: "currency",
                currency: "COP",
                minimumFractionDigits: 0,
            }).format(precio) +
            '" size="8" />'
        );
    }

    function updateAPPSwitch(productId, precio, listaprecioId, status) {
        console.log("productId:", productId);
        console.log("precio", precio);
        console.log("listaprecioId:", listaprecioId);
        $.ajax({
            headers: {
                "X-CSRF-TOKEN": $('meta[name="csrf-token"]').attr("content"),
            },
            url: "/updateAPPSwitch",
            type: "POST",
            data: {
                productId: productId,
                precio: precio,
                status: status,
                listaprecioId: listaprecioId,
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
            var precio = $(this)
                .val()
                .replace(/[$\s.,]/g, "");
            var regex =
                /^(?:\d{1,2}(?:,\d{3})*(?:\.\d{2})?|\d{1,5}(?:\.\d{2})?)$/;
            if (regex.test(precio)) {
                var productId = $(this).closest("tr").find("td:eq(1)").text();
                var listaprecioId = $("#listaprecio").val();
                updateAPPSwitch(productId, precio, listaprecioId, null);
                $(this)
                    .closest("tr")
                    .next()
                    .find(".edit-precio")
                    .focus()
                    .select();
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
        var listaprecioId = $("#listaprecio").val();
        var status = $(this).is(":checked") ? 1 : 0;
        updateAPPSwitch(productId, null, listaprecioId, status);
        /* dataTable.ajax.reload(); */
    }

    initializeDataTable("-1");
    $("#listaprecio, #categoria").on("change", function () {
        var listaprecioId = $("#listaprecio").val();
        var categoriaId = $("#categoria").val();
        dataTable.destroy();
        initializeDataTable(listaprecioId, categoriaId);
    });

    $(document).on("keydown", ".edit-precio", handlePriceFamaInput);
    $(document).on("change", ".edit-status", handleStatusChange);
});

function sugerirValor(valor) {
    document.getElementById("valor_a_pagar_efectivo").value = valor;
}

valor_a_pagar_efectivo.addEventListener("change", function () {
    const enteredValue = formatMoneyNumber(valor_a_pagar_efectivo.value);
    console.log("Entered value: " + enteredValue);
    valor_a_pagar_efectivo.value = formatCantidadSinCero(enteredValue);
});

valor_a_pagar_tarjeta.addEventListener("change", function () {
    const enteredValue = formatMoneyNumber(valor_a_pagar_tarjeta.value);
    console.log("Entered value: " + enteredValue);
    valor_a_pagar_tarjeta.value = formatCantidadSinCero(enteredValue);
});

valor_a_pagar_otros.addEventListener("change", function () {
    const enteredValue = formatMoneyNumber(valor_a_pagar_otros.value);
    console.log("Entered value: " + enteredValue);
    valor_a_pagar_otros.value = formatCantidadSinCero(enteredValue);
});

valor_a_pagar_credito.addEventListener("change", function () {
    const enteredValue = formatMoneyNumber(valor_a_pagar_credito.value);
    console.log("Entered value: " + enteredValue);
    valor_a_pagar_credito.value = formatCantidadSinCero(enteredValue);
});

$(document).ready(function() {
    var clienteMostrador = "CLIENTE MOSTRADOR";
    var thirdName = "{{$venta->third->name}}";
    
    if (thirdName === clienteMostrador) {
        $("#valor_a_pagar_credito").prop("disabled", true);
    }
});