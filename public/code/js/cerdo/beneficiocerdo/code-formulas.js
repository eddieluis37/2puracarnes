
  var plantasacrificio_id = $('#plantasacrificio_id');
  //var cantidad = $('#cantidad');
  let cantidadMacho = $("#cantidadMacho");
  let cantidadHembra = $("#cantidadHembra");
  let valorMacho = $("#valorUnitarioMacho");
  let valorHembra = $("#valorUnitarioHembra");

  var canalfria = $('#canalfria');
  var costoanimal1 = $('#costoanimal1');
  var costoanimal2 = $('#costoanimal2');
  var costoanimal3 = $('#costoanimal3');
  var pesopie1 = $('#pesopie1');
  var pesopie2 = $('#pesopie2');
  var pesopie3 = $('#pesopie3');

  var pieleskg = $('#pieleskg');
  var pielescosto = $('#pielescosto');
  var visceras = $('#visceras');

  var canalcaliente = $('#canalcaliente');
  var canalplanta = $('#canalplanta');

  plantasacrificio_id.change(function () {
    var plantasacrificio_id = $('#plantasacrificio_id');
    $(obtener_registroid(plantasacrificio_id.val()));
  });

  //cantidad.change(function () { calculatotales(); });
  cantidadMacho.change(function () { calculatotales(); });
  cantidadHembra.change(function () {
    let cantHembra = cantidadHembra.val();
    if (Number(cantHembra) === 0) {
      valorHembra.val(0);
      $('#valorTotalHembra').val(0);
    }
    calculatotales(); 
  });

  costoanimal1.change(function () {
    let costo1 = formatMoneyNumber($('#costoanimal1').val());
    $('#costoanimal1').val(formatCantidadSinCero(costo1));
    calculatotales(); 
  });
  costoanimal2.change(function () {
    let costo2 = formatMoneyNumber($('#costoanimal2').val());
    $('#costoanimal2').val(formatCantidadSinCero(costo2));
    calculatotales(); 
  });
  costoanimal3.change(function () { 
    let costo3 = formatMoneyNumber($('#costoanimal3').val());
    $('#costoanimal3').val(formatCantidadSinCero(costo3));
    calculatotales(); 
  });

  canalfria.change(function () {
    let canalf = formatkg($('#canalfria').val());
    $('#canalfria').val(canalf);
    console.log("peso :" + canalf)
    calculatotales(); 
  });

  pieleskg.change(function () { 
    let piel = formatMoneyNumber($('#pieleskg').val());
    $('#pieleskg').val(formatCantidadSinCero(piel));
    calculatotales(); 
  });
  pielescosto.change(function () { 
    let pielc = formatMoneyNumber($('#pielescosto').val());
    $('#pielescosto').val(formatCantidadSinCero(pielc));
    calculatotales(); 
  });
  visceras.change(function () { 
    let visc = formatkg($('#visceras').val());
    $('#visceras').val(visc);
    console.log("peso :" + visc)
    calculatotales(); 
  });

  pesopie1.change(function () {
    let pesokg1 = formatkg($('#pesopie1').val());
    $('#pesopie1').val(pesokg1);
    console.log("peso :" + pesokg1)
    calculatotales(); 
  });
  pesopie2.change(function () { 
    let pesokg2 = formatkg($('#pesopie2').val());
    $('#pesopie2').val(pesokg2);
    console.log("peso :" + pesokg2)
    calculatotales(); 
  });
  pesopie3.change(function () { 
    let pesokg3 = formatkg($('#pesopie3').val());
    $('#pesopie3').val(pesokg3);
    console.log("peso :" + pesokg3)
    calculatotales(); 
  });

  canalcaliente.change(function () { 
    let canal = formatkg($('#canalcaliente').val());
    $('#canalcaliente').val(canal);
    console.log("peso :" + canal)
    calculatotales(); 
  });

  canalplanta.change(function () { 
    let canalp = formatkg($('#canalplanta').val());
    $('#canalplanta').val(canalp);
    console.log("peso :" + canalp)
    calculatotales(); 
  });

  /**********************************************************/
  valorMacho.change(function () { CalculateTotalMacho(); });
  cantidadMacho.change(function () { CalculateTotalMacho(); });
  valorHembra.change(function () { CalculateTotalHembra(); });
  cantidadHembra.change(function () { CalculateTotalHembra(); });
  /**********************************************************/

  function obtener_registroid(plantasacrificio_id) {
    // alert("id "+plantasacrificio_id);
    $.ajax({
      url: "/get_plantasacrificio_by_id",
      dataType: 'json',
      type: 'GET',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data: {
        plantasacrificio_id: plantasacrificio_id,
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
    let cantidadMacho = $("#cantidadMacho").val();
    let cantidadHemdra = $("#cantidadHembra").val();
    let totalCantidad = Number(cantidadMacho) + Number(cantidadHemdra);
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
    console.log("Total gastos" + totalgastos)
    var totalingresos = (pieleskg * pielescosto) + visceras;
    console.log("Total ingresos" + totalingresos)
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
    let cantidadMacho = Number($("#cantidadMacho").val());
    let valorUnitarioMacho = formatMoneyNumber($("#valorUnitarioMacho").val());
    let valorTotal = $("#valorTotalMacho").val(formatCantidadSinCero(cantidadMacho * valorUnitarioMacho));
    $("#valorUnitarioMacho").val(formatCantidadSinCero(valorUnitarioMacho));
    setCantidadVicerasCosto();
  }
  const CalculateTotalHembra = () => {
    let cantidadHembra = Number($("#cantidadHembra").val());
    let valorUnitarioHembra = formatMoneyNumber($("#valorUnitarioHembra").val());
    let valorTotal = $("#valorTotalHembra").val(formatCantidadSinCero(cantidadHembra * valorUnitarioHembra));
    $("#valorUnitarioHembra").val(formatCantidadSinCero(valorUnitarioHembra));
    setCantidadVicerasCosto();
  }

  const setCantidadVicerasCosto = () => {
    let cantTotalMacho = formatMoneyNumber($("#valorTotalMacho").val());
    console.log(cantTotalMacho)
    let cantTotalHembra = formatMoneyNumber($("#valorTotalHembra").val());
    console.log(cantTotalHembra)
    let sum = cantTotalMacho + cantTotalHembra;
    console.log("sum : " + formatCantidadSinCero(sum));
    $("#visceras").val(formatCantidadSinCero(sum));
    $("#tvisceras").val(formatCantidadSinCero(sum * -1));
  }