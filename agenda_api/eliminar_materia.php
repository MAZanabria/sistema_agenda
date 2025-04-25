<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
include 'conexion.php';

$id_materia = $_POST['id_materia'];

$query = "DELETE FROM materias WHERE id_materia='$id_materia'";
$result = mysqli_query($conexion, $query);

if ($result) {
    echo json_encode(["success" => true]);
} else {
    echo json_encode(["success" => false, "error" => mysqli_error($conexion)]);
}
?>
