var plantasacrificio_id = $("#plantasacrificio_id");
var cantidad = $("#cantidad");
var total_factura = $("#total_factura");
var valor_kg_pollo = $("#valor_kg_pollo");
var peso_pie_planta = $("#peso_pie_planta");
var peso_canales_pollo_planta = $("#peso_canales_pollo_planta");
var promedio_canal_fria_sala = $("#promedio_canal_fria_sala");
var promedio_pie_kg = $("#promedio_pie_kg");
var promedio_canal_kg = $("#promedio_canal_kg");
var subtotal = $("#subtotal");
var menudencia_pollo_porc = $("#menudencia_pollo_porc");
var mollejas_corazones_porc = $("#mollejas_corazones_porc");
var porc_pollo = $("#porc_pollo");
var despojos_mermas = $("#despojos_mermas");

plantasacrificio_id.change(function () {
    var plantasacrificio_id = $("#plantasacrificio_id");
    $(obtener_registroid(plantasacrificio_id.val()));
});

cantidad.change(function () {
    calculatotales();
});

peso_pie_planta.change(function () {
    calculatotales();
});

peso_canales_pollo_planta.change(function () {
    calculatotales();
});

promedio_canal_fria_sala.change(function () {
    calculatotales();
});

promedio_pie_kg.change(function () {
    calculatotales();
});

promedio_canal_kg.change(function () {
    calculatotales();
});

menudencia_pollo_porc.change(function () {
    calculatotales();
});

mollejas_corazones_porc.change(function () {
    calculatotales();
});

porc_pollo.change(function () {
    calculatotales();
});

function obtener_registroid(plantasacrificio_id) {
    // alert("id "+plantasacrificio_id);
    $.ajax({
        url: "/get_plantasacrificiopollo_by_id",
        dataType: "json",
        type: "GET",
        headers: {
            "X-CSRF-TOKEN": "{{ csrf_token() }}",
        },
        data: {
            plantasacrificio_id: plantasacrificio_id,
        },
        success: function (data1) {
            console.log(data1);
            $("#sacrificio").val(formatCantidadSinCero(data1.sacrificio));

            calculatotales();
        },
    });
}

valor_kg_pollo.change(function () { 
    let canal = formatkg($('#valor_kg_pollo').val());
    $('#valor_kg_pollo').val(canal);
    console.log("peso :" + canal)
    calculatotales(); 
  });

peso_pie_planta.change(function () {
    let costo2 = formatMoneyNumber($("#peso_pie_planta").val());
    $("#peso_pie_planta").val(formatCantidadSinCero(costo2));
    calculatotales();
});

promedio_canal_fria_sala.change(function () {
    let costo2 = formatMoneyNumber($("#promedio_canal_fria_sala").val());
    $("#promedio_canal_fria_sala").val(formatCantidadSinCero(costo2));
    calculatotales();
});

function calculatotales() {
    let cantidad = $("#cantidad").val();
    let sacrificio = $("#sacrificio").val();
    let peso_pie_planta = $("#peso_pie_planta").val();
    let peso_canales_pollo_planta = $("#peso_canales_pollo_planta").val();

    //Total factura
    var valor_kg_pollo = formatMoneyNumber($("#valor_kg_pollo").val());
    sacrificio = sacrificio.replace(/[,.]/g, ""); // Elimina puntos y comas
    console.log("valor_kg_pollo: " + valor_kg_pollo);
    console.log("sacrificio: " + sacrificio);
    console.log("peso_pie_planta: " + peso_pie_planta);
    console.log("peso_canales_pollo_planta: " + peso_canales_pollo_planta);
    let total = cantidad * sacrificio + peso_pie_planta * valor_kg_pollo;
    $("#total_factura").val(formatCantidadSinCero(total));

    // promedio_canal_fria_sala
    let promedio_canal_kg = $("#promedio_canal_kg").val();
    let promedio_pie_kg = $("#promedio_pie_kg").val();
    console.log("promedio_pie_kg: " + promedio_pie_kg);
    console.log("peso_pie_planta: " + peso_pie_planta);
    let valorPromedio = (promedio_canal_kg / promedio_pie_kg) * 100;
    $("#promedio_canal_fria_sala").val(formatCantidad(valorPromedio));

    // subtotal
    /*     se utilizan  parseFloat  para convertir los valores de los campos  menudencia_pollo_porc  y  mollejas_corazones_porc 
    a números decimales antes de sumarlos a  valorPromedio . Luego, se asigna el resultado de la suma al campo  subtotal
    después de formatearlo con la función  formatCantidad . */
    console.log("promedio_canal_fria_sala: " + valorPromedio);
    let menudencia_pollo_porc = parseFloat($("#menudencia_pollo_porc").val());
    let mollejas_corazones_porc = parseFloat(
        $("#mollejas_corazones_porc").val()
    );
    console.log("menudencia_pollo_porc: " + menudencia_pollo_porc);
    console.log("mollejas_corazones_porc: " + mollejas_corazones_porc);
    let subtotalValue =
        valorPromedio + menudencia_pollo_porc + mollejas_corazones_porc;
    $("#subtotal").val(formatCantidad(subtotalValue));

    // despojos_mermas
    let porc_pollo = parseFloat($("#porc_pollo").val());
    let despojosMermas = porc_pollo - subtotalValue;
    $("#despojos_mermas").val(formatCantidad(despojosMermas));
}
