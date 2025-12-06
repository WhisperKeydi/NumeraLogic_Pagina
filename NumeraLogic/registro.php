<?php 
session_start();
$error = '';
$exito = '';

if (isset($_SESSION['error_registro'])) {
    $error = $_SESSION['error_registro'];
    unset($_SESSION['error_registro']);
}

if (isset($_SESSION['exito_registro'])) {
    $exito = $_SESSION['exito_registro'];
    unset($_SESSION['exito_registro']);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear cuenta - NumeraLogic</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/registro.css">
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
    <div class="signup-card">
      <h1>BIENVENIDO NUMERAL LOGIC</h1>
      <h2>Crear cuenta</h2>

      <?php if ($error): ?>
        <div class="error-message">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>

      <?php if ($exito): ?>
        <div class="success-message">
          <?php echo $exito; ?>
        </div>
      <?php endif; ?>

      <form id="signupForm" method="POST" action="procesar_registro.php">
        <div class="form-group">
          <label for="matricula">Matrícula *</label>
          <input type="text" id="matricula" name="matricula" required>
        </div>

        <div class="form-group">
          <label for="nombre">Nombre completo *</label>
          <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="form-group">
          <label for="email">Correo electrónico *</label>
          <input type="email" id="email" name="email" required placeholder="ejemplo@correo.com">
          <small id="mensajeEmail" class="mensaje-error"></small>
        </div>

        <div class="form-group">
          <label for="contrasena">Contraseña * (mínimo 6 caracteres)</label>
          <div class="password-container">
            <input type="password" id="contrasena" name="contrasena" required>
            <span class="toggle-password" id="toggleContrasena">👁️</span>
          </div>
        </div>

        <div class="form-group">
          <label for="confirmar_contrasena">Confirmar contraseña *</label>
          <div class="password-container">
            <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
            <span class="toggle-password" id="toggleConfirmar">👁️</span>
          </div>
          <small id="mensajeContrasena" class="mensaje-error"></small>
        </div>

        <div class="button-group">
          <button type="submit" onclick="return validarFormulario()">Crear Cuenta</button>
        </div>

        <div class="login-link">
          ¿Ya tienes una cuenta? <a href="login.php">Inicia sesión</a>
        </div>
      </form>
    </div>
  </main>

  <script>
    function validarContrasena() {
      const contrasena = document.getElementById('contrasena').value;
      const confirmar = document.getElementById('confirmar_contrasena').value;
      const mensaje = document.getElementById('mensajeContrasena');
      
      if (contrasena !== confirmar) {
        mensaje.textContent = 'Las contraseñas no coinciden';
        mensaje.style.color = '#dc2626';
        return false;
      } else if (contrasena.length < 6) {
        mensaje.textContent = 'La contraseña debe tener al menos 6 caracteres';
        mensaje.style.color = '#dc2626';
        return false;
      } else {
        mensaje.textContent = '';
        return true;
      }
    }

    function validarEmail() {
      const email = document.getElementById('email').value;
      const mensaje = document.getElementById('mensajeEmail');
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      
      if (!emailRegex.test(email)) {
        mensaje.textContent = 'Por favor, ingresa un correo electrónico válido';
        mensaje.style.color = '#dc2626';
        return false;
      } else {
        mensaje.textContent = '';
        return true;
      }
    }

    function validarFormulario() {
      const matricula = document.getElementById('matricula').value.trim();
      const nombre = document.getElementById('nombre').value.trim();
      const email = document.getElementById('email').value.trim();
      const contrasena = document.getElementById('contrasena').value;
      const confirmar = document.getElementById('confirmar_contrasena').value;
      
      // Validar que todos los campos estén llenos
      if (!matricula || !nombre || !email || !contrasena || !confirmar) {
        alert('Por favor, completa todos los campos obligatorios (*)');
        return false;
      }
      
      // Validar contraseña
      if (contrasena.length < 6) {
        alert('La contraseña debe tener al menos 6 caracteres');
        return false;
      }
      
      if (contrasena !== confirmar) {
        alert('Las contraseñas no coinciden');
        return false;
      }
      
      // Validar email
      const emailRegex = /^[^\s@]+@[^\s@]+\.[^\s@]+$/;
      if (!emailRegex.test(email)) {
        alert('Por favor, ingresa un correo electrónico válido');
        return false;
      }
      
      return true;
    }

    // Función para mostrar/ocultar contraseña
    function setupPasswordToggle(passwordId, toggleId) {
      const passwordInput = document.getElementById(passwordId);
      const toggleButton = document.getElementById(toggleId);

      toggleButton.addEventListener('click', function() {
        if (passwordInput.type === 'password') {
          passwordInput.type = 'text';
          toggleButton.textContent = '🙈';
        } else {
          passwordInput.type = 'password';
          toggleButton.textContent = '👁️';
        }
      });
    }

    // Configurar los toggles para ambos campos de contraseña
    setupPasswordToggle('contrasena', 'toggleContrasena');
    setupPasswordToggle('confirmar_contrasena', 'toggleConfirmar');
    
    // Validación en tiempo real
    document.getElementById('confirmar_contrasena').addEventListener('input', validarContrasena);
    document.getElementById('email').addEventListener('input', validarEmail);
  </script>
</body>
</html>