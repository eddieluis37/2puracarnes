console.log("Starting desposte aves")
const table = document.querySelector("#tableDesposteaves");


table.addEventListener("keydown", function(event) {
  if (event.keyCode === 13) {
    const target = event.target;
    if (target.tagName === "INPUT" && target.closest("tr")) {
       //Execute your code here
      console.log("Enter key pressed on an input inside a table row");
      console.log(event.target.value);
      console.log(event.target.id);

      /*const inputValue = event.target.value;
      if (inputValue == "") {
        return false;
      }
      const trimValue = inputValue.trim();
      const dataform = new FormData();
      dataform.append("id", Number(event.target.id));
      dataform.append("peso_kilo", Number(trimValue));
      dataform.append("beneficioId", Number(beneficioId.value));
      sendData("/desposteresUpdate",dataform,token).then((result) => {
        showDataTable(result);
      });*/
    }
  }
});