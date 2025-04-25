<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['nombre_tema'], $data['estado'], $data['id_materia'])) {
    $nombre_tema = $data['nombre_tema'];
    $estado = $data['estado'];
    $id_materia = intval($data['id_materia']);

    $stmt = $conexion->prepare("INSERT INTO tema (nombre_tema, estado, id_materia) VALUES (?, ?, ?)");
    $stmt->bind_param("ssi", $nombre_tema, $estado, $id_materia);

    if ($stmt->execute()) {
        echo json_encode(["estado" => "ok", "id_tema" => $conexion->insert_id]);
    } else {
        echo json_encode(["estado" => "error", "mensaje" => $stmt->error]);
    }
} else {
    echo json_encode(["estado" => "error", "mensaje" => "Faltan campos obligatorios"]);
}
?>
