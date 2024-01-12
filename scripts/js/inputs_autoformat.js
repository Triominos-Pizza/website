// Return the position of the next digit in the input string (or the previous digit if isBackspace is true)
function nextDigit(input, cursorpos, isBackspace) {
    if (isBackspace) {
        for (let i = cursorpos - 1; i > 0; i--) {
            if (/\d/.test(input[i])) {
                return i
            }
        }
    } else {
        for (let i = cursorpos - 1; i < input.length; i++) {
            if (/\d/.test(input[i])) {
                return i
            }
        }
    }

    return cursorpos
}

// Return the input string with the pattern applied
function patternMatch({ input, template }) {
    try {
        let j = 0;
        let plaintext = "";
        let countj = 0;
        while (j < template.length) {
            if (countj > input.length - 1) {
                template = template.substring(0, j);
                break;
            }
            
            if (template[j] == input[j]) {
                j++;
                countj++;
                continue;
            }
            
            if (template[j] == "x") {
                template =
                template.substring(0, j) + input[countj] + template.substring(j + 1);
                plaintext = plaintext + input[countj];
                countj++;
            }
            j++;
        }
        
        return template;
    } catch {
        return "";
    }
}

// function for listener events on inputs using the patternMatch function
function forcePatternMatch(e) {
    let cursorPos = e.target.selectionStart
    let currentValue = e.target.value
    let cleanValue = currentValue.replace(/\D/g, "");
    console.log(e.target.dataset.pattern)
    let formatInput = patternMatch({
        input: cleanValue,
        template: e.target.dataset.pattern
    });
    
    e.target.value = formatInput
    
    let isBackspace = (e?.data == null) ? true : false
    let nextCusPos = nextDigit(formatInput, cursorPos, isBackspace)
    
    e.target.setSelectionRange(nextCusPos + 1, nextCusPos + 1);
}

// add event listener on all inputs with a data-pattern attribute
const inputsPattern = document.querySelectorAll('input[data-pattern]');
for (var i = 0; i < inputsPattern.length; i++) {
    inputsPattern[i].addEventListener("input", forcePatternMatch);
}


function forceUpperCase(e) {
    // force uppercase
    e.target.value = e.target.value.toUpperCase();

    // set cursor position
    let cursorPos = e.target.selectionStart
    e.target.setSelectionRange(cursorPos, cursorPos);
}

// add event listener on all inputs with a data-force-uppercase attribute
const inputsUppercase = document.querySelectorAll('input[data-force-uppercase]');
for (var i = 0; i < inputsUppercase.length; i++) {
    inputsUppercase[i].addEventListener("input", forceUpperCase);
}

function forceAcceptedCharacters(e) {
    // force accepted characters
    let acceptedCharacters = e.target.dataset.acceptedCharacters;
    console.log(acceptedCharacters)
    let regex = new RegExp(`[^${acceptedCharacters}]`, 'g');
    e.target.value = e.target.value.replace(regex, '');

    // set cursor position
    let cursorPos = e.target.selectionStart
    e.target.setSelectionRange(cursorPos, cursorPos);    
}

// add event listener on all inputs with a data-accepted-characters attribute
const inputsAcceptedCharacters = document.querySelectorAll('input[data-accepted-characters]');
for (var i = 0; i < inputsAcceptedCharacters.length; i++) {
    inputsAcceptedCharacters[i].addEventListener("input", forceAcceptedCharacters);
}
