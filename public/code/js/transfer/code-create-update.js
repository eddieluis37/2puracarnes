import {sendData} from '../../../rogercode/js/exportModule/core/rogercode-core.js';
import { successToastMessage, errorMessage } from '../../../rogercode/js/exportModule/message/rogercode-message.js';
btnAddTransfer.addEventListener("click", async (e) => {
    e.preventDefault();
    console.log("log")
    const dataform = new FormData(formTransfer);
    sendData('/transfersave',dataform,token).then((resp) => {
        console.log(resp);
        if (resp.status == 1) {
            formTransfer.reset();   
            btnClose.click();
            successToastMessage(resp.message); 
            refresh_table();
            if (resp.registroId != 0) {//for new register
                window.location.href = `transfer/create/${resp.registroId}`;
            }else{
                //refresh_table();
            }
        }
        if (resp.status == 0) {
            let errors = resp.errors;
            console.log(errors);
            $.each(errors, function(field, messages) {
                console.log(field, messages)
                let $input = $('[name="' + field + '"]');
                let $errorContainer = $input.closest('.form-group').find('.error-message');
                $errorContainer.html(messages[0]);
                $errorContainer.show();
            });        
        }
    });
})