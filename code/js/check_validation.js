    
const title1 = 'title';
const desc = 'desc';
const threedurl1 = '3durl1';
const threedurl2 = '3durl2';
const additionalinfourl = 'additionalinfourl';
const option1 = 'option1';
const option2 = 'option2';

const title1Error = 'title_error';
const descError = 'desc_error';
// const threedurl1Error = document.querySelector('#3durl1 + span.error');
// const threedurl2Error = document.querySelector('#3durl2 + span.error');
const threedurl1Error = 'threedurl1_error';
const threedurl2Error = 'threedurl2_error';
const additionalinfourlError = 'additionalinfourl_error';
const option1Error = 'option1_error';
const option2Error = 'option2_error';

const elementsMap = new Map();
elementsMap.set(title1, title1Error);
elementsMap.set(desc, descError);
elementsMap.set(threedurl1, threedurl1Error);
elementsMap.set(threedurl2, threedurl2Error);
elementsMap.set(additionalinfourl, additionalinfourlError);
elementsMap.set(option1, option1Error);
elementsMap.set(option2, option2Error);



function buildEventListeners(el, elError) {
    // var e1 = "'#" + el + "'";
    // var e2 = "'#" + elError  + "'";
    var element = document.getElementById(el);
    var elementError = document.getElementById(elError);
    element.addEventListener('input', function (event) {
        // Each time the user types something, we check if the
        // form fields are valid.
        if (element.validity.valid) {
            // In case there is an error message visible, if the field
            // is valid, we remove the error message.
            elementError.textContent = ''; // Reset the content of the message
            elementError.className = 'error'; // Reset the visual state of the message
        } else {
            // If there is still an error, show the correct error
            showError(element, elementError);
        }
    });
}


function onFormSubmission(el, elError) {
    var element = document.getElementById(el);
    var elementError = document.getElementById(elError);
    // if the title field isn't valid, we don't let the form submit
    if(!element.validity.valid) {
        // If it isn't, we display an appropriate error message
        showError(element, elementError);
        // Then we prevent the form from being sent by canceling the event
        // e.preventDefault();
        
        // on error, return false
        return false;
    }
    // on success, return true
    return true;
}


function showError(element, elementError) {
    if(element.validity.valueMissing) {
        // If the field is empty,
        // display the following error message.
        elementError.textContent = 'You need to fill the input field.';
    }
    // Set the styling appropriately
    elementError.className = 'error active';
}
