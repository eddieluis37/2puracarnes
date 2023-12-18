var valorBase = formatMoneyNumber($("#base").val());
var valorEfectivo = formatMoneyNumber($("#valor_efectivo").val());
var valorTotal = valorBase + valorEfectivo;
var valorIngresado = formatMoneyNumber($("#valor_real").val());
var valorDiferencia = valorTotal - valorIngresado;

document.getElementById("base").value = valorBase;
document.getElementById("valor_efectivo").value = valorEfectivo;
document.getElementById("total").value = valorTotal;
document.getElementById("valor_real").value = valorIngresado;
document.getElementById("diferencia").value = valorDiferencia;

$("#valor_real").on("input", function() {
  valorIngresado = formatMoneyNumber($("#valor_real").val());
  valorDiferencia = valorTotal - valorIngresado;

  document.getElementById("base").value = valorBase;
  document.getElementById("valor_efectivo").value = valorEfectivo;
  document.getElementById("total").value = valorTotal;
  document.getElementById("valor_real").value = valorIngresado;
  document.getElementById("diferencia").value = valorDiferencia;
});