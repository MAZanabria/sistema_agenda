<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");

include 'conexion.php';

// Desactivar errores visibles (útil para producción)
error_reporting(0);
ini_set('display_errors', 0);

// Conectar a la base de datos
$conexion = new mysqli("localhost", "root", "", "db_agenda");

if ($conexion->connect_error) {
    echo json_encode(["success" => false, "message" => "Error de conexión con la BD"]);
    exit;
}

// Leer el JSON de entrada
$input = file_get_contents("php://input");
$data = json_decode($input);

if (!$data || !isset($data->usuario) || !isset($data->contrasenia)) {
    echo json_encode([
        "success" => false,
        "message" => "No se recibieron datos válidos"
    ]);
    exit;
}

$usuario = $conexion->real_escape_string($data->usuario);
$contrasenia = $conexion->real_escape_string($data->contrasenia);

// Consulta SQL segura
$sql = "SELECT * FROM usuario WHERE nombre_usuario = '$usuario' AND contrasenia = '$contrasenia'";
$resultado = $conexion->query($sql);

// Verificar resultado
if ($resultado && $resultado->num_rows > 0) {
    $fila = $resultado->fetch_assoc();
    echo json_encode([
        "success" => true,
        "message" => "Login correcto",
        "usuario" => [
            "id_usuario" => $fila["id_usuario"],
            "nombre_usuario" => $fila["nombre_usuario"],
            "rol" => $fila["rol"]
        ]
    ]);
} else {
    echo json_encode(["success" => false, "message" => "Credenciales incorrectas"]);
}
?>

