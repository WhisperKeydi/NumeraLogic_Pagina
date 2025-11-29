<?php
$servidor = "localhost";
$usuario = "root";
$password = ""; // Configura tu contraseña aquí
$base_datos = "numeralogic";

$conexion = mysqli_connect($servidor, $usuario, $password, $base_datos);

if (!$conexion) {
    die("Error de conexión: " . mysqli_connect_error());
}
?>
