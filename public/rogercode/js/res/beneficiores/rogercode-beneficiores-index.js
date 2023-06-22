console.log("benedicore Starting");
// 1.Comienza con una función "document ready", que asegura que el código dentro de ella se ejecute solo después de que el documento haya terminado de cargarse. 
$(document).ready(function () { 
    $("#tableBeneficiores").DataTable({ //2. Se llama a la función DataTable en la tabla con el ID "tableBeneficiores". Esto inicializa el plugin DataTable en la tabla y establece varias opciones como paginación, longitud de página y ordenamiento. 
        paging: true, 
        pageLength: 5, 
        autoWidth: false, 
        processing: true, //3. Las opciones "processing" y "serverSide" se establecen en true. Esto significa que los datos se procesarán en el servidor, en lugar de en el lado del cliente.  
        serverSide: true, 
        ajax: { //4. La opción "ajax" se establece en un objeto con una propiedad "url" establecida en "/showbeneficiores". Esto significa que el DataTable recuperará datos de esta URL. 
            url: "/showbeneficiores", 
        }, 
        columns: [ //5. La opción "columns" se establece en una matriz de objetos, cada uno con una propiedad "data" y una propiedad "name". La propiedad "data" especifica qué propiedad del objeto de datos debe usarse para esa columna, y la propiedad "name" especifica el nombre de la columna. 
            { data: "id", name: "id" }, 
            { data: "namethird", name: "namethird" }, 
            { data: "date", name: "date" }, 
            { data: "factura", name: "factura" }, 
            { data: "lote", name: "lote" }, 
            { data: "action", name: "action" }, 
        ], 
        order: [[0, 'DESC']], //6. La opción "order" se establece en una matriz con un elemento, que es una matriz con dos elementos. El primer elemento especifica el índice de columna por el que ordenar (en este caso, la columna 0, que es la columna "id"), y el segundo elemento especifica la dirección de ordenamiento (en este caso, descendente). 
       
        // 7. La opción "language" se establece en un objeto con varias propiedades que especifican el texto a mostrar para varias partes de DataTable, como el mensaje de procesamiento, el menú de longitud y la caja de búsqueda.
        language: {
            processing: "Procesando...", 
            lengthMenu: "Mostrar _MENU_ registros", 
            zeroRecords: "No se encontraron resultados", 
            emptyTable: "Ningún dato disponible en esta tabla", 
            sInfo: "Mostrando del _START_ al _END_ de total _TOTAL_ registros", 
            infoEmpty: "Mostrando registros del 0 al 0 de un total de 0 registros", 
            infoFiltered: "(filtrado de un total de _MAX_ registros)", 
            search: "Buscar:", 
            paginate: { 
                first: "Primero", 
                last: "Último", 
                next: "Siguiente", 
                previous: "Anterior", 
            }, 
        }, 
    });
    //9. Se define el objeto select2Options con varias opciones, como la anchura, el tema y el elemento padre desplegable.
     var select2Options = { 
        width: "100%", 
        theme: "bootstrap-5", 
        allowClear: true, 
        dropdownParent: $("#modal-create-beneficiore"), 
    };
    //8. Luego, el código configura tres menús desplegables select2 utilizando los selectores $(".selectProvider"), $(".selectPieles") y $(".selectVisceras"). 
     $(".selectProvider").select2($.extend({}, select2Options, { 
        placeholder: "Busca un proveedor", 
    })); 
     $(".selectPieles").select2($.extend({}, select2Options, { 
        placeholder: "Buscar un Cliente Piel", 
    })); 
     $(".selectVisceras").select2($.extend({}, select2Options, { 
        placeholder: "Buscar un Cliente Viscera", 
    })); 
});
//10. Los elementos $(".selectProvider"), $(".selectPieles") y $(".selectVisceras") se inicializan como menús desplegables select2 utilizando el objeto select2Options, con opciones adicionales como el texto de marcador de posición.

/*****************************************************************************************/
const token = document
    .querySelector('meta[name="csrf-token"]')
    .getAttribute("content");
const formBeneficio = document.querySelector("#form-beneficiores-res");
const btnModalClose = document.querySelector("#btnModalClose");

