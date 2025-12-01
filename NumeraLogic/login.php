<?php
session_start();
include 'conexion.php';

// Procesar el formulario cuando se envía
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $matricula = trim($_POST['matricula']);
    $contrasena = trim($_POST['contrasena']);
    
    // Validar campos vacíos
    if (empty($matricula) || empty($contrasena)) {
        $error = "Por favor, completa todos los campos";
    } else {
        // Buscar usuario en la base de datos
        $stmt = $conexion->prepare("SELECT id, nombre, matricula, contrasena FROM usuarios WHERE matricula = ?");
        $stmt->bind_param("s", $matricula);
        $stmt->execute();
        $result = $stmt->get_result();
        
        if ($result->num_rows === 1) {
            $usuario = $result->fetch_assoc();
            
            // Verificar contraseña (en texto plano para el ejemplo)
            if ($contrasena === $usuario['contrasena']) {
                // Iniciar sesión
                $_SESSION['usuario_id'] = $usuario['id'];
                $_SESSION['nombre'] = $usuario['nombre'];
                $_SESSION['matricula'] = $usuario['matricula'];
                
                // Redirigir al dashboard
                header("Location: dashboard.php");
                exit();
            } else {
                $error = "Contraseña incorrecta";
            }
        } else {
            $error = "Usuario no encontrado";
        }
        $stmt->close();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Iniciar sesión - NumeraLogic</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/inicio.css">
</head>
<body>
  <header>
    <div class="brand">
      <a href="index.php" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit;">
        <div class="logo">
          <img src="imagenes/logo.jpg" alt="Logo" style="width: 100%; height: 100%; border-radius: 50%;">
        </div>
        <h2>NumeraLogic</h2>
      </a>
    </div>
  </header>

  <main>
    <div class="login-card">
      <h1>BIENVENIDO NUMERAL LOGIC</h1>
      <h2>Iniciar sesión</h2>
      
      <?php if (isset($error)): ?>
        <div class="error-message">
          <?php echo $error; ?>
        </div>
      <?php endif; ?>
      
      <form id="loginForm" method="POST" action="">
        <div class="form-group">
          <label for="matricula">matrícula</label>
          <input type="text" id="matricula" name="matricula" value="00" required>
        </div>
        
        <div class="form-group password-group">
          <label for="contrasena">contraseña</label>
          <div class="password-wrapper">
            <input type="password" id="contrasena" name="contrasena" value="123" required>
            <button type="button" class="toggle-password" onclick="togglePassword()">
              <span class="eye-icon">👁️</span>
            </button>
          </div>
        </div>
        
        <div class="button-group">
          <button type="submit">Iniciar Sesión</button>
        </div>
      </form>

      <div class="demo-info">
        <p><strong>Credenciales de prueba:</strong></p>
        <p>Matrícula: <strong>00</strong> | Contraseña: <strong>123</strong></p>
      </div>
    </div>
  </main>

  <script>
    function togglePassword() {
      const passwordInput = document.getElementById('contrasena');
      const eyeIcon = document.querySelector('.eye-icon');
      
      if (passwordInput.type === 'password') {
        passwordInput.type = 'text';
        eyeIcon.textContent = '🙈';
      } else {
        passwordInput.type = 'password';
        eyeIcon.textContent = '👁️';
      }
    }

    // Validación básica del formulario
    document.getElementById('loginForm').addEventListener('submit', function(e) {
      const matricula = document.getElementById('matricula').value.trim();
      const contrasena = document.getElementById('contrasena').value.trim();
      
      if (!matricula || !contrasena) {
        e.preventDefault();
        alert('Por favor, completa todos los campos');
        return false;
      }
    });
  </script>
</body>
</html>