<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: menu.php");
    exit();
}

require_once '../config/conexion.php';

$database = Database::getInstance();
$conn = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST['id'];
    $hora1 = $_POST['hora1'];
    $hora2 = $_POST['hora2'];
    $hora3 = $_POST['hora3'];
    $fecha = $_POST['fecha']; // Asegúrate de que el formulario envíe este campo

    try {
        // Actualizar la asistencia incluyendo la fecha
        $stmt = $conn->prepare("UPDATE estudiantes SET hora1 = :hora1, hora2 = :hora2, hora3 = :hora3, fecha = :fecha WHERE id = :id");
        $stmt->bindParam(':hora1', $hora1);
        $stmt->bindParam(':hora2', $hora2);
        $stmt->bindParam(':hora3', $hora3);
        $stmt->bindParam(':fecha', $fecha);
        $stmt->bindParam(':id', $id);
        $stmt->execute();

        // Mostrar alerta y redirigir
        echo "<script>
                alert('Registro actualizado correctamente.');
                window.location.href = 'instructor.php';
              </script>";
    } catch (PDOException $e) {
        echo "<p class='text-center text-xl text-red-500'>Error al actualizar la asistencia: " . $e->getMessage() . "</p>";
    }
} else {
    echo "<p class='text-center text-xl text-red-500'>Método de solicitud no válido.</p>";
}

$conn = null;
?>