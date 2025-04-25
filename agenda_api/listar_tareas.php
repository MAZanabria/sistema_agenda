<?php
include 'conexion.php';

$id_tema = $_GET['id_tema'];

$sql = "SELECT t.*, tp.tipo FROM tarea t
        JOIN tipo tp ON t.id_tipo = tp.id_tipo
        WHERE t.id_tema = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_tema);
$stmt->execute();
$resultado = $stmt->get_result();

$tareas = [];
while ($fila = $resultado->fetch_assoc()) {
    $tareas[] = $fila;
}
echo json_encode($tareas);
?>
