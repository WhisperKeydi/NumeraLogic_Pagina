<?php
session_start();
require_once 'conexion.php';

$mensaje = '';
$tipo_mensaje = ''; // 'success' o 'error'

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $email = $_POST['email'] ?? '';
    
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $mensaje = 'Por favor, ingresa un correo electrónico válido.';
        $tipo_mensaje = 'error';
    } else {
        // Verificar si el email existe en la base de datos
        $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE email = ?");
        $stmt->bind_param("s", $email);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows > 0) {
            // Generar token y guardar en la tabla password_reset_tokens
            $token = bin2hex(random_bytes(32));
            $usuario = $result->fetch_assoc();
            $usuario_id = $usuario['id'];
            $expiracion = date('Y-m-d H:i:s', strtotime('+1 hour'));
            
            $stmt = $conexion->prepare("INSERT INTO password_reset_tokens (usuario_id, token, expiracion) VALUES (?, ?, ?)");
            $stmt->bind_param("iss", $usuario_id, $token, $expiracion);
            
            if ($stmt->execute()) {
                // Construir URL completa
                $url = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] === 'on' ? "https" : "http") . "://$_SERVER[HTTP_HOST]$_SERVER[REQUEST_URI]";
                $base_url = dirname($url) . '/reset_contrasena.php';
                $reset_url = $base_url . '?token=' . $token;
                
                $mensaje = 'Se ha enviado un enlace de recuperación a tu correo electrónico. <br><br>';
                $mensaje .= '<strong>Para demostración:</strong> <a href="reset_contrasena.php?token=' . $token . '">Haz clic aquí para restablecer tu contraseña</a><br><br>';
                $mensaje .= 'Enlace completo: <small>' . htmlspecialchars($reset_url) . '</small>';
                $tipo_mensaje = 'success';
            } else {
                $mensaje = 'Error al generar el token. Intenta nuevamente.';
                $tipo_mensaje = 'error';
            }
        } else {
            $mensaje = 'No existe una cuenta asociada a ese correo electrónico.';
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
  <title>Recuperar contraseña - NumeraLogic</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/olvide_contrasena.css">
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
    <div class="recovery-card">
      <h1>NumeraLogic</h1>
      <h2>Recuperar contraseña</h2>
      
      <p>Ingresa tu correo electrónico y te enviaremos un enlace para restablecer tu contraseña.</p>
      
      <?php if ($mensaje): ?>
        <div class="message <?php echo $tipo_mensaje; ?>">
          <?php echo $mensaje; ?>
        </div>
      <?php endif; ?>
      
      <form id="recoveryForm" method="POST" action="">
        <div class="form-group">
          <label for="email">Correo electrónico</label>
          <input type="email" id="email" name="email" required placeholder="ejemplo@correo.com">
        </div>
        
        <div class="button-group">
          <button type="submit">Enviar enlace de recuperación</button>
        </div>
      </form>
      
      <div class="back-link">
        <a href="login.php">← Volver al inicio de sesión</a>
      </div>
    </div>
  </main>

  <script>
    // Validación básica del formulario
    document.getElementById('recoveryForm').addEventListener('submit', function(e) {
      const email = document.getElementById('email').value.trim();
      
      if (!email || !email.includes('@')) {
        e.preventDefault();
        alert('Por favor, ingresa un correo electrónico válido.');
        return false;
      }
    });
  </script>
</body>
</html>