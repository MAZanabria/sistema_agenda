<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);
//$id_tema = $data->id_tema;

$sql = "DELETE FROM tema WHERE id_tema = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_tema);

if (isset($data['id_tema'])) {
    $id_tema = intval($data['id_tema']);

    $stmt = $conexion->prepare("DELETE FROM tema WHERE id_tema = ?");
    $stmt->bind_param("i", $id_tema);

    if ($stmt->execute()) {
        echo json_encode(["estado" => "ok"]);
    } else {
        echo json_encode(["estado" => "error", "mensaje" => $stmt->error]);
    }
} else {
    echo json_encode(["estado" => "error", "mensaje" => "No se recibió el ID del tema"]);
}
