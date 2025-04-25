<?php
header("Content-Type: application/json");
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");

// Recibir el JSON de entrada
$input = json_decode(file_get_contents("php://input"), true);

$id_docente = $_GET["id_docente"] ?? null;


if (!$id_docente) {
    echo json_encode(["success" => false, "message" => "Falta el id del docente"]);
    exit;
}

// Conectar a la base de datos
$mysqli = new mysqli("localhost", "root", "", "db_agenda");

if ($mysqli->connect_error) {
    echo json_encode(["success" => false, "message" => "Error de conexión"]);
    exit;
}

// Obtener las materias del docente
$stmt = $mysqli->prepare("SELECT id_materia, nombre_materia, codigo_matriculacion FROM materia WHERE id_usuario = ?");
$stmt->bind_param("i", $id_docente);
$stmt->execute();
$result = $stmt->get_result();

$materias = [];

while ($row = $result->fetch_assoc()) {
    $materias[] = $row;
}

echo json_encode([
    "success" => true,
    "materias" => $materias
]);

$stmt->close();
$mysqli->close();
