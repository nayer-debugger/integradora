document.addEventListener("DOMContentLoaded", function () {
  const formulario = document.getElementById("formulario-login");

  formulario.addEventListener("submit", function (e) {
    const correo = document.getElementById("correo").value.trim();
    const contrasena = document.getElementById("contrasena").value.trim();

    if (!correo || !contrasena) {
      alert("Por favor, completa todos los campos.");
      e.preventDefault();
    }
  });
});
