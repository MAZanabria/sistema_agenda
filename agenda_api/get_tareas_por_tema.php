<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
include 'conexion.php';

$id_tema = $_GET['id_tema'];

$query = "SELECT * FROM tareas WHERE id_tema='$id_tema'";
$result = mysqli_query($conexion, $query);

$tareas = array();
while ($row = mysqli_fetch_assoc($result)) {
    $tareas[] = $row;
}

echo json_encode($tareas);
?>
