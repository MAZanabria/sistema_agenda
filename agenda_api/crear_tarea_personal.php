<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"));
$titulo = $data->titulo;
$descripcion = $data->descripcion;
$fecha = $data->fecha;
$id_usuario = intval($data->id_usuario);

$sql = "INSERT INTO tarea_personal (titulo, descripcion, fecha, id_usuario) 
        VALUES (?, ?, ?, ?)";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("sssi", $titulo, $descripcion, $fecha, $id_usuario);
$stmt->execute();

//echo json_encode(["success" => true]);

if ($stmt->execute()) {
        echo json_encode(["success" => true]);
    } else {
        echo json_encode(["success" => false, "error" => $stmt->error]);
    }
    