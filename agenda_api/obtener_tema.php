<?php
include 'conexion.php';

$id_materia = $_GET['id_materia'];

$sql = "SELECT * FROM tema WHERE id_materia = ?";
$stmt = $conexion->prepare($sql);
$stmt->bind_param("i", $id_materia);
$stmt->execute();
$result = $stmt->get_result();

$temas = [];
while ($row = $result->fetch_assoc()) {
    $temas[] = $row;
}

echo json_encode(["temas" => $temas]);
?>
