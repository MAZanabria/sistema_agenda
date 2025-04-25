<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
include 'conexion.php';

$input = json_decode(file_get_contents("php://input"));
$id_usuario = intval($input->id_usuario);

$sql = "SELECT * FROM tarea_personal WHERE id_usuario = $id_usuario ORDER BY fecha ASC";
$result = $conexion->query($sql);

$tareas = [];
while ($row = $result->fetch_assoc()) {
    $tareas[] = $row;
}

echo json_encode(["tareas" => $tareas]);
