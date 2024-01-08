// return the price of the product (in the hidden input with name "prix")
// + the price of every supplement (in the select elements) using a regex to get the price from the text of the selected option (ex: "+ 1.00 €")
function calculatePrice() {
    var price_elem = document.querySelector('.product-form input[name="prix"]');
    var price = parseFloat(price_elem.value);

    var selects = document.querySelectorAll('.product-form select');

    var total = price;
    console.log("Prix de base : " + total);

    for (var i = 0; i < selects.length; i++) {
        var selectedOption = selects[i].options[selects[i].selectedIndex];
        var regex = /\+(\d+\.\d{2}) €/;
        var match = regex.exec(selectedOption.innerText);

        if (match) {
            var optionPrice = parseFloat(match[1]);
            console.log("Prix de l'option " + i + " : " + optionPrice);
            total += optionPrice;
        }
    }

    if (!isNaN(total)) {
        document.querySelector('.product-price').innerHTML = total + " €";
    }

    console.log("Prix total : " + total);
    return total;
}


// trigger the function on load and on change of the "select" elements
window.onload = calculatePrice;
var selects = document.querySelectorAll('.product-form select');
for (var i = 0; i < selects.length; i++) {
    selects[i].onchange = calculatePrice;
}
