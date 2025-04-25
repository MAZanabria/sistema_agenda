<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

// Asegúrate de que los datos existan
if (isset($data['id_tarea'], $data['titulo'], $data['descripcion'], $data['fecha'], $data['id_tema'], $data['id_tipo'])) {
    $id_tarea = $data['id_tarea'];
    $titulo = $data['titulo'];
    $descripcion = $data['descripcion'];
    $fecha = $data['fecha'];
    $id_tema = $data['id_tema'];
    $id_tipo = $data['id_tipo'];

$sql = "UPDATE tarea SET titulo = ?, descripcion = ?, fecha = ?, id_tipo = ? WHERE id_tarea = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssii", $titulo, $descripcion, $fecha, $id_tipo, $id_tarea);

if ($stmt->execute()) {
    echo json_encode(["estado" => "ok"]);
} else {
    echo json_encode(["estado" => "error", "mensaje" => $conexion->error]);
}
} else {
echo json_encode(["estado" => "error", "mensaje" => "Faltan datos en la solicitud"]);
}
?>