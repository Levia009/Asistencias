<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: menu.php");
    exit();
}

require_once '../config/conexion.php';

$database = Database::getInstance();
$conn = $database->getConnection();

// Obtener fichas disponibles
$fichasQuery = "SELECT id, ficha FROM fichas ORDER BY ficha ASC";
$fichasResult = $conn->query($fichasQuery);

$ficha = isset($_POST['ficha']) ? intval($_POST['ficha']) : "";

// Get current date for new records
$currentDate = date('Y-m-d');
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Registro de Asistencia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-indigo-500 to-purple-600 min-h-screen flex items-center justify-center font-sans">
    <div class="bg-white p-10 rounded-2xl shadow-xl w-full max-w-5xl">
        <a href="logout.php" class="px-6 py-3 bg-red-500 text-white font-bold rounded-lg shadow-md hover:bg-red-600 transition duration-300">Cerrar Sesión</a>
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">Registro de Asistencia</h1>

        <!-- Formulario de selección de ficha -->
        <form method="get" class="mb-6">
    <input type="hidden" name="ficha" value="<?= $ficha; ?>">
    <button type="submit" formaction="estudiantes_faltas.php" class="px-6 py-3 bg-blue-500 text-white font-bold rounded-lg shadow-md hover:bg-blue-600 transition duration-300">Ver Estudiantes con Más de 3 Faltas</button>
</form>


        <form method="post" class="mb-6">
            <label for="ficha" class="block text-xl font-semibold text-gray-700 mb-2">Selecciona una Ficha</label>
            <select name="ficha" id="ficha" onchange="this.form.submit()" class="w-full p-3 border border-gray-300 rounded-md shadow-md focus:outline-none focus:ring-2 focus:ring-indigo-500 text-lg">
                <option value="" disabled selected>Elige una ficha</option>
                <?php while ($row = $fichasResult->fetch(PDO::FETCH_ASSOC)) { ?>
                    <option value="<?= $row['id']; ?>" <?= ($ficha == $row['id']) ? 'selected' : ''; ?>><?= htmlspecialchars($row['ficha']); ?></option>
                <?php } ?>
            </select>
        </form>

        <?php
        if ($ficha != "") {
            // Obtener estudiantes de la ficha seleccionada
            try {
                $estudiantes = $conn->prepare("SELECT e.*, COALESCE(e.fecha, :currentDate) as fecha_mostrar FROM estudiantes e WHERE e.ficha_id = :ficha");
                $estudiantes->bindParam(':ficha', $ficha, PDO::PARAM_INT);
                $estudiantes->bindParam(':currentDate', $currentDate, PDO::PARAM_STR);
                $estudiantes->execute();
            } catch (PDOException $e) {
                echo "Error al obtener estudiantes: " . $e->getMessage();
            }

            if ($estudiantes->rowCount() > 0) {
                echo "<div class='overflow-x-auto'>";
                echo "<table class='w-full border-collapse border border-gray-300 shadow-lg rounded-xl'>";
                echo "<thead class='bg-indigo-500 text-white text-lg'>";
                echo "<tr>";
                echo "<th class='px-6 py-3 text-left'>Nombre</th>";
                echo "<th class='px-6 py-3 text-left'>Clase 1</th>";
                echo "<th class='px-6 py-3 text-left'>Clase 2</th>";
                echo "<th class='px-6 py-3 text-left'>Clase 3</th>";
                echo "<th class='px-6 py-3 text-left'>Fecha</th>";
                echo "<th class='px-6 py-3 text-left'>Acción</th>";
                echo "</tr>";
                echo "</thead>";
                echo "<tbody class='text-gray-700 text-lg'>";

                while ($row = $estudiantes->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr class='border-b border-gray-300 hover:bg-gray-100'>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['nombre']) . "</td>";
                    echo "<td class='px-6 py-4'>" . (isset($row['hora1']) ? htmlspecialchars($row['hora1']) : 'No disponible') . "</td>";
                    echo "<td class='px-6 py-4'>" . (isset($row['hora2']) ? htmlspecialchars($row['hora2']) : 'No disponible') . "</td>";
                    echo "<td class='px-6 py-4'>" . (isset($row['hora3']) ? htmlspecialchars($row['hora3']) : 'No disponible') . "</td>";
                    echo "<td class='px-6 py-4'>" . htmlspecialchars($row['fecha_mostrar']) . "</td>";
                    echo "<td class='px-6 py-4'><a href='editar_asistencia.php?id=" . $row['id'] . "&fecha=" . urlencode($row['fecha_mostrar']) . "' class='text-indigo-600 hover:text-indigo-800 font-semibold'>Editar</a></td>";
                    echo "</tr>";
                }

                echo "</tbody>";
                echo "</table>";
                echo "</div>";
            } else {
                echo "<p class='text-center text-xl text-gray-600 mt-6'>No se encontraron estudiantes para la ficha seleccionada.</p>";
            }
        } else {
            echo "<p class='text-center text-xl text-gray-600 mt-6'>Seleccione una ficha.</p>";
        }

        $conn = null;
        ?>
    </div>
</body>
</html>