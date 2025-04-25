<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json; charset=UTF-8");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Access-Control-Allow-Methods: POST, GET, OPTIONS");

include 'conexion.php';

if (isset($_GET['id_usuario'])) {
    $id_usuario = $_GET['id_usuario'];

    $query = "SELECT id_materia, nombre_materia FROM materia WHERE id_usuario = ?";
    $stmt = $conexion->prepare($query);
    $stmt->bind_param("i", $id_usuario);
    $stmt->execute();
    $result = $stmt->get_result();

    $materias = [];
    while ($row = $result->fetch_assoc()) {
        $materias[] = $row;
    }

    echo json_encode([
        "success" => true,
        "materias" => $materias
    ]);
} else {
    echo json_encode([
        "success" => false,
        "message" => "Falta el parámetro id_usuario"
    ]);
}
?>

