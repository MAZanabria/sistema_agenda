<?
header("Access-Control-Allow-Origin: *");
header("Access-Control-Allow-Headers: *");
header("Content-Type: application/json");
include 'conexion.php';

$id_docente = $_GET['id_docente'];

$query = "SELECT * FROM materias WHERE id_docente='$id_docente'";
$result = mysqli_query($conexion, $query);

$materias = array();
while ($row = mysqli_fetch_assoc($result)) {
    $materias[] = $row;
}

echo json_encode($materias);
?>
