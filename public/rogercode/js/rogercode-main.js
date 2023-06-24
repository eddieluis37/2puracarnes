console.log("the data is very main");
/* 1. Se declara una función llamada "formatCantidad" que toma un número como argumento. */
const formatCantidad = (number) => {    
    /* 5. La cadena formateada se almacena en la variable "formatMoney". */
    let formatMoney = new Intl.NumberFormat("es-CL", {
                     /* 2. La función crea una nueva instancia del objeto "Intl.NumberFormat" con la localización del español de Chile y ciertas opciones.  */
        //style: 'currency',
        //currency: 'CLP',
        //currencyDisplay: 'none',
        minimumFractionDigits: 2 /* 3.Opciones especificas para la cadena formateada */,
        maximumFractionDigits: 2,
        useGrouping: true,
    }).format(number); // 4. Se llama al método "format" del objeto "Intl.NumberFormat" con el argumento de número pasado a la función.
    return formatMoney; // 6. La cadena formateada se devuelve a través de la función.
};

const formatkg = (peso) => {
    //let formatnumber = formatCantidad(peso);
    //let formatnumber = formatMoneyNumber(peso);
    //console.log(formatnumber);
    let data = formatMoneyNumber(peso);
    console.log(data);
    //const weight = 1234.56; // in kilograms
    const formattedWeight = Number(data).toLocaleString("es-CO", {
        //style: 'unit',
        unit: "kilogram",
        unitDisplay: "narrow",
    });

    console.log(formattedWeight); // "1.234,56 kg"
    return formattedWeight;
};



const formatCantidadSinCero = (number) => {
    let formatMoney = new Intl.NumberFormat('es-CL', { 
        //style: 'currency',
        //currency: 'CLP', 
        //currencyDisplay: 'none',
        minimumFractionDigits: 0, 
        maximumFractionDigits: 0,
        useGrouping: true 
    }).format(number)
    return formatMoney;
}

const formatMoneyNumber = (string) => {
    console.log(string);
    if(string !== ""){
        const numberFormatValue = parseFloat(string.replace(/[^\d,-]/g, '').replace(',', '.'));
        console.log(numberFormatValue);
        return Number(numberFormatValue);
    }

    return Number(0);
}

const formatDate = (dateString) => {
  let date = new Date(dateString);
  const year = date.getFullYear();
  const month = ('0' + (date.getMonth() + 1)).slice(-2); 
  const day = ('0' + date.getDate()).slice(-2);
  return `${month}-${day}-${year}`;
}