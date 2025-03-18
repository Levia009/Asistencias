<?php
session_start();
require_once '../config/conexion.php'; // Asegúrate de que la ruta sea correcta

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: ultra_admin.php");
    exit();
}

// Manejo del formulario para crear un coordinador
if (isset($_POST['crear_coordinador'])) {
    $database = Database::getInstance();
    $db = $database->getConnection();

    // Obtener datos del formulario
    $username = $_POST['username'];
    $password = $_POST['password'];
    $role = 'coordinador'; // Define el rol

    // Hash de la contraseña
    $password_hash = password_hash($password, PASSWORD_DEFAULT);

    try {
        // Insertar en la base de datos
        $stmt = $db->prepare("INSERT INTO coordinador (username, password_hash, role) VALUES (:username, :password_hash, :role)");
        $stmt->bindParam(':username', $username);
        $stmt->bindParam(':password_hash', $password_hash);
        $stmt->bindParam(':role', $role);

        if ($stmt->execute()) {
            echo "<script>alert('Coordinador creado exitosamente.');</script>";
        } else {
            echo "<script>alert('Error al crear el coordinador.');</script>";
        }
    } catch (PDOException $e) {
        echo "<script>alert('Error al crear el coordinador: " . $e->getMessage() . "');</script>";
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Menú</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-center text-2xl font-semibold text-gray-700 mb-6">Menú de Ultra Admin</h2>
        <p class="text-center">Bienvenido, <?php echo htmlspecialchars($_SESSION['username']); ?>!</p>

        <!-- Botón para abrir el modal -->
        <button onclick="abrirModal()" class="w-full py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 mt-4">
            Crear Coordinador
        </button>

        <!-- Modal -->
        <div id="modal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
            <div class="bg-white p-6 rounded-lg shadow-lg w-96">
                <h3 class="text-xl font-semibold text-gray-700 mb-4">Crear Coordinador</h3>
                <form method="POST">
                    <div class="mb-4">
                        <label for="username" class="block text-sm font-medium text-gray-600">Usuario:</label>
                        <input type="text" class="w-full p-3 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name="username" required>
                    </div>
                    
                    <div class="mb-4">
                        <label for="password" class="block text-sm font-medium text-gray-600">Contraseña:</label>
                        <input type="password" class="w-full p-3 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name="password" required>
                    </div>
                    
                    <div class="flex justify-between">
                        <button type="submit" name="crear_coordinador" class="py-2 px-4 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">
                            Crear
                        </button>
                        <button type="button" onclick="cerrarModal()" class="py-2 px-4 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400">
                            Cancelar
                        </button>
                    </div>
                </form>
            </div>
        </div>

    <!-- Botón para cerrar sesión -->
<div class="mt-6">
    <a href="logout.php" class="w-full py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 block text-center">
        Cerrar Sesión
    </a>
</div>


    <script>
        function abrirModal() {
            document.getElementById('modal').classList.remove('hidden');
        }
        
        function cerrarModal() {
            document.getElementById('modal').classList.add('hidden');
        }
    </script>
</body>
</html>
