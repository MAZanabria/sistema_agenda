<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

// Mostrar errores
error_reporting(E_ALL);
ini_set('display_errors', 1);

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "db_agenda");

if ($conexion->connect_error) {
    die(json_encode(["success" => false, "message" => "Error de conexión: " . $conexion->connect_error]));
}

// Leer los datos enviados por Flutter
$input = file_get_contents("php://input");
$data = json_decode($input);

// Verificar que se recibieron todos los datos
if (!$data || !isset($data->usuario) || !isset($data->contrasenia) || !isset($data->rol)) {
    echo json_encode([
        "success" => false,
        "message" => "Faltan datos para el registro"
    ]);
    exit;
}

// Escapar y preparar los datos
$usuario = $conexion->real_escape_string($data->usuario);
$contrasenia = $conexion->real_escape_string($data->contrasenia);
$rol = $conexion->real_escape_string($data->rol);

// Verificar si el usuario ya existe
$verificar = $conexion->query("SELECT * FROM usuario WHERE nombre_usuario = '$usuario'");
if ($verificar && $verificar->num_rows > 0) {
    echo json_encode([
        "success" => false,
        "message" => "El nombre de usuario ya existe"
    ]);
    exit;
}

// Insertar el nuevo usuario
$sql = "INSERT INTO usuario (nombre_usuario, contrasenia, rol) VALUES ('$usuario', '$contrasenia', '$rol')";
if ($conexion->query($sql)) {
    echo json_encode([
        "success" => true,
        "message" => "Usuario registrado correctamente"
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Error al registrar: " . $conexion->error
    ]);
}
?>
