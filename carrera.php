<?php
$conexion = new mysqli("localhost", "root", "", "gestadias");

if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}

if (isset($_GET['carrera_id'])) {
    $carrera_id = $_GET['carrera_id'];

    $sql = "SELECT nombre FROM carrera WHERE id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $carrera_id);
    $stmt->execute();
    $resultado = $stmt->get_result();

    if ($fila = $resultado->fetch_assoc()) {
        $nombre_carrera = $fila['nombre'];
    } else {
        die("Carrera no encontrada.");
    }
} else {
    die("ID de carrera no proporcionado.");
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <title>Seleccionar Nivel</title>
</head>
<body>
    <h2>Datos de la Carrera</h2>

    <form method="post" action="nivel.php">
        <!-- Mostrar nombre solo como texto -->
        <p><strong>Nombre de la carrera:</strong> <?= htmlspecialchars($nombre_carrera) ?></p>
        <!-- Enviar también el nombre por si lo necesitas en guardar_nivel.php -->
        <input type="hidden" name="nombre_carrera" value="<?= htmlspecialchars($nombre_carrera) ?>">
        <input type="hidden" name="carrera_id" value="<?= $carrera_id ?>">

        <label for="nivel">Selecciona el nivel:</label>
        <select name="nivel" required>
            <option value="">--Seleccione--</option>
            <option value="TSU">TSU</option>
            <option value="ING">ING</option>
        </select>

        <br><br>
        <button type="submit">Guardar Nivel</button>
    </form>
</body>
</html>

<?php