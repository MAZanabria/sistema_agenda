<?php
// Habilitar errores para depuración (quítalo en producción)
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

// Encabezados
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

// Evitar errores con OPTIONS
if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit;
}

// Leer JSON de entrada
$input = json_decode(file_get_contents("php://input"), true);

// Validar JSON
if (!$input) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "No se recibió un JSON válido"
    ]);
    exit;
}

// Extraer campos
$id_docente       = $input['id_docente']       ?? null;
$nombre_materia   = $input['nombre_materia']   ?? null;
$codigo_matricula = $input['codigo_matriculacion'] ?? null;

// Validar campos
if (!$id_docente || !$nombre_materia || !$codigo_matricula) {
    http_response_code(400);
    echo json_encode([
        "success" => false,
        "message" => "Faltan datos (id_docente, nombre_materia o código)"
    ]);
    exit;
}

// Conectar a la base de datos
$mysqli = new mysqli("localhost", "root", "", "db_agenda");
if ($mysqli->connect_error) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error de conexión: ".$mysqli->connect_error
    ]);
    exit;
}

// Preparar e insertar
$stmt = $mysqli->prepare("
    INSERT INTO materia 
      (nombre_materia, codigo_matriculacion, id_usuario) 
    VALUES (?, ?, ?)
");

if (!$stmt) {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error al preparar consulta: ".$mysqli->error
    ]);
    exit;
}

$stmt->bind_param("ssi", $nombre_materia, $codigo_matricula, $id_docente);

if ($stmt->execute()) {
    http_response_code(200);
    echo json_encode([
        "success" => true,
        "codigo"  => $codigo_matricula
    ]);
} else {
    http_response_code(500);
    echo json_encode([
        "success" => false,
        "message" => "Error al insertar: ".$stmt->error
    ]);
}

$stmt->close();
$mysqli->close();
