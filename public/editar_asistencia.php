<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Editar Asistencia</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gradient-to-r from-blue-500 to-indigo-600 min-h-screen flex items-center justify-center font-sans">
    <div class="bg-white p-8 rounded-2xl shadow-xl w-full max-w-4xl">
        <h1 class="text-3xl font-bold text-gray-800 text-center mb-6">Editar Asistencia</h1>
        
        <?php
        include "../config/conexion.php";
        
        $database = Database::getInstance();
        $conn = $database->getConnection();
        
        if (!isset($_GET['id']) || empty($_GET['id'])) {
            die("<p class='text-center text-xl text-red-500'>ID de clase no válido.</p>");
        }
        $id = $_GET['id'];
        
        if ($id != "") {
            $aprendices = $conn->prepare("SELECT * FROM estudiantes WHERE id = :id");
            $aprendices->bindParam(':id', $id, PDO::PARAM_STR);
            $aprendices->execute();
            
            if ($aprendices->rowCount() > 0) {
                echo "<form method='post' action='update_asistencia.php' class='space-y-4'>";
                echo "<input type='hidden' name='id' value='" . $id . "' />";
                echo "<div class='overflow-x-auto'>";
                echo "<table class='w-full border-collapse border border-gray-300 shadow-lg rounded-xl'>";
                echo "<thead class='bg-blue-600 text-white text-lg'>";
                echo "<tr><th class='px-6 py-3'>Nombre</th><th class='px-6 py-3'>Clase 1</th><th class='px-6 py-3'>Clase 2</th><th class='px-6 py-3'>Clase 3</th></tr>";
                echo "</thead><tbody class='text-gray-700 text-lg'>";
                
                while ($row = $aprendices->fetch(PDO::FETCH_ASSOC)) {
                    echo "<tr class='border-b border-gray-300 hover:bg-gray-100 text-center'>";
                    echo "<td class='px-6 py-4 font-semibold text-gray-800'>" . $row['nombre'] . "</td>";
                    
                    for ($i = 1; $i <= 3; $i++) {
                        echo "<td class='px-6 py-4'>";
                        echo "<div class='flex justify-center space-x-2'>";
                        echo "<label class='inline-flex items-center'><input type='radio' name='hora$i' value='A' class='form-radio text-blue-500'><span class='ml-2'>Asistió</span></label>";
                        echo "<label class='inline-flex items-center'><input type='radio' name='hora$i' value='I' class='form-radio text-red-500'><span class='ml-2'>Faltó</span></label>";
                        echo "<label class='inline-flex items-center'><input type='radio' name='hora$i' value='F' class='form-radio text-yellow-500'><span class='ml-2'>Fuga</span></label>";
                        echo "</div></td>";
                    }
                    echo "</tr>";
                }
                
                echo "</tbody></table></div>";
                echo "<div class='flex justify-center mt-6'>";
                echo "<input type='submit' value='Guardar' class='px-6 py-3 bg-green-500 text-white font-bold rounded-lg shadow-md hover:bg-green-600 transition duration-300 cursor-pointer'/>";
                echo "<a href='instructor.php' class='px-6 py-3 bg-red-500 text-white font-bold rounded-lg shadow-md hover:bg-red-600 transition duration-300 cursor-pointer'>Volver</a>";
                echo "</div></form>";
            } else {
                echo "<p class='text-center text-xl text-gray-600 mt-6'>No se encontraron aprendices para la ficha seleccionada.</p>";
            }
        } else {
            echo "<p class='text-center text-xl text-gray-600 mt-6'>Seleccione una ficha.</p>";
        }
        
        $conn = null;
        ?>
    </div>
</body>
</html>