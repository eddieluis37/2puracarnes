/* Accciona el boton Cargar Inventario */
tfootTable.addEventListener("click", (e) => {
    e.preventDefault();
    let element = e.target;
    console.log(element);
    if (element.id === "addShopping") {
        //added to inventory
        console.log("click");
        Swal.fire({
            title: "Confirmación",
            text: "¿Desea afectar el inventario?",
            icon: "warning",
            showCancelButton: true,
            confirmButtonColor: "#3085d6",
            cancelButtonColor: "#d33",
            confirmButtonText: "Aceptar",
            cancelButtonText: "Cancelar",
        }).then((result) => {
            if (result.isConfirmed) {
                loadingStart(element);
                const dataform = new FormData();
                dataform.append("transferId", Number(transferId.value));
                dataform.append("stockOrigen", Number(stockOrigen.value));
                dataform.append(
                    "centrocostoOrigen",
                    Number(centrocostoOrigen.value)
                );
                dataform.append(
                    "centrocostoDestino_id",
                    Number(centrocostoDestino.value)
                );
                sendData("/transferAddShoping", dataform, token).then(
                    (result) => {
                        console.log(result);
                        if (result.status == 1) {
                            loadingEnd(
                                element,
                                "success",
                                "Cargar al inventario"
                            );
                            element.disabled = true;
                            window.location.href = `/transfer`;
                        }
                        if (result.status == 0) {
                            loadingEnd(
                                element,
                                "success",
                                "Cargar al inventario"
                            );
                            errorMessage(result.message);
                        }
                    }
                );
            }
        });
    }
});