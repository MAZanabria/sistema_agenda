<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
include 'conexion.php';


$input = json_decode(file_get_contents("php://input"));

if (!isset($input->id_usuario)) {
    echo json_encode(["success" => false, "message" => "Falta el ID del estudiante"]);
    exit;
}

$id_usuario = intval($input->id_usuario);

$sql = "SELECT m.id_materia, m.nombre_materia, m.codigo_matriculacion 
        FROM materia m 
        JOIN estudiante_materia em ON em.id_materia = m.id_materia
        WHERE em.id_usuario = $id_usuario";

$result = $conexion->query($sql);

$materias = [];
while ($row = $result->fetch_assoc()) {
    $materias[] = $row;
}

echo json_encode(["success" => true, "materias" => $materias]);
