<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: menu.php");
    exit();
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
        <h2 class="text-center text-2xl font-semibold text-gray-700 mb-6">Menú</h2>
        <p class="text-center">Bienvenido al menú principal.</p>

        <!-- Botón para crear un UltraAdministrador -->
        <div class="mt-6 text-center">
            <button id="showFormButton" class="w-full py-3 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400">
                Crear UltraAdministrador
            </button>
        </div>

        <!-- Formulario para crear UltraAdministrador (inicialmente oculto) -->
        <div id="createAdminForm" class="mt-6 hidden">
            <form method="POST" action="crearUltraAdmin.php">
                <div class="mb-4">
                    <label for="username" class="block text-sm font-medium text-gray-600">Nombre de usuario:</label>
                    <input type="text" class="w-full p-3 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name="username" required><br>
                </div>

                <div class="mb-4">
                    <label for="password" class="block text-sm font-medium text-gray-600">Contraseña:</label>
                    <div class="relative">
                        <input type="password" class="w-full p-3 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name="password" required><br>
                    </div>
                </div>

                <button type="submit" class="w-full py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">Crear UltraAdministrador</button>
            </form>
        </div>

        <!-- Botón para cerrar sesión -->
        <div class="mt-6">
            <a href="cerrar_sesion.php" class="w-full py-3 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 block text-center">
                Cerrar Sesión
            </a>
        </div>
    </div>

    <script>
        // Mostrar u ocultar el formulario para crear UltraAdministrador
        document.getElementById('showFormButton').addEventListener('click', function() {
            var form = document.getElementById('createAdminForm');
            form.classList.toggle('hidden');
        });
    </script>
</body>

</html>
