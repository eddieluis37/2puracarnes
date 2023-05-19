console.log("Starting")
const btnAddCompensadoRes = document.querySelector("#btnAddCompensadoRes");
const formCompensadoRes = document.querySelector("#form-compensado-res");
const token = document.querySelector('meta[name="csrf-token"]').getAttribute('content');

btnAddCompensadoRes.addEventListener("click", async (e) => {
    e.preventDefault();
    const dataform = new FormData(formCompensadoRes);
    let response = await fetch('/compensadosave', {
    headers: {
        'X-CSRF-TOKEN': token
    },
    method: 'POST',
    body: dataform
    });
    let data = await response.json();
    console.log(data);
    
})

const showModalcreate = () => {

}