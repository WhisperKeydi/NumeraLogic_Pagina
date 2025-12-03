<?php
session_start();
$error = '';
if (isset($_SESSION['error'])) {
    $error = $_SESSION['error'];
    unset($_SESSION['error']); // Limpiar el error después de mostrarlo
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
      
     <?php if (!empty($error)): ?>
        <div class="error-message">
          <?php echo htmlspecialchars($error); ?>
        </div>
      <?php endif; ?>
      
      <form id="loginForm" method="POST" action="validar_login.php">
        <div class="form-group">
          <label for="matricula">Matrícula</label>
          <input type="text" id="matricula" name="matricula" autocomplete="off" required>
        </div>
        
        <div class="form-group password-group">
          <label for="contrasena">Contraseña</label>
          <div class="password-wrapper">
            <input type="password" id="contrasena" name="contrasena" autocomplete="off" required>
            <button type="button" class="toggle-password" onclick="togglePassword()">
              <span class="eye-icon">👁️</span>
            </button>
          </div>
        </div>
        
        <div class="button-group">
          <button type="submit">Iniciar Sesión</button>
        </div>
      </form>
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