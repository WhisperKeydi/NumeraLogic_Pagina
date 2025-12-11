<?php
session_start();
include 'conexion.php';

if ($_POST) {
    $matricula = $conexion->real_escape_string($_POST['matricula']);
    $contrasena = $_POST['contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];
    $nombre = isset($_POST['nombre']) ? $conexion->real_escape_string($_POST['nombre']) : 'Estudiante';
    
    // Verificar que las contraseñas coincidan
    if ($contrasena !== $confirmar_contrasena) {
        echo "<script>
            alert('Las contraseñas no coinciden');
            window.location.href = 'registro.php';
        </script>";
        exit();
    }
    
    // Verificar si la matrícula ya existe
    $verificar = "SELECT id FROM usuarios WHERE matricula = '$matricula'";
    $resultado = $conexion->query($verificar);
    
    if ($resultado->num_rows > 0) {
        echo "<script>
            alert('La matrícula ya está registrada');
            window.location.href = 'registro.php';
        </script>";
    } else {
        // Insertar nuevo usuario
        $sql = "INSERT INTO usuarios (matricula, contrasena, nombre) 
                VALUES ('$matricula', '$contrasena', '$nombre')";
        
        if ($conexion->query($sql)) {
            // Obtener el ID del usuario recién creado
            $usuario_id = $conexion->insert_id;
            
            // Iniciar sesión automáticamente
            $_SESSION['usuario_id'] = $usuario_id;
            $_SESSION['matricula'] = $matricula;
            $_SESSION['nombre'] = $nombre;
            
            echo "<script>
                alert('Cuenta creada exitosamente');
                window.location.href = 'dashboard.php';
            </script>";
        } else {
            echo "<script>
                alert('Error al crear la cuenta: " . $conexion->error . "');
                window.history.back();
            </script>";
        }
    }
} else {
    header("Location: registro.php");
    exit();
}

$conexion->close();
?>