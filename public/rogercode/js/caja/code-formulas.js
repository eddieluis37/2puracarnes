var valorBase = formatMoneyNumber($("#base").val());
var valorEfectivo = formatMoneyNumber($("#efectivo").val());
var valorTotal = valorBase + valorEfectivo;
var valorIngresado = formatMoneyNumber($("#valor_real").val());
var valorDiferencia = valorIngresado - valorTotal;

document.getElementById("base").value = valorBase;
document.getElementById("efectivo").value = valorEfectivo;
document.getElementById("total").value = valorTotal;
document.getElementById("valor_real").value = valorIngresado;
document.getElementById("diferencia").value = valorDiferencia;

$("#valor_real").on("input", function () {
    valorIngresado = formatMoneyNumber($("#valor_real").val());
    valorDiferencia = valorIngresado - valorTotal;

    document.getElementById("base").value = valorBase;
    document.getElementById("efectivo").value = valorEfectivo;
    document.getElementById("total").value = valorTotal;
    document.getElementById("valor_real").value = valorIngresado;
    document.getElementById("diferencia").value = valorDiferencia;

    if (valorDiferencia >= -20000) {
        $("#btnGuardar").prop("disabled", false);
    } else {
        $("#btnGuardar").prop("disabled", true);
    }
    console.log(valorDiferencia);
});
