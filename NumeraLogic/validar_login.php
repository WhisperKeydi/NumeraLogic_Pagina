<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = trim($_POST['matricula'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');
    
    // Buscar usuario por matrícula
    $stmt = $conexion->prepare("SELECT id, matricula, contrasena, nombre FROM usuarios WHERE matricula = ?");
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $usuario = $result->fetch_assoc();
        
        // VERIFICAR CONTRASEÑA HASHEADA usando password_verify()
        if (password_verify($contrasena, $usuario['contrasena'])) {
            // Contraseña correcta
            $_SESSION['usuario_id'] = $usuario['id'];
            $_SESSION['matricula'] = $usuario['matricula'];
            $_SESSION['nombre'] = $usuario['nombre'];
            
            // Redirigir al DASHBOARD
            header('Location: dashboard.php');
            exit();
        } else {
            // Contraseña incorrecta
            $_SESSION['error'] = 'Matrícula o contraseña incorrectos.';
            header('Location: login.php');
            exit();
        }
    } else {
        // Usuario no encontrado
        $_SESSION['error'] = 'Matrícula o contraseña incorrectos.';
        header('Location: login.php');
        exit();
    }
} else {
    header('Location: login.php');
    exit();
}
?>