<?php
include 'conexion.php';

$id_materia = $_GET['id_materia'];

$sql = "SELECT * FROM tema WHERE id_materia = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_materia);
$stmt->execute();
$resultado = $stmt->get_result();

$temas = [];
while ($fila = $resultado->fetch_assoc()) {
    $temas[] = $fila;
}
echo json_encode($temas);
?>
