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
var menudencia_pollo_kg = $("#menudencia_pollo_kg");
var menudencia_pollo_porc = $("#menudencia_pollo_porc");
var mollejas_corazones_porc = $("#mollejas_corazones_porc");
var mollejas_corazones_kg = $("#mollejas_corazones_kg");
var porc_pollo = $("#porc_pollo");
var despojos_mermas = $("#despojos_mermas");

plantasacrificio_id.change(function () {
    var plantasacrificio_id = $("#plantasacrificio_id");
    $(obtener_registroid(plantasacrificio_id.val()));
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

cantidad.change(function () {
    calculatotales();
});

peso_canales_pollo_planta.change(function () {
    calculatotales();
});

menudencia_pollo_porc.change(function () {
    calculatotales();
});

porc_pollo.change(function () {
    calculatotales();
});

menudencia_pollo_kg.change(function () {
    calculatotales();
});

mollejas_corazones_kg.change(function () {
    calculatotales();
});


valor_kg_pollo.change(function () {
    let canal = formatkg($("#valor_kg_pollo").val());
    $("#valor_kg_pollo").val(canal);
    console.log("peso :" + canal);
    calculatotales();
});

promedio_pie_kg.change(function () {
    let valorPromedioPieKg = formatkg($("#promedio_pie_kg").val());
    $("#promedio_pie_kg").val(valorPromedioPieKg);
    console.log("valorPromedioPieKg :" + valorPromedioPieKg);
    calculatotales();
});

function calculatotales() {
    let cantidad = $("#cantidad").val();
    let sacrificio = $("#sacrificio").val();

    // Calcula peso_pie_planta
    let promedio_pie_kg = formatMoneyNumber($("#promedio_pie_kg").val());
    let peso_pie_planta = cantidad * promedio_pie_kg;
    console.log("promedio_pie_kg: " + promedio_pie_kg);
    $("#peso_pie_planta").val(formatCantidad(peso_pie_planta));
    console.log("peso_pie_planta :" + peso_pie_planta);
    /*     
    let peso_pie_planta = $("#peso_pie_planta").val(); */

    let peso_canales_pollo_planta = formatMoneyNumber($("#peso_canales_pollo_planta").val());

    //Total factura
    var valor_kg_pollo = formatMoneyNumber($("#valor_kg_pollo").val());
    sacrificio = sacrificio.replace(/[,.]/g, ""); // Elimina puntos y comas
    console.log("valor_kg_pollo: " + valor_kg_pollo);
    console.log("sacrificio: " + sacrificio);
    console.log("peso_pie_planta: " + peso_pie_planta);
    console.log("peso_canales_pollo_planta: " + peso_canales_pollo_planta);
    let total = cantidad * sacrificio + peso_pie_planta * valor_kg_pollo;
    $("#total_factura").val(formatCantidadSinCero(total));

    // promedio_canal_fria_KG
    let valorPromedioCanalKg = peso_canales_pollo_planta / cantidad;
    $("#promedio_canal_kg").val(formatCantidad(valorPromedioCanalKg));

    // promedio_canal_fria_sala (promedio_canal_kg) / (promedio_pie_kg * 100);
    console.log("promedio_canal_kg: " + valorPromedioCanalKg);
    console.log("promedio_pie_kg: " + promedio_pie_kg);
    let valorPromedioCanalFriaSala = (valorPromedioCanalKg / promedio_pie_kg) * 100;
    $("#promedio_canal_fria_sala").val(formatCantidad(valorPromedioCanalFriaSala));

    // menudencia_pollo_porc
    console.log("promedio_canal_fria_sala: " + valorPromedioCanalFriaSala);
    let menudencia_pollo_kg = formatMoneyNumber($("#menudencia_pollo_kg").val());    
    console.log("peso_pie_planta: " + peso_pie_planta);
    console.log("menudencia_pollo_kg: " + menudencia_pollo_kg);
  
    let valueMenudenciaPolloPorc =  (menudencia_pollo_kg / peso_pie_planta) * 100;
    $("#menudencia_pollo_porc").val(formatCantidad(valueMenudenciaPolloPorc));

    //mollejas_corazones_porc
    var mollejas_corazones_kg = formatMoneyNumber($("#mollejas_corazones_kg").val());
    let valueMollejasCorazonesPorc =  (mollejas_corazones_kg / peso_pie_planta) * 100;
    $("#mollejas_corazones_porc").val(formatCantidad(valueMollejasCorazonesPorc));

    // subtotal
    console.log("promedio_canal_fria_sala: " + valorPromedioCanalFriaSala);
    let menudencia_pollo_porc = formatMoneyNumber($("#menudencia_pollo_porc").val());    
    let mollejas_corazones_porc = formatMoneyNumber($("#mollejas_corazones_porc").val());
    console.log("menudencia_pollo_porc: " + menudencia_pollo_porc);
    console.log("mollejas_corazones_porc: " + mollejas_corazones_porc);
    let subtotalValue =
    valorPromedioCanalFriaSala + menudencia_pollo_porc + mollejas_corazones_porc;
    $("#subtotal").val(formatCantidad(subtotalValue));

    // despojos_mermas
    let porc_pollo = formatMoneyNumber($("#porc_pollo").val());
    let despojosMermas = porc_pollo - subtotalValue;
    $("#despojos_mermas").val(formatCantidad(despojosMermas));
}


   /*     se utilizan  parseFloat  para convertir los valores de los campos  menudencia_pollo_porc  y  mollejas_corazones_porc 
    a números decimales antes de sumarlos a  valorPromedio . Luego, se asigna el resultado de la suma al campo  subtotal
    después de formatearlo con la función  formatCantidad . */