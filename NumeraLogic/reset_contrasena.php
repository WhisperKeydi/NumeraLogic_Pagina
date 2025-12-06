<?php
session_start();
require_once 'conexion.php';

$mensaje = '';
$tipo_mensaje = ''; // 'success' o 'error'
$token_valido = false;
$usuario_id = null;
$usuario_info = null;

// Obtener el token de la URL
$token = $_GET['token'] ?? '';

if (!empty($token)) {
    // Buscar el token en la base de datos
    $stmt = $conexion->prepare("
        SELECT prt.usuario_id, u.nombre, u.email, prt.expiracion 
        FROM password_reset_tokens prt
        INNER JOIN usuarios u ON prt.usuario_id = u.id
        WHERE prt.token = ? AND prt.usado = 0 AND prt.expiracion > NOW()
    ");
    $stmt->bind_param("s", $token);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows === 1) {
        $token_data = $result->fetch_assoc();
        $usuario_id = $token_data['usuario_id'];
        $usuario_info = [
            'nombre' => $token_data['nombre'],
            'email' => $token_data['email']
        ];
        $token_valido = true;
        
        // Mensaje de éxito
        $mensaje = '<strong>✅ ENLACE DE RECUPERACIÓN VÁLIDO</strong><br><br>';
        $mensaje .= '¡Perfecto! Hemos verificado tu identidad.<br>';
        $mensaje .= 'Cuenta asociada: <strong>' . htmlspecialchars($usuario_info['email']) . '</strong><br>';
        $mensaje .= 'Ahora puedes crear una nueva contraseña.';
        $tipo_mensaje = 'success';
    } else {
        $mensaje = 'El enlace de recuperación no es válido, ha expirado o ya fue usado.';
        $tipo_mensaje = 'error';
        $token_valido = false;
    }
} else {
    $mensaje = 'Enlace de recuperación no válido. Por favor, solicita un nuevo enlace.';
    $tipo_mensaje = 'error';
}

// Procesar el cambio de contraseña
if ($_SERVER['REQUEST_METHOD'] === 'POST' && $token_valido && $usuario_id) {
    $nueva_contrasena = $_POST['nueva_contrasena'] ?? '';
    $confirmar_contrasena = $_POST['confirmar_contrasena'] ?? '';

    if (empty($nueva_contrasena) || empty($confirmar_contrasena)) {
        $mensaje = 'Por favor, completa ambos campos.';
        $tipo_mensaje = 'error';
    } elseif ($nueva_contrasena !== $confirmar_contrasena) {
        $mensaje = 'Las contraseñas no coinciden.';
        $tipo_mensaje = 'error';
    } elseif (strlen($nueva_contrasena) < 6) {
        $mensaje = 'La contraseña debe tener al menos 6 caracteres.';
        $tipo_mensaje = 'error';
    } else {
        // ACTUALIZAR CONTRASEÑA CON HASH en la base de datos
        $contrasena_hash = password_hash($nueva_contrasena, PASSWORD_DEFAULT);
        
        $stmt = $conexion->prepare("UPDATE usuarios SET contrasena = ? WHERE id = ?");
        $stmt->bind_param("si", $contrasena_hash, $usuario_id);
        
        if ($stmt->execute()) {
            // Marcar el token como usado
            $stmt2 = $conexion->prepare("UPDATE password_reset_tokens SET usado = 1 WHERE token = ?");
            $stmt2->bind_param("s", $token);
            $stmt2->execute();
            
            $mensaje = '✅ <strong>¡CONTRASEÑA CAMBIADA EXITOSAMENTE!</strong><br><br>';
            $mensaje .= 'Tu contraseña ha sido actualizada correctamente en la base de datos.<br><br>';
            $mensaje .= 'Puedes iniciar sesión con tu nueva contraseña.<br><br>';
            $mensaje .= '<a href="login.php" style="display: inline-block; padding: 10px 20px; background: linear-gradient(135deg, #1e3c72 0%, #3c78d8 100%); color: white; border-radius: 10px; text-decoration: none; font-weight: bold;">Iniciar sesión con nueva contraseña</a>';
            $tipo_mensaje = 'success';
            $token_valido = false; // Ya no mostrar el formulario
        } else {
            $mensaje = 'Error al actualizar la contraseña. Intenta nuevamente.';
            $tipo_mensaje = 'error';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Restablecer contraseña - NumeraLogic</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/reset_contrasena.css">
</head>
<body>
  <header>
    <div class="brand">
      <a href="index.php" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit;">
        <div class="logo">
          <img src="imagenes/logo.jpg" alt="Logo">
        </div>
        <h2>NumeraLogic</h2>
      </a>
    </div>
  </header>

  <main>
    <div class="reset-card">
      <h1>NumeraLogic</h1>
      <h2>Restablecer contraseña</h2>
      
      <?php if ($mensaje): ?>
        <div class="message <?php echo $tipo_mensaje; ?>">
          <?php echo $mensaje; ?>
        </div>
      <?php endif; ?>
      
      <?php if ($token_valido): ?>
        <form id="resetForm" method="POST" action="">
          <div class="form-group">
            <label for="nueva_contrasena">Nueva contraseña</label>
            <div class="password-wrapper">
              <input type="password" id="nueva_contrasena" name="nueva_contrasena" required 
                     placeholder="Ingresa tu nueva contraseña (mínimo 6 caracteres)">
              <button type="button" class="toggle-password" onclick="togglePassword('nueva_contrasena', this)">
                <span class="eye-icon">👁️</span>
              </button>
            </div>
          </div>
          
          <div class="form-group">
            <label for="confirmar_contrasena">Confirmar nueva contraseña</label>
            <div class="password-wrapper">
              <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required 
                     placeholder="Confirma tu nueva contraseña">
              <button type="button" class="toggle-password" onclick="togglePassword('confirmar_contrasena', this)">
                <span class="eye-icon">👁️</span>
              </button>
            </div>
          </div>
          
          <div class="button-group">
            <button type="submit">Cambiar contraseña</button>
          </div>
        </form>
      <?php endif; ?>
      
      <div class="back-link">
        <a href="login.php">← Volver al inicio de sesión</a>
      </div>
    </div>
  </main>

  <script>
    function togglePassword(inputId, button) {
      const passwordInput = document.getElementById(inputId);
      const eyeIcon = button.querySelector('.eye-icon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.textContent = '🙈';
      } else {
        passwordInput.type = 'password';
        eyeIcon.textContent = '👁️';
      }
    }

    // Validación del formulario
    document.getElementById('resetForm')?.addEventListener('submit', function(e) {
      const nueva = document.getElementById('nueva_contrasena').value;
      const confirmar = document.getElementById('confirmar_contrasena').value;
      
      if (nueva !== confirmar) {
        e.preventDefault();
        alert('Las contraseñas no coinciden. Por favor, verifica.');
        return false;
      }
      
      if (nueva.length < 6) {
        e.preventDefault();
        alert('La contraseña debe tener al menos 6 caracteres.');
        return false;
      }
      
      return confirm('¿Estás seguro de que quieres cambiar tu contraseña?\n\n✅ Podrás iniciar sesión con tu nueva contraseña');
    });
  </script>
</body>
</html>