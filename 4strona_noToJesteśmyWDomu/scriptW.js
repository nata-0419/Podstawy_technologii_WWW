function convertCurrency() {
    let pln = parseFloat(document.getElementById('pln').value);
    let currency = document.getElementById('currency').value;
    
    const exchangeRates = {
        euro: 4.7, 
        usd: 4.2    
    };
    
    if (isNaN(pln)) {
        alert("Proszę wpisać poprawną kwotę w złotówkach.");
        return;
    }
    
    let result = pln * exchangeRates[currency];
    
    document.getElementById('result').textContent = result.toFixed(2);
}
