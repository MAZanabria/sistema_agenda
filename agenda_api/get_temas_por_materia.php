<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
include 'conexion.php';

$id_materia = $_GET['id_materia'];

$query = "SELECT * FROM temas WHERE id_materia='$id_materia'";
$result = mysqli_query($conexion, $query);

$temas = array();
while ($row = mysqli_fetch_assoc($result)) {
    $temas[] = $row;
}

echo json_encode($temas);
?>
