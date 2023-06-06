import {sendData} from '../exportModule/core/rogercode-core.js';
import { successToastMessage, errorMessage } from '../exportModule/message/rogercode-message.js';
btnAddAlistamiento.addEventListener("click", async (e) => {
    e.preventDefault();
    console.log("log")
    const dataform = new FormData(formAlistamiento);
    sendData('/alistamientosave',dataform,token).then((resp) => {
        console.log(resp);
        if (resp.status == 1) {
            formAlistamiento.reset();   
            btnClose.click();
            successToastMessage(resp.message); 
            refresh_table();
            /*if (resp.registroId != 0) {//for new register
                window.location.href = `compensado/create/${resp.registroId}`;
            }else{
                refresh_table();
            }*/
        }
        /*if (resp.status == 0) {
            let errors = resp.errors;
            console.log(errors);
            $.each(errors, function(field, messages) {
                console.log(field, messages)
                let $input = $('[name="' + field + '"]');
                let $errorContainer = $input.closest('.form-group').find('.error-message');
                $errorContainer.html(messages[0]);
                $errorContainer.show();
            });        
        }*/
    });
})