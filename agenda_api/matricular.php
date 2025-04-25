<?php  
header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");
header("Access-Control-Allow-Headers: *");
include 'conexion.php';

$input = json_decode(file_get_contents("php://input"));
file_put_contents("debug_matricula.txt", print_r($input, true));


if (!isset($input->id_usuario) || !isset($input->codigo_matriculacion)) {
    echo json_encode(["success" => false, "message" => "Faltan datos"]);
    exit;
}

$id_usuario = intval($input->id_usuario);
$codigo_matriculacion = $conexion->real_escape_string($input->codigo_matriculacion);

$sql = "SELECT id_materia FROM materia WHERE codigo_matriculacion = '$codigo_matriculacion'";
$resultado = $conexion->query($sql);


if (!$resultado || $resultado->num_rows == 0) {
    echo json_encode(["success" => false, "message" => "Código de materia no válido"]);
    exit;
}

$id_materia = $resultado->fetch_assoc()['id_materia'];

// Verificar si ya está inscrito
$verificar = $conexion->query("SELECT * FROM estudiante_materia WHERE id_usuario = $id_usuario AND id_materia = $id_materia");

if ($verificar && $verificar->num_rows > 0) {
    echo json_encode(["success" => false, "message" => "Ya estás inscrito en esta materia"]);
    exit;
}

// Insertar la inscripción
$insertar = $conexion->query("INSERT INTO estudiante_materia (id_usuario, id_materia) VALUES ($id_usuario, $id_materia)");

if ($insertar) {
    echo json_encode(["success" => true, "message" => "Inscripción exitosa"]);
} else {
    echo json_encode(["success" => false, "message" => "Error al guardar la inscripción"]);
}
?>
