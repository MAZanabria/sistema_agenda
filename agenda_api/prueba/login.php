<?php
include 'conexion.php';

$email = $_POST['email'];
$password = $_POST['password'];

$query = "SELECT * FROM usuarios WHERE email = '$email' AND password = '$password'";
$result = mysqli_query($conexion, $query);

if (mysqli_num_rows($result) > 0) {
    $usuario = mysqli_fetch_assoc($result);
    echo json_encode([
        'success' => true,
        'user_type' => $usuario['tipo_usuario'] // muy importante
    ]);
} else {
    echo json_encode(['success' => false]);
}
?>
