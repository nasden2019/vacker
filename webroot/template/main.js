const errorN = document.querySelector('.errorN');
const errorE = document.querySelector('.errorE');
const form = document.querySelector('form');

document.querySelector('form').addEventListener('submit', (e) => {
    e.preventDefault();
    // const inputE = form.email.value.trim();
    // console.log(input)

    if (form.nombre.value.trim() == '' || form.nombre.value.trim() == null) {

        errorN.innerHTML = `<div class="alert alert-dark" role="alert">
        Escriba su nombre
      </div>`;
    } else {
        form.nombre.style.border = " 2px green solid";
    }

    if (form.email.value == '' || form.email.value == null) {
        errorE.innerHTML = `<div class="alert alert-danger" role="alert">
        Escriba su correo
      </div>`
    } else {
        form.email.style.border = " 2px green solid";
    }
})