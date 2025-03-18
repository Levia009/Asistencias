<?php
session_start();
require '../config/conexion.php'; // Asegúrate de que este archivo contenga la clase Database

// Obtener la conexión a la base de datos
$database = Database::getInstance();
$pdo = $database->getConnection();

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        // Insertar en Programa de Formación
        if (isset($_POST['nombre']) && isset($_POST['tipo']) && $_POST['tipo'] === 'programa') {
            $nombre = htmlspecialchars($_POST['nombre']); // Sanitizar el nombre
            $stmt = $pdo->prepare("INSERT INTO programa_formacion (nombre) VALUES (:nombre)");
            $stmt->execute(['nombre' => $nombre]);
            echo "Programa de formación creado exitosamente.";
        }

        // Insertar en Ambiente
        if (isset($_POST['nombre']) && isset($_POST['tipo']) && $_POST['tipo'] === 'ambiente') {
            $nombre = htmlspecialchars($_POST['nombre']); // Sanitizar el nombre
            $stmt = $pdo->prepare("INSERT INTO ambiente (nombre) VALUES (:nombre)");
            $stmt->execute(['nombre' => $nombre]);
            echo "Ambiente creado exitosamente.";
        }

        // Insertar en Ficha
        if (isset($_POST['ficha']) && isset($_POST['tipo']) && $_POST['tipo'] === 'ficha') {
            $ficha = htmlspecialchars($_POST['ficha']); // Sanitizar el número de ficha
            $stmt = $pdo->prepare("INSERT INTO fichas (ficha) VALUES (:ficha)");
            $stmt->execute(['ficha' => $ficha]);
            echo "Ficha creada exitosamente.";
        }

        // Insertar un nuevo instructor
        if (isset($_POST['username']) && isset($_POST['password']) && isset($_POST['role'])) {
            $username = htmlspecialchars($_POST['username']); // Sanitizar el nombre de usuario
            $password = password_hash($_POST['password'], PASSWORD_BCRYPT); // Hash de la contraseña
            $role = htmlspecialchars($_POST['role']); // Sanitizar el rol

            $stmt = $pdo->prepare("INSERT INTO instructor (username, password_hash, role) VALUES (:username, :password, :role)");
            $stmt->execute(['username' => $username, 'password' => $password, 'role' => $role]);
            echo "Instructor creado exitosamente.";
        }
  // Insertar un nuevo aprendiz
  if (isset($_POST['nombre']) && isset($_POST['ficha_id']) && isset($_POST['tipo']) && $_POST['tipo'] === 'aprendiz') {
    echo "Datos recibidos: ";
    print_r($_POST); // Depuración: Verifica los datos recibidos
    $nombre = htmlspecialchars($_POST['nombre']);
    $ficha_id = intval($_POST['ficha_id']);

    // Verificar si la ficha existe
    $stmt = $pdo->prepare("SELECT id FROM fichas WHERE id = :ficha_id");
    $stmt->execute(['ficha_id' => $ficha_id]);
    if ($stmt->fetch()) {
        // Insertar el aprendiz
        $stmt = $pdo->prepare("INSERT INTO estudiantes (nombre, ficha_id) VALUES (:nombre, :ficha_id)");
        $stmt->execute(['nombre' => $nombre, 'ficha_id' => $ficha_id]);
        echo "Aprendiz registrado exitosamente.";
    } else {
        echo "Error: La ficha seleccionada no existe.";
    }
}
} catch (PDOException $e) {
echo "Error: " . $e->getMessage(); // Mostrar el error
}
} else {
echo "Método no permitido.";
}
?>