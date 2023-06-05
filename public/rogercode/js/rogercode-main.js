console.log("the data is very main");
const formatCantidad = (number) => {
    let formatMoney = new Intl.NumberFormat('es-CL', { 
        //style: 'currency',
        //currency: 'CLP', 
        //currencyDisplay: 'none',
        minimumFractionDigits: 2, 
        maximumFractionDigits: 2,
        useGrouping: true 
    }).format(number)
    return formatMoney;
}

const formatkg = (peso) => {
    //let formatnumber = formatCantidad(peso);
    //let formatnumber = formatMoneyNumber(peso);
    //console.log(formatnumber);
    let data = formatMoneyNumber(peso);
    console.log(data);
    //const weight = 1234.56; // in kilograms
    const formattedWeight = Number(data).toLocaleString('es-CO', {
        //style: 'unit',
        unit: 'kilogram',
        unitDisplay: 'narrow',
    });

    console.log(formattedWeight); // "1.234,56 kg"
    return formattedWeight;
}



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