<?php
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

include 'conexion.php';

$id_materia = $_GET['id_materia'] ?? null;

if (!$id_materia) {
    echo json_encode(["success" => false, "message" => "ID de materia faltante"]);
    exit;
}

// Consulta con tabla estudiante_materia
$sql = "SELECT u.id_usuario, u.nombre_usuario AS nombre, u.rol
        FROM usuario u
        INNER JOIN estudiante_materia em ON u.id_usuario = em.id_usuario
        WHERE em.id_materia = ?";

$stmt = $conexion->prepare($sql);
if (!$stmt) {
    echo json_encode(["success" => false, "message" => "Error al preparar la consulta: " . $conexion->error]);
    exit;
}

$stmt->bind_param("i", $id_materia);
$stmt->execute();
$result = $stmt->get_result();

$estudiantes = [];

while ($row = $result->fetch_assoc()) {
    $estudiantes[] = $row;
}

echo json_encode(["success" => true, "estudiantes" => $estudiantes]);

$stmt->close();
$conexion->close();
?>
