<?php
session_start();
include 'conexion.php';

if ($_POST) {
    $matricula = $conexion->real_escape_string($_POST['matricula']);
    $contrasena = $_POST['contrasena'];
    
    $sql = "SELECT * FROM usuarios WHERE matricula = '$matricula' AND contrasena = '$contrasena'";
    $resultado = $conexion->query($sql);
    
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        $_SESSION['usuario_id'] = $usuario['id'];
        $_SESSION['matricula'] = $usuario['matricula'];
        $_SESSION['nombre'] = $usuario['nombre'];
        
        header("Location: dashboard.php");
        exit();
    } else {
        echo "<script>
            alert('Matrícula o contraseña incorrectos');
            window.location.href = 'login.php';
        </script>";
    }
} else {
    header("Location: login.php");
    exit();
}

$conexion->close();
?>