const idBeneficio = document.querySelector("#idbeneficio");
const formBeneficiores = document.querySelector("#formBeneficiores");
const contentform = document.querySelector("#contentDisable");

inputvalortotalhembra = document.querySelector("#valorTotalHembra");
inputvalortotalmacho = document.querySelector("#valorTotalMacho");

inputvalorunitariohembra = document.querySelector("#valorUnitarioHembra");
inputvalorunitariomacho = document.querySelector("#valorUnitarioMacho");

inputcantidadhembra = document.querySelector("#cantidadHembra");
inputcantidadmacho = document.querySelector("#cantidadMacho");

//inputfecha_beneficio = document.querySelector("#fecha_beneficio");
inputfactura = document.querySelector("#factura");
inputclientpieles_id = document.querySelector("#clientpieles_id");
inputclientvisceras_id = document.querySelector("#clientvisceras_id");
inputfinca = document.querySelector("#finca");
//inputlote = document.querySelector("#lote");
inputsacrificio = document.querySelector("#sacrificio");
inputfomento = document.querySelector("#fomento");
inputdeguello = document.querySelector("#deguello");
inputbascula = document.querySelector("#bascula");
inputtransporte = document.querySelector("#transporte");
inputpesopie1 = document.querySelector("#pesopie1");
inputpesopie2 = document.querySelector("#pesopie2");
inputpesopie3 = document.querySelector("#pesopie3");
inputcostoanimal1 = document.querySelector("#costoanimal1");
inputcostoanimal2 = document.querySelector("#costoanimal2");
inputcostoanimal3 = document.querySelector("#costoanimal3");

inputcanalcaliente = document.querySelector("#canalcaliente");
inputcanalfria = document.querySelector("#canalfria");
inputcanalplanta = document.querySelector("#canalplanta");
inputpieleskg = document.querySelector("#pieleskg");
inputpielescosto = document.querySelector("#pielescosto");
inputvisceras = document.querySelector("#visceras");

inputcostopie1 = document.querySelector("#costopie1");
inputcostopie2 = document.querySelector("#costopie2");
inputcostopie3 = document.querySelector("#costopie3");

inputtsacrificio = document.querySelector("#tsacrificio");
inputtfomento = document.querySelector("#tfomento");
inputtdeguello = document.querySelector("#tdeguello");
inputtbascula = document.querySelector("#tbascula");
inputttransporte = document.querySelector("#ttransporte");
inputtpieles = document.querySelector("#tpieles");
inputtvisceras = document.querySelector("#tvisceras");
inputtcanalfria = document.querySelector("#tcanalfria");

inputvalorfactura = document.querySelector("#valorfactura");
inputcostokilo = document.querySelector("#costokilo");
inputcosto = document.querySelector("#costo");
inputtotalcostos = document.querySelector("#totalcostos");

inputpesopie = document.querySelector("#pesopie");
inputrtcanalcaliente = document.querySelector("#rtcanalcaliente");
inputrtcanalplanta = document.querySelector("#rtcanalplanta");
inputrtcanalfria = document.querySelector("#rtcanalfria");
inputrendcaliente = document.querySelector("#rendcaliente");
inputrendplanta = document.querySelector("#rendplanta");
inputrendfrio = document.querySelector("#rendfrio");

/*  La funcion "refresh_table" actualiza la tabla con ID "tableBeneficiores" utilizando el plugin jQuery DataTables.
 
 Explicación paso a paso:

1. La función se define utilizando la sintaxis de función de flecha y se asigna a una variable constante llamada "refresh_table". 
2. El selector jQuery "$ (" #tableBeneficiores ")" selecciona el elemento HTML con el ID "tableBeneficiores". 
3. Se llama al método "dataTable ()" en el elemento seleccionado para inicializar el plugin DataTables en la tabla. 
4. El objeto DataTables inicializado se almacena en una variable llamada "table". 
5. Se llama al método "fnDraw (false)" en el objeto "table" para volver a dibujar la tabla sin actualizar la página. El parámetro "false" indica que la tabla no debe volver a la primera página.
 */

