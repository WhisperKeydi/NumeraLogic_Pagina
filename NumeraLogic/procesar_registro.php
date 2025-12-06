<?php
session_start();
require_once 'conexion.php';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $matricula = trim($_POST['matricula'] ?? '');
    $nombre = trim($_POST['nombre'] ?? '');
    $email = trim($_POST['email'] ?? '');
    $contrasena = trim($_POST['contrasena'] ?? '');
    $confirmar_contrasena = trim($_POST['confirmar_contrasena'] ?? '');
    
    // Validaciones básicas
    if (empty($matricula) || empty($nombre) || empty($email) || empty($contrasena) || empty($confirmar_contrasena)) {
        $_SESSION['error_registro'] = 'Todos los campos son obligatorios.';
        header('Location: registro.php');
        exit();
    }
    
    if ($contrasena !== $confirmar_contrasena) {
        $_SESSION['error_registro'] = 'Las contraseñas no coinciden.';
        header('Location: registro.php');
        exit();
    }
    
    if (strlen($contrasena) < 6) {
        $_SESSION['error_registro'] = 'La contraseña debe tener al menos 6 caracteres.';
        header('Location: registro.php');
        exit();
    }
    
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $_SESSION['error_registro'] = 'Por favor, ingresa un correo electrónico válido.';
        header('Location: registro.php');
        exit();
    }
    
    // Verificar si la matrícula ya existe
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE matricula = ?");
    $stmt->bind_param("s", $matricula);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error_registro'] = 'La matrícula ya está registrada.';
        header('Location: registro.php');
        exit();
    }
    
    // Verificar si el email ya existe
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
    $stmt->bind_param("s", $email);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        $_SESSION['error_registro'] = 'El correo electrónico ya está registrado.';
        header('Location: registro.php');
        exit();
    }
    
    // Crear hash de la contraseña - ¡ESTO ES CORRECTO!
    $contrasena_hash = password_hash($contrasena, PASSWORD_DEFAULT);
    
    // Insertar nuevo usuario
    $stmt = $conexion->prepare("INSERT INTO usuarios (matricula, nombre, email, contrasena) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss", $matricula, $nombre, $email, $contrasena_hash);
    
    if ($stmt->execute()) {
        $nuevo_id = $stmt->insert_id;
        
        // Crear registro en usuario_estadisticas
        $stmt2 = $conexion->prepare("INSERT INTO usuario_estadisticas (usuario_id) VALUES (?)");
        $stmt2->bind_param("i", $nuevo_id);
        $stmt2->execute();
        
        // Crear registro en usuario_rachas
        $stmt3 = $conexion->prepare("INSERT INTO usuario_rachas (usuario_id) VALUES (?)");
        $stmt3->bind_param("i", $nuevo_id);
        $stmt3->execute();
        
        $mensaje_exito = '
        <div style="text-align: center; padding: 15px;">
            <h3 style="color: #16a34a; margin-bottom: 10px;">✅ ¡REGISTRO EXITOSO!</h3>
            <p>Tu cuenta ha sido creada correctamente.</p>
            <p><strong>Matrícula:</strong> ' . htmlspecialchars($matricula) . '</p>
            <p><strong>Nombre:</strong> ' . htmlspecialchars($nombre) . '</p>
            <p>Ya puedes iniciar sesión con tu matrícula y contraseña.</p>
            <div style="margin-top: 20px;">
                <a href="login.php" style="display: inline-block; padding: 10px 20px; background: linear-gradient(135deg, #1e3c72 0%, #3c78d8 100%); color: white; border-radius: 8px; text-decoration: none; font-weight: bold;">
                    Iniciar sesión ahora
                </a>
            </div>
        </div>';
        
        $_SESSION['exito_registro'] = $mensaje_exito;
        header('Location: registro.php');
        exit();
    } else {
        $_SESSION['error_registro'] = 'Error al registrar el usuario. Por favor, intenta nuevamente.';
        header('Location: registro.php');
        exit();
    }
} else {
    header('Location: registro.php');
    exit();
}
?>