<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
include 'conexion.php';

$data = json_decode(file_get_contents("php://input"), true);

$idTarea = $data['id_tarea_personal'] ?? null;

if ($idTarea) {
    $stmt = $conexion->prepare("DELETE FROM tarea_personal WHERE id_tarea_personal = ?");
    $stmt->bind_param("i", $idTarea);
    
    if ($stmt->execute()) {
        echo json_encode(["estado" => "ok", "mensaje" => "Tarea eliminada"]);
    } else {
        echo json_encode(["estado" => "error", "mensaje" => "Error al eliminar tarea"]);
    }
} else {
    echo json_encode(["estado" => "error", "mensaje" => "ID de tarea no proporcionado"]);
}
?>
