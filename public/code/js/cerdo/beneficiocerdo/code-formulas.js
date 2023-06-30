  //let cantidad = $('#cantidad');
  let plantasacrificiocerdo_id = $("#plantasacrificiocerdo_id");
  let cantidadMacho = $("#cantidadMacho");
  let cantidadHembra = $("#cantidadHembra");
  let valorMacho = $("#valorUnitarioMacho");
  let valorHembra = $("#valorUnitarioHembra");

  let canalfria = $("#canalfria");
  let costoanimal1 = $("#costoanimal1");
  let costoanimal2 = $("#costoanimal2");
  let costoanimal3 = $("#costoanimal3");
  let pesopie1 = $("#pesopie1");
  let pesopie2 = $("#pesopie2");
  let pesopie3 = $("#pesopie3");

  let pieleskg = $("#pieleskg");
  let pielescosto = $("#pielescosto");
  let visceras = $("#visceras");

  let canalcaliente = $("#canalcaliente");
  let canalplanta = $("#canalplanta");

    plantasacrificiocerdo_id.change(function () {
     let plantasacrificiocerdo_id = $('#plantasacrificiocerdo_id');
     $(obtener_registroid(plantasacrificiocerdo_id.val()));
  });

   //cantidad.change(function () { calculatotales(); });

  document.querySelector("#cantidadMacho").addEventListener("change", function() {
    calculatotales();
  });
   document.querySelector("#cantidadHembra").addEventListener("change", function() {
    let cantHembra = document.querySelector("#cantidadHembra").value;
    if (Number(cantHembra) === 0) {
      document.querySelector("#valorHembra").value = 0;
      document.querySelector("#valorTotalHembra").value = 0;
    }
    calculatotales();
  });

  document.querySelector("#costoanimal1").addEventListener("change", function() {
    let costo1 = formatMoneyNumber(document.querySelector("#costoanimal1").value);
    document.querySelector("#costoanimal1").value = formatCantidadSinCero(costo1);
    calculatotales();
  });
   document.querySelector("#costoanimal2").addEventListener("change", function() {
    let costo2 = formatMoneyNumber(document.querySelector("#costoanimal2").value);
    document.querySelector("#costoanimal2").value = formatCantidadSinCero(costo2);
    calculatotales();
  });
   document.querySelector("#costoanimal3").addEventListener("change", function() {
    let costo3 = formatMoneyNumber(document.querySelector("#costoanimal3").value);
    document.querySelector("#costoanimal3").value = formatCantidadSinCero(costo3);
    calculatotales();
  });
   document.querySelector("#canalfria").addEventListener("change", function() {
    let canalf = formatkg(document.querySelector("#canalfria").value);
    document.querySelector("#canalfria").value = canalf;
    console.log("peso: " + canalf);
    calculatotales();
  });
   document.querySelector("#pieleskg").addEventListener("change", function() {
    let piel = formatMoneyNumber(document.querySelector("#pieleskg").value);
    document.querySelector("#pieleskg").value = formatCantidadSinCero(piel);
    calculatotales();
  });
   document.querySelector("#pielescosto").addEventListener("change", function() {
    let pielc = formatMoneyNumber(document.querySelector("#pielescosto").value);
    document.querySelector("#pielescosto").value = formatCantidadSinCero(pielc);
    calculatotales();
  });
   document.querySelector("#visceras").addEventListener("change", function() {
    let visc = formatkg(document.querySelector("#visceras").value);
    document.querySelector("#visceras").value = visc;
    console.log("peso: " + visc);
    calculatotales();
  });
   document.querySelector("#pesopie1").addEventListener("change", function() {
    let pesokg1 = formatkg(document.querySelector("#pesopie1").value);
    document.querySelector("#pesopie1").value = pesokg1;
    console.log("peso: " + pesokg1);
    calculatotales();
  });
   document.querySelector("#pesopie2").addEventListener("change", function() {
    let pesokg2 = formatkg(document.querySelector("#pesopie2").value);
    document.querySelector("#pesopie2").value = pesokg2;
    console.log("peso: " + pesokg2);
    calculatotales();
  });
   document.querySelector("#pesopie3").addEventListener("change", function() {
    let pesokg3 = formatkg(document.querySelector("#pesopie3").value);
    document.querySelector("#pesopie3").value = pesokg3;
    console.log("peso: " + pesokg3);
    calculatotales();
  });
   document.querySelector("#canalcaliente").addEventListener("change", function() {
    let canal = formatkg(document.querySelector("#canalcaliente").value);
    document.querySelector("#canalcaliente").value = canal;
    console.log("peso: " + canal);
    calculatotales();
  });
   document.querySelector("#canalplanta").addEventListener("change", function() {
    let canalp = formatkg(document.querySelector("#canalplanta").value);
    document.querySelector("#canalplanta").value = canalp;
    console.log("peso: " + canalp);
    calculatotales();
  });

  
  /**********************************************************/
  valorMacho.change(function () { CalculateTotalMacho(); });
  cantidadMacho.change(function () { CalculateTotalMacho(); });
  valorHembra.change(function () { CalculateTotalHembra(); });
  cantidadHembra.change(function () { CalculateTotalHembra(); });
  /**********************************************************/
  
  function obtener_registroid(plantasacrificiocerdo_id) {
    // alert("id "+plantasacrificiocerdo_id);
    $.ajax({
      url: "/get_plantasacrificiocerdo_by_id",
      dataType: 'json',
      type: 'GET',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data: {
        plantasacrificiocerdo_id: plantasacrificiocerdo_id,
      },
      success: function (data) {
        console.log(data);
      //  alert("registro prueba");
        $("#sacrificio").val(formatCantidadSinCero(data.sacrificio));
        $("#fomento").val(formatCantidadSinCero(data.fomento));
        $("#deguello").val(formatCantidadSinCero(data.deguello));
        $("#bascula").val(formatCantidadSinCero(data.bascula));
        $("#transporte").val(formatCantidadSinCero(data.transporte));
        calculatotales();

      }
    });
  };

  function calculatotales() {
    let cantidadMacho = document.getElementById("cantidadMacho").value;
    let cantidadHemdra = document.getElementById("cantidadHembra").value;
    let totalCantidad = Number(cantidadMacho) + Number(cantidadHemdra);
    console.log(totalCantidad);
    console.log(totalCantidad);
    //var cantidad = $('#cantidad').val();
    var cantidad = totalCantidad;
    var pesopie1 = formatMoneyNumber($('#pesopie1').val());
    //console.log("peso 1 " + pesopie1);
    var pesopie2 = formatMoneyNumber($('#pesopie2').val());
    var pesopie3 = formatMoneyNumber($('#pesopie3').val());
    var pieleskg = formatMoneyNumber($('#pieleskg').val());
    var canalcaliente = formatMoneyNumber($('#canalcaliente').val());
    var canalplanta = formatMoneyNumber($('#canalplanta').val());

    //CANAL FRIA 
    var canalfria = formatMoneyNumber($('#canalfria').val()); 
    console.log("canal fria " + canalfria)
    $('#tcanalfria').val(formatCantidadSinCero(cantidad * canalfria)); 
    var tcanalf = cantidad * canalfria;
    console.log(cantidad)
    //COSTO ANIMAL 1 / 2 / 3
    var costopie1 = formatMoneyNumber($('#costoanimal1').val()); $('#costopie1').val(formatCantidadSinCero(pesopie1 * costopie1)); var tpie1 = Number(pesopie1 * costopie1);
    var costopie2 = formatMoneyNumber($('#costoanimal2').val()); $('#costopie2').val(formatCantidadSinCero(pesopie2 * costopie2)); var tpie2 = Number(pesopie2 * costopie2);
    var costopie3 = formatMoneyNumber($('#costoanimal3').val()); $('#costopie3').val(formatCantidadSinCero(pesopie3 * costopie3)); var tpie3 = Number(pesopie3 * costopie3);

    //SACRIFICIO / FOMENTO / DEGUELLO / BASCULA / TRANSPORTE
    var sacrificio = formatMoneyNumber($('#sacrificio').val()); $('#tsacrificio').val(formatCantidadSinCero(cantidad * sacrificio)); var tsacrif = Number(cantidad * sacrificio);
    var fomento = formatMoneyNumber($('#fomento').val()); $('#tfomento').val(formatCantidadSinCero(cantidad * fomento * -1)); var tfomen = Number(cantidad * fomento * -1);
    var deguello = formatMoneyNumber($('#deguello').val()); $('#tdeguello').val(formatCantidadSinCero(cantidad * deguello)); var tdgue = Number(cantidad * deguello);
    var bascula = formatMoneyNumber($('#bascula').val()); $('#tbascula').val(formatCantidadSinCero(cantidad * bascula * -1)); var tbascu = Number(cantidad * bascula * -1);
    var transporte = formatMoneyNumber($('#transporte').val()); $('#ttransporte').val(formatCantidadSinCero(cantidad * transporte)); var ttrans = Number(cantidad * transporte);

    //TOTAL PIELES Y VISCERAS
    var pielescosto = formatMoneyNumber($('#pielescosto').val()); $('#tpieles').val(formatCantidadSinCero(pieleskg * pielescosto * -1)); var tpielc = Number(pieleskg * pielescosto * -1);
    //var visceras = formatMoneyNumber($('#visceras').val()); $('#tvisceras').val(formatCantidadSinCero(cantidad * visceras * -1)); var tvisce = Number(cantidad * visceras * -1);
    var visceras = formatMoneyNumber($('#visceras').val()); $('#tvisceras').val(formatCantidadSinCero(visceras * -1)); var tvisce = Number(visceras * -1);

    //TOTALES 
    //var totalc = tpie1 + tpie2 + tpie3 + tsacrif + tfomen + tdgue + tbascu + ttrans + tpielc + tvisce;
    var totalc = tpie1 + tpie2 + tpie3;// + tsacrif + tfomen + tdgue + tbascu + ttrans;// - (tpielc + tvisce);
    console.log("total c " + totalc)
    var totalgastos = tsacrif + tfomen + tdgue + tbascu + ttrans;
    console.log("Total gastos: " + totalgastos)
    var totalingresos = (pieleskg * pielescosto) + visceras;
    console.log("Total ingresos: " + totalingresos)
    let totalCantidadCostos = (totalc + totalgastos) - totalingresos;
    $('#totalcostos').val(formatCantidadSinCero(totalCantidadCostos));
    //$('#totalcostos').val(formatCantidadSinCero(totalc));
    $('#valorfactura').val(formatCantidadSinCero(tpie1 + tpie2 + tpie3 + tfomen + tbascu));
    if (canalcaliente != "") {
      //$('#costokilo').val(formatCantidadSinCero(Math.round(totalc / canalplanta)));//valiating
      $('#costokilo').val(formatCantidadSinCero(Math.round(totalCantidadCostos / canalcaliente)));//valiating
      $('#costo').val(formatCantidadSinCero(Math.round(totalCantidadCostos / canalcaliente) * 12.5));//validating
    }else{
      $('#costokilo').val(0);
      $('#costo').val(0);
    }

    //RENDIMIENTO
    var pesopierend = pesopie1 * 1 + pesopie2 * 1 + pesopie3 * 1;
    console.log("peso pies : " + pesopierend);
    $('#pesopie').val(formatCantidadSinCero(pesopierend));

    $('#rtcanalcaliente').val(formatCantidadSinCero(canalcaliente, 2));
    $('#rtcanalplanta').val(formatCantidadSinCero(canalplanta));
    $('#rtcanalfria').val(formatCantidadSinCero(canalfria));
    
    if (canalcaliente != "" && pesopierend != 0) {
      //$('#rendcaliente').val(formatCantidadSinCero(((canalcaliente / pesopierend) * 100).toFixed(2)));
      $('#rendcaliente').val(formatCantidad(((canalcaliente / pesopierend) * 100).toFixed(2)));
    }else{
      $('#rendcaliente').val(0);
    }  
    if (canalplanta != "" && pesopierend != 0) {
      //$('#rendplanta').val(formatCantidadSinCero(((canalplanta / pesopierend) * 100).toFixed(2)));
      $('#rendplanta').val(formatCantidad(((canalplanta / pesopierend) * 100).toFixed(2)));
    }else{
      $('#rendplanta').val(0);
    }

    if (canalfria != "" && pesopierend != 0) {
      $('#rendfrio').val(formatCantidadSinCero(((canalfria / pesopierend) * 100).toFixed(2)));
    }else{
      $('#rendfrio').val(0);
    }

  }

  const CalculateTotalMacho = () => {    
    let cantidadMacho = Number(document.querySelector("#cantidadMacho").value);   
    let valorUnitarioMacho = formatMoneyNumber(document.querySelector("#valorUnitarioMacho").value);
    let valorTotal = document.querySelector("#valorTotalMacho");
    valorTotal.value = formatCantidadSinCero(cantidadMacho * valorUnitarioMacho);
    let valorUnitario = document.querySelector("#valorUnitarioMacho");
    valorUnitario.value = formatCantidadSinCero(valorUnitarioMacho);
    setCantidadVicerasCosto();
  }

  const CalculateTotalHembra = () => {
    let cantidadHembra = Number(document.querySelector("#cantidadHembra").value);
    let valorUnitarioHembra = formatMoneyNumber(document.querySelector("#valorUnitarioHembra").value);
    let valorTotal = document.querySelector("#valorTotalHembra");
    valorTotal.value = formatCantidadSinCero(cantidadHembra * valorUnitarioHembra);
    let valorUnitario = document.querySelector("#valorUnitarioHembra");
    valorUnitario.value = formatCantidadSinCero(valorUnitarioHembra);
    setCantidadVicerasCosto();
  }  

  const setCantidadVicerasCosto = () => {
    let cantTotalMacho = formatMoneyNumber(document.querySelector("#valorTotalMacho").value);
    console.log("cantTotalMacho : " + cantTotalMacho);
    let cantTotalHembra = formatMoneyNumber(document.querySelector("#valorTotalHembra").value);
    console.log(cantTotalHembra);
    let sum = cantTotalMacho + cantTotalHembra;
    console.log("sum : " + formatCantidadSinCero(sum));
    document.querySelector("#visceras").value = formatCantidadSinCero(sum);
    document.querySelector("#tvisceras").value = formatCantidadSinCero(sum * -1);
  }