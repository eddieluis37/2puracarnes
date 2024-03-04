console.log("Starting");
const btnAddVentaDomicilio = document.querySelector("#btnAddVentaDomicilio");
const formCompensadoRes = document.querySelector("#form-compensado-res");
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const btnClose = document.querySelector("#btnModalClose");

const selectCategory = document.querySelector("#categoria");
const selectProvider = document.querySelector("#provider");
const selectCentrocosto = document.querySelector("#centrocosto");
const inputFactura = document.querySelector("#factura");
const sale_id = document.querySelector("#ventaId");
const contentform = document.querySelector("#contentDisable");

$(document).ready(function () {
    $(function () {
        $("#tableCompensado").DataTable({
            paging: true,
            pageLength: 50,
            /*"lengthChange": false,*/
            autoWidth: false,
            processing: true,
            serverSide: true,
            ajax: {
                url: "/showOrder",
                type: "GET",
            },
            columns: [
                { data: "id", name: "id" },                
                {
                    data: "namethird",
                    name: "namethird",
                    render: function (data) {
                        if (data.length > 15) {
                            return data.substring(0, 7) + "...";
                        } else {
                            return data;
                        }
                    },
                },
                {
                    data: "namecentrocosto",
                    name: "namecentrocosto",
                    render: function (data) {
                        if (data.length > 5) {
                            return data.substring(0, 3) + "...";
                        } else {
                            return data;
                        }
                    },
                },
              /*   { data: "saresolucion", name: "saresolucion" }, */
              /*   { data: "ncresolucion", name: "ncresolucion" }, */
                { data: "status", name: "status" }, 
                {
                    data: "total_valor_a_pagar",
                    name: "total_valor_a_pagar",
                    render: function (data) {
                        return (
                            "$ " +
                            parseFloat(data).toLocaleString(undefined, {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0,
                            })
                        );
                    },
                },  
                {
                    data: "total_utilidad",
                    name: "total_utilidad",
                    render: function (data) {
                        return (
                            "$ " +
                            parseFloat(data).toLocaleString(undefined, {
                                minimumFractionDigits: 0,
                                maximumFractionDigits: 0,
                            })
                        );
                    },
                },                       
                { data: "date", name: "date" },
                
                { data: "resolucion", name: "resolucion" },
                {
                    data: "nombre_vendedor",
                    name: "nombre_vendedor",
                    render: function (data) {
                        if (data.length > 9) {
                            return data.substring(0, 9) + "...";
                        } else {
                            return data;
                        }
                    },
                },
                { data: "action", name: "action" },
            ],
            order: [[0, "DESC"]],
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
    $('.select2Cliente').select2({
	    placeholder: 'Busca un cliente',
	    width: '100%',
	    theme: "bootstrap-5",
	    allowClear: true,
    });
    $(".select2Ventas").select2({
        placeholder: "Busca una factura",
        width: "100%",
        theme: "bootstrap-5",
        allowClear: true,
    });
});

const send = async (dataform, ruta) => {
    let response = await fetch(ruta, {
        headers: {
            "X-CSRF-TOKEN": token,
        },
        method: "POST",
        body: dataform,
    });
    let data = await response.json();
    //console.log(data);
    return data;
};

const refresh_table = () => {
    let table = $("#tableCompensado").dataTable();
    table.fnDraw(false);
};
const showModalcreate = () => {
    if (contentform.hasAttribute("disabled")) {
        contentform.removeAttribute("disabled");
        $("#provider").prop("disabled", false);
    }
    $("#provider").val("").trigger("change");
    formCompensadoRes.reset();
    sale_id.value = 0;
};

const showDataForm = (id) => {
    console.log(id);
    const dataform = new FormData();
    dataform.append("id", id);
    send(dataform, "/saleById").then((resp) => {
        console.log(resp);
        console.log(resp.reg);
        showData(resp);
        $("#provider").prop("disabled", true);
        contentform.setAttribute("disabled", "disabled");
    });
};

const editCompensado = (id) => {
    console.log(id);
    const dataform = new FormData();
    dataform.append("id", id);
    send(dataform, "/saleById").then((resp) => {
        console.log(resp);
        console.log(resp.reg);
        showData(resp);
        if (contentform.hasAttribute("disabled")) {
            contentform.removeAttribute("disabled");
            $("#provider").prop("disabled", false);
        }
    });
};

const showData = (resp) => {
    let register = resp.reg;
    sale_id.value = register.id;
    /*  selectCategory.value = register.categoria_id; */
    $("#provider").val(register.thirds_id).trigger("change");
    selectCentrocosto.value = register.centrocosto_id;
    /*    inputFactura.value = register.factura; */
    const modal = new bootstrap.Modal(
        document.getElementById("modal-create-notacredito")
    );
    modal.show();
};

const downCompensado = (id) => {
    swal({
        title: "CONFIRMAR",
        text: "¿CONFIRMAS ELIMINAR EL REGISTRO?",
        type: "warning",
        showCancelButton: true,
        cancelButtonText: "Cerrar",
        cancelButtonColor: "#fff",
        confirmButtonColor: "#3B3F5C",
        confirmButtonText: "Aceptar",
    }).then(function (result) {
        if (result.value) {
            console.log(id);
            const dataform = new FormData();
            dataform.append("id", id);
            send(dataform, "/downnotacredito").then((resp) => {
                console.log(resp);
                refresh_table();
            });
        }
    });
};
