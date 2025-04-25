<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

// Asegúrate de que los datos existan
if (isset($data['id_tema'], $data['nombre_tema'], $data['estado'], $data['id_materia'])) {
    $id_tema = $data['id_tema'];
    $nombre_tema = $data['nombre_tema'];
    $estado = $data['estado'];
    $id_materia = $data['id_materia'];

$sql = "UPDATE tema SET nombre_tema = ?, estado = ? WHERE id_tema = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("ssi", $nombre_tema, $estado, $id_tema);

if ($stmt->execute()) {
    echo json_encode(["estado" => "ok"]);
} else {
    echo json_encode(["estado" => "error", "mensaje" => $conexion->error]);
}
} else {
echo json_encode(["estado" => "error", "mensaje" => "Faltan datos en la solicitud"]);
}
?>
