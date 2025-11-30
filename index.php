<?php session_start(); ?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>NumeraLogic - Plataforma de Aprendizaje</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/index.css">
</head>
<body>
  <div class="container">
    <div class="logo-section">
      <div class="logo">
        <img src="imagenes/logo.jpg" alt="Logo" style="width: 100%; height: 100%; border-radius: 20px;">
      </div>
      <h1>NumeraLogic</h1>
      <p class="subtitle">Plataforma de Aprendizaje</p>
    </div>

    <div class="welcome-text">
      <h2>🎓 ¡Bienvenido!</h2>
      <p>Aprende matemáticas, programación e ingeniería a tu propio ritmo</p>
    </div>

    <div class="buttons">
      <a href="login.php" class="btn btn-primary">Iniciar sesión</a>
      <a href="registro.php" class="btn btn-secondary">Crear cuenta nueva</a>
    </div>
  </div>
</body>
</html>