<?php 
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$idTarea = $data['id_tarea_personal'] ?? null;
$titulo = $data['titulo'] ?? null;
$descripcion = $data['descripcion'] ?? null;
$fecha = $data['fecha'] ?? null;

if ($idTarea && $titulo && $fecha) {
    $stmt = $conexion->prepare("UPDATE tarea_personal SET titulo = ?, descripcion = ?, fecha = ? WHERE id_tarea_personal = ?");
    $stmt->bind_param("sssi", $titulo, $descripcion, $fecha, $idTarea);
    
    if ($stmt->execute()) {
        echo json_encode(["estado" => "ok", "mensaje" => "Tarea actualizada"]);
    } else {
        echo json_encode(["estado" => "error", "mensaje" => "Error al actualizar tarea"]);
    }
} else {
    echo json_encode(["estado" => "error", "mensaje" => "Datos incompletos"]);
}
?>
