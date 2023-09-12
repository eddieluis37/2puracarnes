
  var plantasacrificio_id = $('#plantasacrificio_id');
  var cantidad = $('#cantidad');
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

  cantidad.change(function () { calculatotales(); });
  costoanimal1.change(function () { calculatotales(); });
  costoanimal2.change(function () { calculatotales(); });
  costoanimal3.change(function () { calculatotales(); });
  canalfria.change(function () { calculatotales(); });

  pieleskg.change(function () { calculatotales(); });
  pielescosto.change(function () { calculatotales(); });
  visceras.change(function () { calculatotales(); });

  pesopie1.change(function () { calculatotales(); });
  pesopie2.change(function () { calculatotales(); });
  pesopie3.change(function () { calculatotales(); });

  canalcaliente.change(function () { calculatotales(); });
  canalplanta.change(function () { calculatotales(); });

  function obtener_registroid(plantasacrificio_id) {
    // alert("id "+plantasacrificio_id);
    $.ajax({
      url: "/get_plantasacrificiopollo_by_id",
      dataType: 'json',
      type: 'GET',
      headers: {
        'X-CSRF-TOKEN': '{{ csrf_token() }}'
      },
      data: {
        plantasacrificio_id: plantasacrificio_id,
      },
      success: function (data1) {
        console.log(data1);
        $("#sacrificio").val(data1.sacrificio);
        $("#fomento").val(data1.fomento);
        $("#deguello").val(data1.deguello);
        $("#bascula").val(data1.bascula);
        $("#transporte").val(data1.transporte);
        calculatotales();
      }
    });
  };
  function calculatotales() {

    var cantidad = $('#cantidad').val();
    var pesopie1 = formatMoneyNumber($('#pesopie1').val());
    var pesopie2 = $('#pesopie2').val();
    var pesopie3 = $('#pesopie3').val();
    var pieleskg = $('#pieleskg').val();
    var canalcaliente = $('#canalcaliente').val();
    var canalplanta = $('#canalplanta').val();

    //CANAL FRIA 
    var canalfria = $('#canalfria').val(); $('#tcanalfria').val(cantidad * canalfria); var tcanalf = cantidad * canalfria;
    //COSTO ANIMAL 1 / 2 / 3
    var costopie1 = $('#costoanimal1').val(); $('#costopie1').val(pesopie1 * costopie1); var tpie1 = pesopie1 * costopie1;
    var costopie2 = $('#costoanimal2').val(); $('#costopie2').val(pesopie2 * costopie2); var tpie2 = pesopie2 * costopie2;
    var costopie3 = $('#costoanimal3').val(); $('#costopie3').val(pesopie3 * costopie3); var tpie3 = pesopie3 * costopie3;

    //SACRIFICIO / FOMENTO / DEGUELLO / BASCULA / TRANSPORTE
    var sacrificio = $('#sacrificio').val(); $('#tsacrificio').val(cantidad * sacrificio); var tsacrif = cantidad * sacrificio;
    //var fomento = $('#fomento').val(); $('#tfomento').val(cantidad * fomento * -1); var tfomen = cantidad * fomento * -1;
    //var deguello = $('#deguello').val(); $('#tdeguello').val(cantidad * deguello); var tdgue = cantidad * deguello;
    //var bascula = $('#bascula').val(); $('#tbascula').val(cantidad * bascula * -1); var tbascu = cantidad * bascula * -1;
    //var transporte = $('#transporte').val(); $('#ttransporte').val(cantidad * transporte); var ttrans = cantidad * transporte;

    //TOTAL PIELES Y VISCERAS
    var pielescosto = $('#pielescosto').val(); $('#tpieles').val(pieleskg * pielescosto * -1); var tpielc = pieleskg * pielescosto * -1;
    var menudencias = $('#menudencias').val(); $('#tmenudencias').val(cantidad * menudencias * -1); var tvisce = cantidad * visceras * -1;
    var visceras = $('#visceras').val(); $('#tvisceras').val(cantidad * visceras * -1); var tvisce = cantidad * visceras * -1;

    //TOTALES 
    var totalc = tpie1 + tpie2 + tpie3 + tsacrif + tpielc + tvisce;
    console.log(totalc);
    $('#totalcostos').val(totalc);
    $('#valorfactura').val(tpie1 + tpie2 + tpie3);
    $('#costokilo').val(Math.round(totalc / canalfria));
    $('#costo').val(Math.round(totalc / canalfria) * 12.5);
    //$('#costokilo').val(Math.round(totalc / canalplanta));
    //$('#costo').val(Math.round(totalc / canalplanta) * 12.5);

    //RENDIMIENTO
    var pesopierend = pesopie1 * 1 + pesopie2 * 1 + pesopie3 * 1;
    $('#pesopie').val(pesopierend);

    $('#rtcanalcaliente').val(canalcaliente, 2);
    $('#rtcanalplanta').val(canalplanta);
    $('#rtcanalfria').val(canalfria);

    $('#rendcaliente').val(((canalcaliente / pesopierend) * 100).toFixed(2));
    $('#rendplanta').val(((canalplanta / pesopierend) * 100).toFixed(2));
    $('#rendfrio').val(((pesopierend * canalfria) / 100).toFixed(2));

  }