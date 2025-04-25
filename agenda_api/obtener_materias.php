<?php
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Methods: GET, POST, OPTIONS");
header("Access-Control-Allow-Headers: Content-Type, Authorization");
header("Content-Type: application/json");
include("conexion.php");

$id_docente = $_GET['id_docente'] ?? null;

if ($id_docente) {
    $stmt = $conn->prepare("SELECT nombre_materia, codigo_matriculacion FROM materia WHERE id_usuario = ?");
    $stmt->bind_param("i", $id_docente);
    $stmt->execute();
    $result = $stmt->get_result();

    $materias = [];
    while ($row = $result->fetch_assoc()) {
        $materias[] = $row;
    }

    echo json_encode(["success" => true, "materias" => $materias]);
} else {
    echo json_encode(["success" => false, "message" => "Falta el id_docente"]);
}
?>
