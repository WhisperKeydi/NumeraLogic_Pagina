<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Crear cuenta - NumeraLogic</title>
  <link href="https://fonts.googleapis.com/css2?family=Roboto:wght@400;500;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/crear_cuenta.css">
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

      <form id="signupForm" method="POST" action="procesar_registro.php" onsubmit="return validarContrasena()">
        <div class="form-group">
          <label for="matricula">matrícula</label>
          <input type="text" id="matricula" name="matricula" required>
        </div>

        <div class="form-group">
          <label for="contrasena">contraseña</label>
          <input type="password" id="contrasena" name="contrasena" required>
        </div>

        <div class="form-group">
          <label for="confirmar_contrasena">confirmar contraseña</label>
          <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" required>
          <small id="mensajeContrasena" class="mensaje-error"></small>
        </div>

        <div class="form-group">
          <label for="nombre">nombre completo</label>
          <input type="text" id="nombre" name="nombre" required>
        </div>

        <div class="button-group">
          <button type="submit">Crear Cuenta</button>
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
      } else {
        mensaje.textContent = '';
        return true;
      }
    }
    
    // Validación en tiempo real
    document.getElementById('confirmar_contrasena').addEventListener('input', function() {
      validarContrasena();
    });
  </script>
</body>
</html>