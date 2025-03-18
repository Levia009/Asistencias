<?php
session_start();

// Incluir la clase Database
require_once 'config/conexion.php';

// Obtener la instancia de la base de datos
$database = Database::getInstance();
$db = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    try {
        // Verificar si el usuario existe en la tabla coordinador
        $checkStmt = $db->prepare("SELECT * FROM coordinador WHERE username = :username");
        $checkStmt->execute(['username' => $username]);
        $user = $checkStmt->fetch(PDO::FETCH_ASSOC);

        // Si no se encuentra en coordinador, buscar en gerente
        if (!$user) {
            $checkStmt = $db->prepare("SELECT * FROM gerente WHERE username = :username");
            $checkStmt->execute(['username' => $username]);
            $user = $checkStmt->fetch(PDO::FETCH_ASSOC);
        }
        // Si no se encuentra en coordinador, buscar en gerente
        if (!$user) {
            $checkStmt = $db->prepare("SELECT * FROM instructor WHERE username = :username");
            $checkStmt->execute(['username' => $username]);
            $user = $checkStmt->fetch(PDO::FETCH_ASSOC);
        }

        // Verificar si el usuario fue encontrado y la contraseña es correcta
        if ($user && password_verify($password, $user['password_hash'])) {
            // Almacenar el nombre de usuario y rol en la sesión
            $_SESSION['username'] = $username;
            $_SESSION['role'] = $user['role'];

            // Redirigir según el rol del usuario
            switch ($_SESSION['role']) {
                case 'ultra_admin':
                    header("Location: public/ultra_admin.php");
                    break;
                case 'super_admin':
                    header("Location: public/super_admin.php");
                    break;
                case 'coordinador':
                    header("Location: public/coordinador.php");
                    break;
                case 'instructor':
                    header("Location: public/instructor.php");
                    break;
                case 'aprendiz':
                    header("Location: public/aprendiz.php");
                    break;
                default:
                    // Redirigir a una página de error o acceso denegado
                    header("Location: acceso_denegado.php");
                    break;
            }
            exit();
        } else {
            // Si las credenciales son incorrectas
            echo "<p class='text-red-500'>Usuario o contraseña incorrectos.</p>";
        }
    } catch (PDOException $e) {
        echo "Error: " . $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Inicio de Sesión</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.2/css/all.min.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css">
</head>

<body class="bg-gray-100 h-screen flex items-center justify-center">
    <div class="bg-white p-8 rounded-lg shadow-md w-96">
        <h2 class="text-center text-2xl font-semibold text-gray-700 mb-6">Acceso al Sistema</h2>
        <form method="POST" action="index.php">
            <div class="mb-4">
                <label for="username" class="block text-sm font-medium text-gray-600">Usuario:</label>
                <input type="text" class="w-full p-3 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name="username" required><br>
            </div>
            
            <div class="mb-4">
                <label for="password" class="block text-sm font-medium text-gray-600">Contraseña:</label>
                <div class="relative">
                    <input type="password" class="w-full p-3 mt-1 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-400" name="password" required><br>
                </div>
            </div>
            
            <button type="submit" class="w-full py-3 bg-green-500 text-white rounded-lg hover:bg-green-600 focus:outline-none focus:ring-2 focus:ring-green-400">Acceder</button>
        </form>
    </div>
</body>

</html>