const refresh_table = () => {
    let table = $("#tableBeneficiores").dataTable();
    table.fnDraw(false);
};

/* Se define la función asincrónica "edit" que toma un parámetro "id". Registra el parámetro "id" en la consola, luego hace una solicitud fetch al servidor para obtener los datos para editar un elemento específico con el "id" proporcionado. Una vez que se recibe la respuesta, analiza los datos como JSON y los registra en la consola. Si un elemento específico llamado "contentform" tiene el atributo "disabled", la función elimina el atributo y habilita otros tres elementos con IDs específicos. Finalmente, la función llama a otra función llamada "showForm" y pasa los datos recuperados como argumento. 

Explicación paso a paso: 
<1. El código define una función asincrónica llamada "edit" que toma un parámetro "id". 
2. La función registra el parámetro "id" en la consola. 
3. La función hace una solicitud fetch al servidor para obtener los datos para editar un elemento específico con el "id" proporcionado. La URL para la solicitud se construye utilizando una plantilla literal que incluye el parámetro "id". 
4. La función espera a que se reciba la respuesta utilizando la palabra clave "await". 
5. Una vez que se recibe la respuesta, la función analiza los datos como JSON utilizando el método "json ()" en el objeto de respuesta. 
6. Los datos analizados se almacenan en una variable llamada "data". 
7. La función registra la variable "data" en la consola. 
8. Si un elemento específico llamado "contentform" tiene el atributo "disabled", la función elimina el atributo utilizando el método "removeAttribute ()". 
9. La función habilita otros tres elementos con IDs específicos utilizando la sintaxis "$ ()" de jQuery y el método "prop ()". 
10. Finalmente, la función llama a otra función llamada "showForm" y pasa los datos recuperados como argumento.
 */

const edit = async (id) => {
    console.log(id);
    const response = await fetch(`/edit/${id}`);
    const data = await response.json();
    console.log(data);
    if(contentform.hasAttribute('disabled')){
    	contentform.removeAttribute('disabled');
    	$('#thirds_id').prop('disabled', false);
    	$('#clientpieles_id').prop('disabled', false);
    	$('#clientvisceras_id').prop('disabled', false);
    }
    showForm(data);
};

