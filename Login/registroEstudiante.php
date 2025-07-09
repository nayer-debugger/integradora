<?php
$conexion = new mysqli("localhost", "root", "", "gestadias");
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

if ($_SERVER["REQUEST_METHOD"] === "POST") {
    $nombre = $_POST['nombre'];
    $apellidos = $_POST['apellidos'];
    $grupo = $_POST['grupo'];
    $matricula = $_POST['matricula'];
    $telefono = $_POST['telefono'];
    $domicilio = $_POST['domicilio'];
    $email = $_POST['email'];
    $contrasena = password_hash($_POST['contrasena'], PASSWORD_DEFAULT);
    $carrera_id = intval($_POST['carrera']);

    // Verificar que la carrera exista
    $verificar = $conexion->prepare("SELECT nombre FROM carrera WHERE id = ?");
    $verificar->bind_param("i", $carrera_id);
    $verificar->execute();
    $resultado = $verificar->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        $nombre_carrera = $fila['nombre'];
        $nombre_completo = $nombre . " " . $apellidos;

        // Insertar alumno
        $sql = "INSERT INTO alumno (matricula, nombre_completo, grupo, carrera_id, numero_movil, domicilio, email)
                VALUES (?, ?, ?, ?, ?, ?, ?)";
        $stmt = $conexion->prepare($sql);
        $stmt->bind_param("ississs", $matricula, $nombre_completo, $grupo, $carrera_id, $telefono, $domicilio, $email);

        if ($stmt->execute()) {
            // Redirigir a la página donde se selecciona el nivel
            header("Location: carrera.php?carrera_id=$carrera_id");
            exit();
        } else {
            echo "Error al registrar: " . $stmt->error;
        }
    } else {
        echo "Carrera no encontrada.";
    }
}
?>
