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