const showForm = (data) => {
    let resp = data.beneficiores;
    console.log(resp);
    idBeneficio.value = resp.id;
    $("#thirds_id").val(resp.thirds_id).trigger("change");
    $("#clientpieles_id").val(resp.clientpieles_id).trigger("change");
    $("#clientvisceras_id").val(resp.clientvisceras_id).trigger("change");
    $("#plantasacrificio_id").val(resp.plantasacrificio_id);
    inputcantidadhembra.value = resp.cantidadhembra;
    inputcantidadmacho.value = resp.cantidadmacho;
    inputvalortotalhembra.value = formatCantidadSinCero(resp.valortotalhembra);
    inputvalortotalmacho.value = formatCantidadSinCero(resp.valortotalmacho);
    inputvalorunitariohembra.value = formatCantidadSinCero(
        resp.valorunitariohembra
    );
    inputvalorunitariomacho.value = formatCantidadSinCero(
        resp.valorunitariomacho
    );

    //inputfecha_beneficio.value = resp.fecha_beneficio;
    inputfactura.value = resp.factura;
    inputclientpieles_id.value = resp.clientpieles_id;
    inputclientvisceras_id.value = resp.clientvisceras_id;
    inputfinca.value = resp.finca;
    //inputlote.value = resp.lote;
    inputsacrificio.value = formatCantidadSinCero(resp.sacrificio);
    inputfomento.value = formatCantidadSinCero(resp.fomento);
    inputdeguello.value = formatCantidadSinCero(resp.deguello);
    inputbascula.value = formatCantidadSinCero(resp.bascula);
    inputtransporte.value = formatCantidadSinCero(resp.transporte);
    inputpesopie1.value = formatCantidad(resp.pesopie1);
    inputpesopie2.value = formatCantidad(resp.pesopie2);
    inputpesopie3.value = formatCantidad(resp.pesopie3);
    inputcostoanimal1.value = formatCantidadSinCero(resp.costoanimal1);
    inputcostoanimal2.value = formatCantidadSinCero(resp.costoanimal2);
    inputcostoanimal3.value = formatCantidadSinCero(resp.costoanimal3);

    inputcanalcaliente.value = formatCantidad(resp.canalcaliente);
    inputcanalfria.value = formatCantidad(resp.canalfria);
    inputcanalplanta.value = formatCantidad(resp.canalplanta);
    inputpieleskg.value = formatCantidadSinCero(resp.pieleskg);
    inputpielescosto.value = formatCantidadSinCero(resp.pielescosto);
    inputvisceras.value = formatCantidadSinCero(resp.visceras);

    inputcostopie1.value = formatCantidadSinCero(resp.costopie1);
    inputcostopie2.value = formatCantidadSinCero(resp.costopie2);
    inputcostopie3.value = formatCantidadSinCero(resp.costopie3);

    inputtsacrificio.value = formatCantidadSinCero(resp.tsacrificio);
    inputtfomento.value = formatCantidadSinCero(resp.tfomento);
    inputtdeguello.value = formatCantidadSinCero(resp.tdeguello);
    inputtbascula.value = formatCantidadSinCero(resp.tbascula);
    inputttransporte.value = formatCantidadSinCero(resp.ttransporte);
    inputtpieles.value = formatCantidadSinCero(resp.tpieles);
    inputtvisceras.value = formatCantidadSinCero(resp.tvisceras);
    inputtcanalfria.value = formatCantidadSinCero(resp.tcanalfria);

    inputvalorfactura.value = formatCantidadSinCero(resp.valorfactura);
    inputcostokilo.value = formatCantidadSinCero(resp.costokilo);
    inputcosto.value = formatCantidadSinCero(resp.costo);
    inputtotalcostos.value = formatCantidadSinCero(resp.totalcostos);

    inputpesopie.value = formatCantidad(resp.pesopie);
    inputrtcanalcaliente.value = formatCantidad(resp.rtcanalcaliente);
    inputrtcanalplanta.value = formatCantidad(resp.rtcanalplanta);
    inputrtcanalfria.value = formatCantidad(resp.rtcanalfria);
    inputrendcaliente.value = formatCantidad(resp.rendcaliente);
    inputrendplanta.value = formatCantidad(resp.rendplanta);
    inputrendfrio.value = formatCantidad(resp.rendfrio);

    const modal = new bootstrap.Modal(
        document.getElementById("modal-create-beneficiore")
    );
    modal.show();
};

const showModalcreate = () => {
    console.log("showModal");
    if (contentform.hasAttribute("disabled")) {
        contentform.removeAttribute("disabled");
        $("#thirds_id").prop("disabled", false);
        $("#clientpieles_id").prop("disabled", false);
        $("#clientvisceras_id").prop("disabled", false);
    }
    const mySelectProvider = $("#thirds_id");
    mySelectProvider.val("").trigger("change");
    const mySelectPieles = $("#clientpieles_id");
    mySelectPieles.val("").trigger("change");
    const mySelectVisceras = $("#clientvisceras_id");
    mySelectVisceras.val("").trigger("change");
    formBeneficio.reset();
    idBeneficio.value = 0;
};

function Confirm(id) {
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
            const waitOneSecond = async () => {
                let response = await fetch(`/downbeneficiores/${id}`);
                let resp = await response.json();
                console.log(resp);
                return resp;
            };
            waitOneSecond().then((resp) => {
                console.log(resp); //
                if (resp.status === 201) {
                    swal({
                        title: "Exito",
                        text: resp.message,
                        type: "success",
                    });
		    refresh_table();
                }
            });
        }
    });
}

const showDataForm = async (id) => {
  const response = await fetch(`/edit/${id}`);
  const data = await response.json();
  console.log(data);
  showForm(data);
  $('#thirds_id').prop('disabled', true);
  $('#clientpieles_id').prop('disabled', true);
  $('#clientvisceras_id').prop('disabled', true);
  contentform.setAttribute('disabled','disabled');
}