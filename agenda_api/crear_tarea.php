<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

if (isset($data['titulo'], $data['descripcion'], $data['fecha'], $data['id_tema'], $data['id_tipo'])) {
    $titulo = $data['titulo'];
    $descripcion = $data['descripcion'];
    $fecha = $data['fecha'];
    $id_tema = intval($data['id_tema']);
    $id_tipo = $data['id_tipo'];

    $stmt = $conexion->prepare("INSERT INTO tarea (titulo, descripcion, fecha, id_tema, id_tipo) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("sssii", $titulo, $descripcion, $fecha, $id_tema, $id_tipo); // ← Corrección de tipos

    if ($stmt->execute()) {
        echo json_encode(["estado" => "ok", "id_tema" => $conexion->insert_id]);
    } else {
        echo json_encode(["estado" => "error", "mensaje" => $stmt->error]);
    }
} else {
    echo json_encode(["estado" => "error", "mensaje" => "Faltan campos obligatorios"]);
}
?>