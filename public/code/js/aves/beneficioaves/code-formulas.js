var plantasacrificio_id = $("#plantasacrificio_id");
var cantidad = $("#cantidad");
var canalfria = $("#canalfria");

var total_factura = $("#total_factura");
var valor_kg_pollo = $("#valor_kg_pollo");

var costoanimal1 = $("#costoanimal1");

var costoanimal2 = $("#costoanimal2");
var costoanimal3 = $("#costoanimal3");
var pesopie1 = $("#pesopie1");
var pesopie2 = $("#pesopie2");
var pesopie3 = $("#pesopie3");

var pieleskg = $("#pieleskg");
var pielescosto = $("#pielescosto");
var visceras = $("#visceras");

var canalcaliente = $("#canalcaliente");
var canalplanta = $("#canalplanta");

plantasacrificio_id.change(function () {
    var plantasacrificio_id = $("#plantasacrificio_id");
    $(obtener_registroid(plantasacrificio_id.val()));
});

cantidad.change(function () {
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
    let costo1 = formatMoneyNumber($("#valor_kg_pollo").val());
    $("#valor_kg_pollo").val(formatCantidad(costo1));
    calculatotales();
});

peso_pie_planta.change(function () {
  let costo2 = formatMoneyNumber($("#peso_pie_planta").val());
  $("#peso_pie_planta").val(formatCantidadSinCero(costo2));
  calculatotales();
});

function calculatotales() {
    let cantidad = $("#cantidad").val();  
    let sacrificio = $("#sacrificio").val();  
    let peso_pie_planta = $("#peso_pie_planta").val();  

    //Total factura
    var valor_kg_pollo = formatMoneyNumber($("#valor_kg_pollo").val());
  
    sacrificio = sacrificio.replace(/[,.]/g, ""); // Elimina puntos y comas
    console.log("valor_kg_pollo: " + valor_kg_pollo);
    console.log("sacrificio: " + sacrificio);
    console.log("peso_pie_planta: " + peso_pie_planta);
    let total = ((cantidad * sacrificio) + (peso_pie_planta * valor_kg_pollo));
    $("#total_factura").val(formatCantidadSinCero(total));
}
