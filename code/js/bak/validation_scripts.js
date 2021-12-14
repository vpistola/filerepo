// There are many ways to pick a DOM node; here we get the form itself and the email
// input box, as well as the span element into which we will place the error message.
const form  = document.getElementsByTagName('form')[0];

const title = document.getElementById('title');
const desc = document.getElementById('desc');
const threedurl1 = document.getElementById('3durl1');
const threedurl2 = document.getElementById('3durl2');
const additionalinfourl = document.getElementById('additionalinfourl');
const option1 = document.getElementById('option1');
const option2 = document.getElementById('option2');

const titleError = document.querySelector('#title + span.error');
const descError = document.querySelector('#desc + span.error');
// const threedurl1Error = document.querySelector('#3durl1 + span.error');
// const threedurl2Error = document.querySelector('#3durl2 + span.error');
const additionalinfourlError = document.querySelector('#additionalinfourl + span.error');
const option1Error = document.querySelector('#option1 + span.error');
const option2Error = document.querySelector('#option2 + span.error');

title.addEventListener('input', function (event) {
  // Each time the user types something, we check if the
  // form fields are valid.

  if (title.validity.valid) {
    // In case there is an error message visible, if the field
    // is valid, we remove the error message.
    titleError.textContent = ''; // Reset the content of the message
    titleError.className = 'error'; // Reset the visual state of the message
  } else {
    // If there is still an error, show the correct error
    showError();
  }
});

form.addEventListener('submit', function (event) {
    // if the email field is valid, we let the form submit

    if(!title.validity.valid) {
    // If it isn't, we display an appropriate error message
    showError();
    // Then we prevent the form from being sent by canceling the event
    event.preventDefault();
    }
});

// function showError() {
//   if(email.validity.valueMissing) {
//     // If the field is empty,
//     // display the following error message.
//     emailError.textContent = 'You need to enter an e-mail address.';
//   } else if(email.validity.typeMismatch) {
//     // If the field doesn't contain an email address,
//     // display the following error message.
//     emailError.textContent = 'Entered value needs to be an e-mail address.';
//   } else if(email.validity.tooShort) {
//     // If the data is too short,
//     // display the following error message.
//     emailError.textContent = `Email should be at least ${ email.minLength } characters; you entered ${ email.value.length }.`;
//   }

//   // Set the styling appropriately
//   emailError.className = 'error active';
// }


function showError() {
    if(title.validity.valueMissing) {
      // If the field is empty,
      // display the following error message.
      titleError.textContent = 'You need to enter a title.';
    }
  
    // Set the styling appropriately
    emailError.className = 'error active';
  }