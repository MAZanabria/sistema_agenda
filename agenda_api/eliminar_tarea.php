<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
//$id_tema = $data->id_tema;

$sql = "DELETE FROM tarea WHERE id_tarea = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_tarea);

if (isset($data['id_tarea'])) {
    $id_tarea = intval($data['id_tarea']);

    $stmt = $conexion->prepare("DELETE FROM tarea WHERE id_tarea = ?");
    $stmt->bind_param("i", $id_tarea);

    if ($stmt->execute()) {
        echo json_encode(["estado" => "ok"]);
    } else {
        echo json_encode(["estado" => "error", "mensaje" => $stmt->error]);
    }
} else {
    echo json_encode(["estado" => "error", "mensaje" => "No se recibió el ID del tema"]);
}
