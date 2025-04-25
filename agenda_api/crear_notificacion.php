<?php
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"));

$mensaje = $data->mensaje;
$descripcion = $data->descripcion;
$fecha = $data->fecha;
$id_usuario = $data->id_usuario;

$sql = "INSERT INTO notificacion (mensaje, descripcion, fecha, leido, id_usuario)
        VALUES (?, ?, ?, 0, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssi", $mensaje, $descripcion, $fecha, $id_usuario);

if ($stmt->execute()) {
    echo json_encode(["estado" => "ok"]);
} else {
    echo json_encode(["estado" => "error", "mensaje" => $conexion->error]);
}
?>
