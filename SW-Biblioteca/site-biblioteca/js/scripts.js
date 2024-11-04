/*!
* Start Bootstrap - One Page Wonder v6.0.6 (https://startbootstrap.com/theme/one-page-wonder)
* Copyright 2013-2023 Start Bootstrap
* Licensed under MIT (https://github.com/StartBootstrap/startbootstrap-one-page-wonder/blob/master/LICENSE)
*/
// This file is intentionally blank
// Use this file to add JavaScript to your project
document.querySelector('form').addEventListener('submit', function(event) {
    const email = document.getElementById('exampleFormControlInput1').value;
    const senha = document.getElementById('senha').value;

    if (!email || !senha) {
        alert('Preencha todos os campos');
        event.preventDefault();
    }
});
