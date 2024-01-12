function incrQuantite() {
    const elem = document.getElementById('quantite');
    elem.value++;
}

function decrQuantite() {
    const elem = document.getElementById('quantite');
    if (elem.value > 1) {elem.value--;}
}

function incrIngredient(ingredient) {
    const elem = document.getElementById('ingredient-' + ingredient);
    elem.value++;

    // trigger the onchange event to update the price
    elem.dispatchEvent(new Event('change'));
}

function decrIngredient(ingredient) {
    const elem = document.getElementById('ingredient-' + ingredient);
    if (elem.value > 0) {elem.value--;}

    // trigger the onchange event to update the price
    elem.dispatchEvent(new Event('change'));
}

function resetIngredient(ingredient) {
    const elem = document.getElementById('ingredient-' + ingredient);
    const val = document.getElementById('ingredient-' + ingredient).defaultValue;
    elem.value = val;

    // trigger the onchange event to update the price
    elem.dispatchEvent(new Event('change'));
}

// return the price of the product (in the hidden input with name "prix")
// + the price of every supplement (in the select elements) using a regex to get the price from the text of the selected option (ex: "+ 1.00 €")
function calculatePrice() {
    var price_elem = document.querySelector('input[name="price"]');
    var price = parseFloat(price_elem.value);

    var total = price;
    console.log("Prix de base : " + total);
    
    // get the price of every option (sauce, pâte, taille)
    var selects = document.querySelectorAll('.product-form select');
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

    // get the price of every ingredient added
    var inputs = document.querySelectorAll('.product-form-ingredient input[id^=ingredient-]')
    for (var i = 0; i < inputs.length; i++) {
        var idIngredient = inputs[i].id.split('-')[1];
        console.log("idIngredient : " + idIngredient);
        console.log(`ingredient-${idIngredient}-price`);
        var ingredientPrice = document.querySelector('input#ingredient-' + idIngredient + '-price').value;
        var ingredientQuantity = Math.max(parseFloat(inputs[i].value) - parseFloat(inputs[i].defaultValue), 0);
        console.log("Prix de l'ingrédient " + i + " : " + ingredientPrice);
        console.log("Quantité de l'ingrédient " + i + " : " + ingredientQuantity);
        total += ingredientPrice * ingredientQuantity;
    }

    if (!isNaN(total)) {
        // round to 2 decimals because of floating point precision
        total = Math.round(total * 100) / 100;
        document.querySelector('.product-price').innerHTML = total + " €";
    }

    console.log("Prix total : " + total);
    return total;
}


// trigger the function on load
window.onload = calculatePrice;

// trigger the function on change of the "select" elements for the options (sauce, pâte, taille)
var selects = document.querySelectorAll('.product-form select');
for (var i = 0; i < selects.length; i++) {
    selects[i].onchange = calculatePrice;
}

// Trigger the function on change of the "input" elements for the ingredients
var inputs = document.querySelectorAll('.product-form-ingredient input[id^=ingredient-]')
for (var i = 0; i < inputs.length; i++) {
    inputs[i].onchange = calculatePrice;
}

// Apply .fade-right to the ingredients list if the list is not scrolled to the end
// Same for .fade-left if the list is not scrolled to the beginning
function checkScroll() {
    const ingredientsList = document.querySelector('.product-form-ingredients-list');

    if (ingredientsList.scrollLeft + ingredientsList.clientWidth < ingredientsList.scrollWidth) {
        ingredientsList.classList.add('fade-right');
    } else {
        ingredientsList.classList.remove('fade-right');
    }
    
    if (ingredientsList.scrollLeft > 0) {
        ingredientsList.classList.add('fade-left');
    } else {
        ingredientsList.classList.remove('fade-left');
    }
}

// listen to scroll event
const ingredientsList = document.querySelector('.product-form-ingredients-list');
ingredientsList.addEventListener('scroll', checkScroll);
