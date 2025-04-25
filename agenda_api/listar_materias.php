<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include 'conexion.php';

$id_usuario = $_GET['id_usuario'];

$sql = "SELECT m.* FROM materia m
        JOIN estudiante_materia em ON m.id_materia = em.id_materia
        WHERE em.id_usuario = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_usuario);
$stmt->execute();
$resultado = $stmt->get_result();

$materias = [];
while ($fila = $resultado->fetch_assoc()) {
    $materias[] = $fila;
}
echo json_encode($materias);
?>
