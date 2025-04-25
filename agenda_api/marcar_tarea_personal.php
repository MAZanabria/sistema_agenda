<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"));
$id = intval($data->id_tarea_personal);
$finalizado = $data->finalizado ? 1 : 0;

$sql = "UPDATE tarea_personal SET finalizado = $finalizado WHERE id_tarea_personal = $id";
$conexion->query($sql);

//echo json_encode(["success" => true]);

if ($conexion->query($sql)) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => $conexion->error]);
}
