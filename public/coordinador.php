<?php
session_start();

// Verificar si el usuario está autenticado
if (!isset($_SESSION['username'])) {
    header("Location: menu.php");
    exit();
}

// Incluir la clase de conexión a la base de datos
require_once '../config/conexion.php'; // Asegúrate de que la ruta es correcta

// Obtener la conexión a la base de datos
$database = Database::getInstance(); // Obtener la única instancia
$conn = $database->getConnection(); // Asigna la conexión a $conn

$fichasQuery = "SELECT id, ficha FROM fichas";
$fichasResult = $conn->query($fichasQuery);

if (!$fichasResult) {
    die("Error en la consulta: " . $conn->errorInfo()[2]); // Mensaje de error
} else {
    echo "Consulta ejecutada correctamente."; // Mensaje de depuración
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Crear Programas y Recursos</title>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
    <script>
        function abrirModal(modalId) {
            document.getElementById(modalId).classList.remove('hidden');
        }

        function cerrarModal(modalId) {
            document.getElementById(modalId).classList.add('hidden');
        }

        function enviarDatos(formId) {
            const form = document.getElementById(formId);
            const formData = new FormData(form);
            
            fetch('guardar.php', {
                method: 'POST',
                body: formData
            })
            .then(response => response.text())
            .then(data => {
                alert(data); // Mostrar respuesta del servidor
                cerrarModal(formId.replace('Form', 'Modal')); // Cerrar el modal
                form.reset(); // Limpiar el formulario
            })
            .catch(error => console.error('Error:', error));
        }

        function cerrarSesion() {
            // Redirigir a la página de cierre de sesión
            window.location.href = 'logout.php';
        }
    </script>
</head>
<body class="bg-gray-100 h-screen flex flex-col items-center justify-center">

    <!-- Contenedor Principal -->
    <div class="bg-white p-8 rounded-lg shadow-lg w-3/4 md:w-1/2 lg:w-1/3">
        <h1 class="text-xl font-semibold mb-4 text-center">Gestión de Programas y Recursos</h1>

        <!-- Botones para abrir los modales -->
        <button onclick="abrirModal('programaFormModal')" class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 mb-2 text-sm">
            Crear Programa Formación
        </button>
        <button onclick="abrirModal('ambienteModal')" class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 mb-2 text-sm">
            Crear Ambiente
        </button>
        <button onclick="abrirModal('fichaModal')" class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 mb-2 text-sm">
            Crear Ficha
        </button>
        <button onclick="abrirModal('instructorModal')" class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 mb-2 text-sm">
            Crear Instructores
        </button>

        <!-- Botón para cerrar sesión -->
        <button onclick="cerrarSesion()" class="w-full py-2 bg-red-500 text-white rounded-lg hover:bg-red-600 focus:outline-none focus:ring-2 focus:ring-red-400 text-sm">
            Cerrar Sesión
        </button>

        <button onclick="abrirModal('aprendizModal')" class="w-full py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 focus:outline-none focus:ring-2 focus:ring-blue-400 mb-2 text-sm">
            Registrar Aprendiz
        </button>
    </div>

    <!-- Modal Programa Formación -->
    <div id="programaFormModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-lg font-semibold mb-4">Crear Programa de Formación</h2>
            <form id="programaForm" onsubmit="event.preventDefault(); enviarDatos('programaForm');">
    <input type="hidden" name="tipo" value="programa">
    <input type="text" name="nombre" placeholder="Nombre del Programa" required class="w-full p-2 border rounded mb-4">
    <button type="submit" class="w-full py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Guardar</button>
</form>

            <button onclick="cerrarModal('programaFormModal')" class="mt-4 text-red-500 hover:underline">Cerrar</button>
        </div>
    </div>

    <!-- Modal Ambiente -->
    <div id="ambienteModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-lg font-semibold mb-4">Crear Ambiente</h2>
            <form id="ambienteForm" onsubmit="event.preventDefault(); enviarDatos('ambienteForm');">
    <input type="hidden" name="tipo" value="ambiente">
    <input type="text" name="nombre" placeholder="Nombre del Ambiente" required class="w-full p-2 border rounded mb-4">
    <button type="submit" class="w-full py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Guardar</button>
</form>

            <button onclick="cerrarModal('ambienteModal')" class="mt-4 text-red-500 hover:underline">Cerrar</button>
        </div>
    </div>

    <!-- Modal Ficha -->
    <div id="fichaModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
        <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
            <h2 class="text-lg font-semibold mb-4">Crear Ficha</h2>
            <form id="fichaForm" onsubmit="event.preventDefault(); enviarDatos('fichaForm');">
    <input type="hidden" name="tipo" value="ficha">
    <input type="text" name="ficha" placeholder="Nombre de la Ficha" required class="w-full p-2 border rounded mb-4">
    <button type="submit" class="w-full py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Guardar</button>
</form>

            <button onclick="cerrarModal('fichaModal')" class="mt-4 text-red-500 hover:underline">Cerrar</button>
        </div>
    </div>

    <!-- Modal Instructores -->
<div id="instructorModal" class="hidden fixed inset-0 bg-black bg-opacity-50 flex items-center justify-center">
    <div class="bg-white p-6 rounded-lg shadow-lg w-96">
        <h3 class="text-xl font-semibold text-gray-700 mb-4 text-center">Crear Instructor</h3>
        <form action="guardar.php" method="POST" class="space-y-4">
            <div>
                <label for="username" class="block text-sm font-medium text-gray-600">Username:</label>
                <input type="text" id="username" name="username" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 p-2">
            </div>
            
            <div>
                <label for="password" class="block text-sm font-medium text-gray-600">Contraseña:</label>
                <input type="password" id="password" name="password" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 p-2">
            </div>
            
            <div>
    <label for="role" class="block text-sm font-medium text-gray-600">Rol:</label>
    <select id="role" name="role" required class="mt-1 block w-full border border-gray-300 rounded-md shadow-sm focus:ring focus:ring-blue-300 focus:border-blue-500 p-2">
        <option value="instructor" selected>Instructor</option>
    </select>
</div>

            
            <div class="flex justify-center">
                <input type="submit" value="Crear Instructor" class="w-full bg-blue-600 text-white font-semibold py-2 rounded-md hover:bg-blue-700 transition duration-200">
            </div>
        </form>
        <button onclick="cerrarModal('instructorModal')" class="mt-4 text-red-500 hover:underline">Cerrar</button>
    </div>
</div>
<div id="aprendizModal" class="fixed inset-0 flex items-center justify-center hidden bg-black bg-opacity-50">
    <div class="bg-white p-6 rounded-lg shadow-lg w-1/3">
        <h2 class="text-lg font-semibold mb-4">Registrar Aprendiz</h2>
        <form id="aprendizForm" onsubmit="event.preventDefault(); enviarDatos('aprendizForm');">
            <input type="hidden" name="tipo" value="aprendiz">
            <input type="text" name="nombre" placeholder="Nombre del Aprendiz" required class="w-full p-2 border rounded mb-4">
            
            <!-- Selección de Ficha corregida -->
            <select name="ficha_id" required class="w-full p-2 border rounded mb-4">
                <option value="">Seleccionar Ficha</option>
                <?php foreach ($fichasResult as $ficha): ?>
                    <option value="<?= $ficha['id']; ?>"><?= $ficha['ficha']; ?></option>
                <?php endforeach; ?>
            </select>

            <button type="submit" class="w-full py-2 bg-green-500 text-white rounded-lg hover:bg-green-600">Guardar</button>
        </form>
        <button type="button" onclick="cerrarModal('aprendizModal')" class="mt-4 text-red-500 hover:underline">Cerrar</button>
    </div>
</div>


<script>
    function abrirModal(modalId) {
        let modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.remove('hidden');
            modal.style.display = 'flex'; // Asegurar que se muestra
        }
    }

    function cerrarModal(modalId) {
        let modal = document.getElementById(modalId);
        if (modal) {
            modal.classList.add('hidden');
            modal.style.display = 'none'; // Asegurar que se oculta
        }
    }
    function enviarDatos(formId) {
    const form = document.getElementById(formId);
    const formData = new FormData(form);
    
    // Para depuración
    for (let [key, value] of formData.entries()) {
        console.log(`${key}: ${value}`);
    }

    fetch('guardar.php', {
        method: 'POST',
        body: formData
    })
    .then(response => response.text())
    .then(data => {
        alert(data);
        cerrarModal(formId.replace('Form', 'Modal'));
        form.reset();
    })
    .catch(error => console.error('Error:', error));
}

</script>



</body>
</html>

