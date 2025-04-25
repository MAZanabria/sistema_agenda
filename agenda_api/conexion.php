<?php
$host = "localhost";
$usuario = "root";
$contrasenia = ""; // o "1234" según XAMPP
$base_datos = "db_agenda";

$conexion = new mysqli($host, $usuario, $contrasenia, $base_datos);
if ($conexion->connect_error) {
    die("Error en la conexión: " . $conexion->connect_error);
}
?>
