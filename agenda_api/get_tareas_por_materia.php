<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
include 'conexion.php';

$id_materia = $_GET['id_materia'];

$sql = "SELECT tarea.id_tarea, titulo, descripcion, fecha, tipo.tipo 
        FROM tarea
        JOIN tema ON tarea.id_tema = tema.id_tema
        JOIN tipo ON tarea.id_tipo = tipo.id_tipo
        WHERE tema.id_materia = ?";
        
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_materia);
$stmt->execute();
$resultado = $stmt->get_result();

$tareas = [];

while ($fila = $resultado->fetch_assoc()) {
    $tareas[] = $fila;
}

echo json_encode($tareas);
?>
