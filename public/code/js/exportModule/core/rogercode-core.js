export const saveForm = async (url,form,token) => {
    try {
        const dataform = new FormData(form);
        let response = await fetch(url, {
        headers: {
            'X-CSRF-TOKEN': token
        },
        method: 'POST',
        body: dataform
        });
        let data = await response.json();
        return data;
    } catch (error) {
        console.log(error);
    }
        
}


export const sendData = async (url,form,token) => {
    try {
        let response = await fetch(url, {
        headers: {
            'X-CSRF-TOKEN': token
        },
        method: 'POST',
        body: form
        });
        let data = await response.json();
        return data;
    } catch (error) {
        console.log(error);
    }
        
}


export const loadingStart = (btn) => {
    btn.disabled = true;
    btn.innerHTML = '';
    btn.innerHTML += `
        <div class="spinner-border spinner-border-sm" role="status">
        <span class="visually-hidden">...</span>
        </div>
    ` 
}

export const loadingEnd = (btn,icon,text) => {
    btn.innerHTML = '';
    btn.innerHTML += `
        <i class="${icon}"></i> ${text}</i>
    `
    btn.disabled = false;
}