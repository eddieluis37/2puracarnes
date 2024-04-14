
import {sendData} from '../../exportModule/core/rogercode-core.js';
import {successToastMessage, errorMessage} from '../../exportModule/message/rogercode-message.js';
formBeneficio.addEventListener('submit', (e) => {
    const dataform = new FormData(formBeneficio);
	e.preventDefault();
    sendData("/savebeneficioaves",dataform,token).then((result) => {
        console.log(result);
        if (result.status === 1) {
            //const mySelectProvider = $("#thirds_id");
            //mySelectProvider.val("").trigger("change");
            //const mySelectPieles = $("#clientpieles_id");
            //mySelectPieles.val("").trigger("change");
            //const mySelectVisceras = $("#clientvisceras_id");
            //mySelectVisceras.val("").trigger("change");
            //formBeneficio.reset();
            if (result.registroId != 0) {
                window.location.href = `desposteaves/${result.registroId}`;
            }else{
                btnModalClose.click();
                refresh_table();     
                successToastMessage(result.message); 
            }
        }
        if (result.status === 0) {
            errorMessage("Ocurrio un error inesperado");
        }
    });
});