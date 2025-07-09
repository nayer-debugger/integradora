<?php
include("conexionBD.php"); // Aquí se conecta con la base de datos
session_start(); // Inicia la sesión para poder usar $_SESSION

$mensaje = "";
$tipo_mensaje = ""; // 'exito' o 'error'

if (isset($_SESSION['mensaje'])) {
    $mensaje = $_SESSION['mensaje'];

    // Clasificamos el mensaje como éxito o error
    if ($mensaje === "Usuario registrado exitosamente." || $mensaje === "Inicio de sesión exitoso.") {
        $tipo_mensaje = "exito";
    } else {
        $tipo_mensaje = "error";
    }

    unset($_SESSION['mensaje']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $correo = trim($_POST['correo']); 
    $contrasena = trim($_POST['contrasena']);

    // Verificamos si el usuario ya existe
    $consulta = "SELECT * FROM login WHERE correo='$correo' AND contraseña='$contrasena'";
    $resultado = mysqli_query($conexion, $consulta);

    if (mysqli_num_rows($resultado) > 0) {
        $_SESSION['mensaje'] = "Inicio de sesión exitoso.";
    } else {
        // Si no existe, lo registramos
        $insertar = "INSERT INTO login (correo, contraseña) VALUES ('$correo', '$contrasena')";
        if (mysqli_query($conexion, $insertar)) {
            $_SESSION['mensaje'] = "Usuario registrado exitosamente.";
        } else {
            $_SESSION['mensaje'] = "Error al registrar usuario.";
        }
    }

    header("Location: " . $_SERVER['PHP_SELF']);
    exit;
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8" />
  <title>UTTcam</title>
  <link rel="icon" type="image/x-icon" href="data:image/x-icon;base64," />
  <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
  <link rel="stylesheet" href="login.css" />
  <script defer src="3.js"></script>
</head>
<body>
  <div class="min-h-screen flex flex-col bg-white">
    <header class="flex items-center justify-between border-b px-10 py-3">
      <div class="flex items-center gap-4">
        <svg class="size-4" viewBox="0 0 48 48" fill="none"><path d="M44..." fill="currentColor"></path></svg>
        <img src="Logo TIID.png" alt="Logo TIID" width="180" height="50">
      </div>
      <nav class="flex gap-9">
        <a class="text-sm font-medium" href="#">Prueba</a>
        <a class="text-sm font-medium" href="#">Prueba</a>
        <a class="text-sm font-medium" href="#">Prueba</a>
        <button class="btn-sesion">Iniciar sesión</button>
      </nav>
    </header>

    <main class="flex justify-center py-10 px-4">
      <div class="w-full max-w-md">
        <h2 class="text-center text-2xl font-bold mb-6">¡Bienvenido!</h2>

        <?php if ($mensaje): ?>
          <div class="text-center font-medium mb-4 
                      <?= $tipo_mensaje === 'exito' ? 'text-green-600' : 'text-red-600' ?>">
            <?= $mensaje ?>
          </div>
        <?php endif; ?>

        <form method="POST" action="" id="formulario-login">
          <div class="mb-4">
            <input
              type="email"
              name="correo"
              id="correo"
              placeholder="Correo electrónico"
              required
              class="input-form"
            />
          </div>
          <div class="mb-4">
            <input
              type="password"
              name="contrasena"
              id="contrasena"
              placeholder="Contraseña"
              required
              class="input-form"
            />
          </div>
          <div class="flex flex-col gap-3">
            <button type="submit" class="btn-principal">Iniciar Sesión</button>
            <a href="crearEmpresa.html" class="btn-secundario text-center flex justify-center items-center">Registrar Empresa</a>
            <a href="registro_estudiantes.html" class="btn-secundario text-center flex justify-center items-center">Registrar Estudiante</a>
          </div>
        </form>
      </div>
    </main>
  </div>
</body>
</html>
