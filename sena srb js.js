
// Mostrar mensajes al seleccionar opciones
function mostrarMensaje(mensaje) {
    alert(mensaje);
}

// Formulario de ingreso de demostración
function iniciarSesion(event) {
    event.preventDefault();

    const correo = document.getElementById("correo").value;
    const contrasena = document.getElementById("contrasena").value;

    if (correo.trim() === "" || contrasena.trim() === "") {
        alert("Por favor, completa todos los campos.");
        return;
    }

    alert("La interfaz de ingreso funciona como demostración. "
        + "Todavía no está conectada a una base de datos.");
}