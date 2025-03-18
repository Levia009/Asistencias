<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: menu.php");
    exit();
}

require_once '../config/conexion.php';

$database = Database::getInstance();
$conn = $database->getConnection();

$ficha = isset($_GET['ficha']) ? intval($_GET['ficha']) : "";

$currentDate = date('Y-m-d');

if ($ficha != "") {
    try {
        $estudiantes = $conn->prepare("SELECT e.*, COALESCE(e.fecha, :currentDate) as fecha_mostrar FROM estudiantes e WHERE e.ficha_id = :ficha AND e.faltas > 3");
        $estudiantes->bindParam(':ficha', $ficha, PDO::PARAM_INT);
        $estudiantes->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
        $estudiantes->execute();
    } catch (PDOException $e) {
        echo "Error al obtener estudiantes: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estudiantes con Más de 3 Faltas</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-500 to-purple-600 min-h-screen flex items-center justify-center font-sans">
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-5xl">
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">Estudiantes con Más de 3 Faltas</h1>

        <?php
        if ($estudiantes && $estudiantes->rowCount() > 0) {
            echo "<div class='overflow-x-auto'>";
            echo "<table class='w-full border-collapse border border-gray-300 shadow-lg rounded-xl'>";
            echo "<thead class='bg-indigo-500 text-white text-lg'>";
            echo "<tr>";
            echo "<th class='px-6 py-3 text-left'>Nombre</th>";
            echo "<th class='px-6 py-3 text-left'>Faltas</th>";
            echo "<th class='px-6 py-3 text-left'>Fecha</th>";
            echo "</tr>";
            echo "</thead>";
            echo "<tbody class='text-gray-700 text-lg'>";

            while ($row = $estudiantes->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr class='border-b border-gray-300 hover:bg-gray-100'>";
                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['nombre']) . "</td>";
                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['faltas']) . "</td>";
                echo "<td class='px-6 py-4'>" . htmlspecialchars($row['fecha_mostrar']) . "</td>";
                echo "</tr>";
            }

            echo "</tbody>";
            echo "</table>";
            echo "</div>";
        } else {
            echo "<p class='text-center text-xl text-gray-600 mt-6'>No se encontraron estudiantes con más de 3 faltas.</p>";
        }

        $conn = null;
        ?>
    </div>
</body>
</html>
