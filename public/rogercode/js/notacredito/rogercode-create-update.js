import { sendData } from "../exportModule/core/rogercode-core.js";
import {
    successToastMessage,
    errorMessage,
} from "../exportModule/message/rogercode-message.js";
btnAddVentaDomicilio.addEventListener("click", async (e) => {
    e.preventDefault();
    const dataform = new FormData(formCompensadoRes);
    sendData("/notacreditosave", dataform, token).then((resp) => {
        console.log(resp);
        if (resp.status == 1) {
            formCompensadoRes.reset();
            btnClose.click();
            successToastMessage(resp.message);
            if (resp.registroId != 0) {
                //for new register
                window.location.href = `notacredito/create/${resp.registroId}`;
            } else {
                refresh_table();
            }
        }
        if (resp.status == 0) {
            let errors = resp.errors;
            console.log(errors);
            $.each(errors, function (field, messages) {
                console.log(field, messages);
                let $input = $('[name="' + field + '"]');
                let $errorContainer = $input
                    .closest(".form-group")
                    .find(".error-message");
                $errorContainer.html(messages[0]);
                $errorContainer.show();
            });
        }
    });
});

$(document).ready(function() {
    $('#cliente').on('change', function() {
        var cliente_id = $(this).val();
        if (cliente_id) {
            $.ajax({
                url: '/getFacturasByCliente/' + cliente_id,
                type: "GET",
                dataType: "json",
                success:function(data) {
                    $('#factura').empty();
                    $.each(data, function(key, value) {
                        $('#factura').append('<option value="'+ value.id +'">'+ value.resolucion +'</option>');
                    });
                }
            });
        } else {
            $('#factura').empty();
        }
    });
});

// Limpiar mensajes de error al cerrar la ventana modal
$('#modal-create-notacredito').on('hidden.bs.modal', function () {
    $('.error-message').text('');
});

// Limpiar mensajes de error al cambiar el valor del campo factura
$('#factura').on('change', function() {
    $('.error-message').text('');
});

/* // Limpiar mensajes de error al limpiar el campo
$('#fecha_venta, #centrocosto, #cliente, #factura, #vendedor, #subcentrodecosto').on('blur', function () {
    $(this).next('.error-message').text('');
}); */
/* 
// Limpiar mensajes de error al limpiar el campo
$('#fecha_venta, #centrocosto, #cliente, #factura, #vendedor, #subcentrodecosto').on('focusout', function () {
    $(this).next('.error-message').text('');
});
 */
/* // Limpiar mensajes de error al limpiar el campo
$('#fecha_venta, #centrocosto, #cliente, #factura').on('change', function () {
    $(this).next('.error-message').text('');
}); */

/* 
// Limpiar mensajes de error al limpiar el campo
$('#fecha_venta, #centrocosto, #cliente, #factura, #vendedor, #subcentrodecosto').on('input', function () {
    $(this).next('.error-message').text('');
}); */


/* // Limpiar mensajes de error al limpiar el campo
$('#fecha_venta, #centrocosto, #cliente, #factura, #vendedor, #subcentrodecosto').on('keyup', function () {
    $(this).next('.error-message').text('');
}); */