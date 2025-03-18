<?php
class Database {
    private $host = "localhost"; // Servidor de la base de datos
    private $db_name = "asistencias"; // Nombre de la base de datos
    private $username = "root"; // Usuario de la base de datos
    private $password = ""; // Contraseña de la base de datos
    private static $instance = null; // Única instancia de la conexión
    private $conn; // Conexión PDO

    // Constructor privado para evitar la creación directa de instancias
    private function __construct() {
        try {
            $this->conn = new PDO("mysql:host=" . $this->host . ";dbname=" . $this->db_name, $this->username, $this->password);
            $this->conn->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            $this->conn->exec("set names utf8"); // Configuración de caracteres
        } catch (PDOException $exception) {
            die("Error de conexión: " . $exception->getMessage());
        }
    }

    // Método estático para obtener la única instancia de la clase
    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self(); // Crear la instancia si no existe
        }
        return self::$instance;
    }

    // Método para obtener la conexión
    public function getConnection() {
        return $this->conn;
    }

    // Evitar la clonación del objeto
    private function __clone() {}

    // Evitar la deserialización del objeto
    public function __wakeup() {
        throw new Exception("No puedes deserializar esta clase.");
    }
}

// Uso de la clase Database con Singleton
$database = Database::getInstance(); // Obtener la única instancia
$db = $database->getConnection();

if ($db) {
    echo "Conexión exitosa a la base de datos.";
} else {
    echo "Error al conectar a la base de datos.";
}
?>
