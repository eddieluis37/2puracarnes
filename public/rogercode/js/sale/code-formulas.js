var valorA_Pagar = 0;
var valorPagado = 0;
var valorCambio = 0;

document.getElementById("valor_pagado").value = valorPagado;

valor_a_pagar_efectivo.addEventListener("change", function () {
    let valor1 = formatMoneyNumber($("#valor_a_pagar_efectivo").val());
    $("#valor_a_pagar_efectivo").val(formatCantidadSinCero(valor1));
    calculavalorapagar();
});

valor_a_pagar_tarjeta.addEventListener("change", function () {
    let valor2 = formatMoneyNumber($("#valor_a_pagar_tarjeta").val());
    $("#valor_a_pagar_tarjeta").val(formatCantidadSinCero(valor2));
    calculavalorapagar();
});

valor_a_pagar_otros.addEventListener("change", function () {
    let valor3 = formatMoneyNumber($("#valor_a_pagar_otros").val());
    $("#valor_a_pagar_otros").val(formatCantidadSinCero(valor3));
    calculavalorapagar();
});

valor_a_pagar_credito.addEventListener("change", function () {
    let valor4 = formatMoneyNumber($("#valor_a_pagar_credito").val());
    $("#valor_a_pagar_credito").val(formatCantidadSinCero(valor4));
    calculavalorapagar();
});

const calculavalorapagar = () => {
    let valor1 = formatMoneyNumber($("#valor_a_pagar_efectivo").val());
    let valor2 = formatMoneyNumber($("#valor_a_pagar_tarjeta").val());
    let valor3 = formatMoneyNumber($("#valor_a_pagar_otros").val());
    let valor4 = formatMoneyNumber($("#valor_a_pagar_credito").val());

    var valor_pagado = formatMoneyNumber($("#valor_pagado").val());
    $("#valor_pagado").val(
        formatCantidadSinCero(valor1 + valor2 + valor3 + valor4)
    );
    console.log(typeof valor_pagado);
    calcularCambio();
};

function calcularCambio() {
    var valorPagado = formatMoneyNumber(document.getElementById("valor_pagado").value);
    var valorAbonado = formatMoneyNumber(document.getElementById("valor_a_pagar").value);
    var valorCambio = valorPagado - valorAbonado;
    document.getElementById("cambio").value = formatCantidadSinCero(valorCambio);
    console.log(valorCambio);
}
