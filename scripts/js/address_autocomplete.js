limit = 5;
baseUrl = `https://api-adresse.data.gouv.fr/search/`;
$lon = null;
$lat = null;

addressElem = document.querySelector('#adresse');
numAddressElem = document.querySelector('#numAdresse');
rueAddressElem = document.querySelector('#rueAdresse');
postalCodeElem = document.querySelector('#codePostal');
complementAdresseElem = document.querySelector('#complementAdresse');
cityElem = document.querySelector('#ville');
latElem = document.querySelector('#latitude');
lonElem = document.querySelector('#longitude');
allFields = [addressElem, numAddressElem, rueAddressElem, postalCodeElem, complementAdresseElem, cityElem, latElem, lonElem];

function getCurrentLocation() {
    return new Promise((resolve, reject) => {
        if (!navigator.geolocation) {
            reject('Geolocation is not supported by your browser');
        } else {
            navigator.geolocation.getCurrentPosition(resolve, reject);
        }
    });
}

// get the input element
allFields.forEach((field) => {
    field.addEventListener('input', getAutocompleteAddresses.bind(null, field));
});
    
async function getAutocompleteAddresses() {
    let search = addressElem.value;
    postalCodeElem.value ? search += " " + postalCodeElem.value : "";
    complementAdresseElem.value ? search += " " + complementAdresseElem.value : "";
    cityElem.value ? search += " " + cityElem.value : "";

    const min = 2;
    if (search.length >= min) {
        let url = `${baseUrl}?q=${search}&limit=${limit}`;

        if (navigator.geolocation) {
            try {
                const position = await getCurrentLocation();
                const $lon = position.coords.longitude;
                const $lat = position.coords.latitude;
                url = `${url}&lon=${$lon}&lat=${$lat}`;
            } catch (error) {
                console.error("Error getting location: ", error);
            }
        }

        console.log(url);

        fetch(url)
            .then(response => response.json())
            .then((data) => {
                // get the addresses from the response
                let addresses = data.features;
                let addressesList = addresses.map((address) => {
                    return {
                        label: address.properties.label,
                        housenumber: address.properties.housenumber,
                        street: address.properties.street,
                        postcode: address.properties.postcode,
                        city: address.properties.city,
                        longitude: address.geometry.coordinates[0],
                        latitude: address.geometry.coordinates[1],
                    };
                });

                // remove the previous autocomplete list
                autocompleteList(addressesList, addressElem);
                fillHiddenFields(addressesList);
            });
    }
}

// remove the autocomplete list when the user clicks outside of the input element
document.addEventListener('click', function (e) {
    if (!e.target.classList.contains('autocomplete-item') && !e.target.classList.contains('autocomplete-input')) {
        removeList();
    }
});

function removeList() {
    let list = document.querySelector('.autocomplete-list');
    if (list) { list.remove(); }
}

// create the autocomplete list
function autocompleteList(addressesList, inputElem) {
    removeList(); // remove the previous autocomplete list

    // Create the list element
    let list = document.createElement('ul');
    list.classList.add('autocomplete-list');

    // append the list to the input element
    inputElem.parentNode.appendChild(list);

    // create an item for each address
    addressesList.forEach((address) => {
        let item = document.createElement('li');
        let btn = document.createElement('button');
        btn.innerHTML = address.label;
        item.classList.add('autocomplete-item');
        item.appendChild(btn);
        list.appendChild(item);
        btn.addEventListener('click', function (e) {
            addressElem.value = (address.housenumber ? address.housenumber + " " : "") + (address.street ? address.street : "");
            numAddressElem.value = address.housenumber;
            rueAddressElem.value = address.street;
            postalCodeElem.value = address.postcode;
            complementAdresseElem.value = "";
            cityElem.value = address.city;
            console.log(address.geometry);
            lonElem.value = address.longitude;
            latElem.value = address.latitude;
            
            removeList(); // remove the autocomplete list
        });
    });
}

function fillHiddenFields(addressesList) {
    // register info even for user-entered address
    // i.e. on 'input' event, take the first address of the list and fill the hidden fields
    let firstAddress = addressesList[0];
    if (firstAddress) {
        addressElem.addEventListener('input', function (e) {
            numAddressElem.value = firstAddress.housenumber;
            rueAddressElem.value = firstAddress.street;
            latElem.value = firstAddress.latitude;
            lonElem.value = firstAddress.longitude;
        });
    }   
}

// onload
document.addEventListener('DOMContentLoaded', fillHiddenFields.bind(null, []));
