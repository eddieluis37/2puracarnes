var valorBase = formatMoneyNumber($("#base").val());
var valorEfectivo = formatMoneyNumber($("#efectivo").val());
var valorTotal = valorBase + valorEfectivo;
var valorIngresado = formatMoneyNumber($("#valor_real").val());
var valorDiferencia = valorIngresado - valorTotal;

document.getElementById("base").value = formatCantidadSinCero(valorBase);
document.getElementById("efectivo").value = formatCantidadSinCero(valorEfectivo);
document.getElementById("total").value = formatCantidadSinCero(valorTotal);
document.getElementById("valor_real").value = formatCantidadSinCero(valorIngresado);
document.getElementById("diferencia").value = formatCantidadSinCero(valorDiferencia);

$("#valor_real").on("input", function () {
    valorIngresado = formatMoneyNumber($("#valor_real").val());
    valorDiferencia = valorIngresado - valorTotal;

    document.getElementById("base").value = formatCantidadSinCero(valorBase);
    document.getElementById("efectivo").value = formatCantidadSinCero(valorEfectivo);
    document.getElementById("total").value = formatCantidadSinCero(valorTotal);
    document.getElementById("valor_real").value = formatCantidadSinCero(valorIngresado);
    document.getElementById("diferencia").value = formatCantidadSinCero(valorDiferencia);

  /*   if (valorDiferencia >= -10000) {
        $("#btnGuardar").prop("disabled", false);
    } else {
        $("#btnGuardar").prop("disabled", true);
    }
    console.log(valorDiferencia); */

    if (valorIngresado >= 1) {
        $("#btnGuardar").prop("disabled", false);
    } else {
        $("#btnGuardar").prop("disabled", true);
    }
    console.log(valorIngresado);
});
