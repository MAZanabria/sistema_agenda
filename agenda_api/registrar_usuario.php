<?php
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"));

$nombre_usuario = $data->nombre_usuario;
$contrasenia = $data->contrasenia;
$rol = $data->rol;

$sql = "INSERT INTO usuario (nombre_usuario, contrasenia, rol) VALUES (?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sss", $nombre_usuario, $contrasenia, $rol);

if ($stmt->execute()) {
    echo json_encode(["estado" => "ok", "id_usuario" => $conexion->insert_id]);
} else {
    echo json_encode(["estado" => "error", "mensaje" => $conexion->error]);
}
?>
