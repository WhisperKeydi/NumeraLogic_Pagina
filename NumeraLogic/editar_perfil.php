<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';
include 'funciones_notificaciones.php'; // Añade esta línea

$mensaje = '';
$tipo_mensaje = '';

// Añade estas líneas para obtener notificaciones
$notificaciones = obtenerNotificacionesNoLeidas($conexion, $_SESSION['usuario_id']);
$total_notificaciones = contarNotificacionesNoLeidas($conexion, $_SESSION['usuario_id']);

// Procesar actualización de datos
if ($_POST) {
    // Añade este bloque para manejar acciones de notificaciones
    if (isset($_POST['marcar_todas_leidas'])) {
        marcarTodasLeidas($conexion, $_SESSION['usuario_id']);
        header("Location: editar_perfil.php");
        exit();
    }
    
    if (isset($_POST['marcar_leida'])) {
        $notificacion_id = $_POST['notificacion_id'];
        marcarNotificacionLeida($conexion, $notificacion_id, $_SESSION['usuario_id']);
        if (isset($_POST['ajax'])) {
            echo json_encode(['success' => true]);
            exit();
        }
        header("Location: editar_perfil.php");
        exit();
    }
    
    // Tu código original continúa aquí...
    $nombre = $conexion->real_escape_string($_POST['nombre']);
    $contrasena_actual = $_POST['contrasena_actual'];
    $nueva_contrasena = $_POST['nueva_contrasena'];
    $confirmar_contrasena = $_POST['confirmar_contrasena'];
    
    $usuario_id = $_SESSION['usuario_id'];
    
    // Verificar contraseña actual
    $sql_verificar = "SELECT contrasena FROM usuarios WHERE id = $usuario_id";
    $resultado = $conexion->query($sql_verificar);
    
    if ($resultado->num_rows > 0) {
        $usuario = $resultado->fetch_assoc();
        
        // Si se quiere cambiar la contraseña, verificar la actual
        if (!empty($nueva_contrasena)) {
            if ($contrasena_actual !== $usuario['contrasena']) {
                $mensaje = 'La contraseña actual es incorrecta';
                $tipo_mensaje = 'error';
            } elseif ($nueva_contrasena !== $confirmar_contrasena) {
                $mensaje = 'Las nuevas contraseñas no coinciden';
                $tipo_mensaje = 'error';
            } else {
                // Actualizar nombre y contraseña
                $sql_actualizar = "UPDATE usuarios SET nombre = '$nombre', contrasena = '$nueva_contrasena' WHERE id = $usuario_id";
                if ($conexion->query($sql_actualizar)) {
                    $_SESSION['nombre'] = $nombre;
                    $mensaje = 'Datos actualizados correctamente';
                    $tipo_mensaje = 'success';
                } else {
                    $mensaje = 'Error al actualizar los datos: ' . $conexion->error;
                    $tipo_mensaje = 'error';
                }
            }
        } else {
            // Solo actualizar el nombre
            $sql_actualizar = "UPDATE usuarios SET nombre = '$nombre' WHERE id = $usuario_id";
            if ($conexion->query($sql_actualizar)) {
                $_SESSION['nombre'] = $nombre;
                $mensaje = 'Nombre actualizado correctamente';
                $tipo_mensaje = 'success';
            } else {
                $mensaje = 'Error al actualizar el nombre: ' . $conexion->error;
                $tipo_mensaje = 'error';
            }
        }
    }
}

$conexion->close();
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Editar Perfil - NumeraLogic</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/editar_perfil.css">
</head>
<body>
  <header>
    <div class="brand">
      <a href="dashboard.php" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit;">
        <div class="logo">
          <img src="imagenes/logo.jpg" alt="Logo" style="width: 100%; height: 100%; border-radius: 12px;">
        </div>
        <h2>NumeraLogic</h2>
      </a>
    </div>
    
    <nav>
      <a href="dashboard.php">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
          <path d="M3 9l9-7 9 7v11a2 2 0 0 1-2 2H5a2 2 0 0 1-2-2z"></path>
        </svg>
        Inicio
      </a>
      <a href="logros.php">
        <svg width="20" height="20" viewBox="0 0 24 24" fill="currentColor">
          <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"></path>
        </svg>
        Logros
      </a>
    </nav>
    
    <div class="right">
      <div class="notifications-container">
        <div class="notifications-icon">
          <svg class="bell-icon" width="24" height="24" viewBox="0 0 24 24" fill="none" stroke="#1e293b" stroke-width="2">
            <path d="M18 8A6 6 0 0 0 6 8c0 7-3 9-3 9h18s-3-2-3-9"></path>
            <path d="M13.73 21a2 2 0 0 1-3.46 0"></path>
          </svg>
          <?php if ($total_notificaciones > 0): ?>
            <div class="notification-badge"><?php echo $total_notificaciones; ?></div>
          <?php endif; ?>
        </div>
        <div class="notifications-panel">
          <div class="notifications-header">
            <h3>Notificaciones</h3>
            <?php if ($total_notificaciones > 0): ?>
              <form method="POST" style="display: inline;">
                <button type="submit" name="marcar_todas_leidas" class="mark-read">
                  Marcar todas como leídas
                </button>
              </form>
            <?php endif; ?>
          </div>
          <div class="notifications-list">
            <?php if (!empty($notificaciones)): ?>
              <?php foreach ($notificaciones as $notif): ?>
                <div class="notification-item unread" data-id="<?php echo $notif['id']; ?>">
                  <div class="notification-icon">
                    <?php 
                    switch($notif['tipo']) {
                      case 'logro': echo '🏆'; break;
                      case 'curso': echo '📚'; break;
                      case 'sistema': echo '🔔'; break;
                      case 'recordatorio': echo '⏰'; break;
                      default: echo '🔔';
                    }
                    ?>
                  </div>
                  <div class="notification-content">
                    <div class="notification-title"><?php echo htmlspecialchars($notif['titulo']); ?></div>
                    <div class="notification-message"><?php echo htmlspecialchars($notif['mensaje']); ?></div>
                    <div class="notification-time"><?php echo formatearTiempo($notif['fecha_creacion']); ?></div>
                  </div>
                  <div class="notification-dot"></div>
                </div>
              <?php endforeach; ?>
            <?php else: ?>
              <div class="notification-item">
                <div class="notification-content">
                  <div class="notification-message">No tienes notificaciones nuevas</div>
                </div>
              </div>
            <?php endif; ?>
          </div>
          <div class="notifications-footer">
            <a href="todas_notificaciones.php" class="view-all">Ver todas las notificaciones</a>
          </div>
        </div>
      </div>
      <div class="user-menu">
        <div class="user-avatar" id="userMenuButton">
          <img src="imagenes/perfil.jpg" class="avatar" alt="<?php echo htmlspecialchars($_SESSION['nombre']); ?>">
          <span class="user-name"><?php echo htmlspecialchars($_SESSION['nombre']); ?></span>
          <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
            <path d="M7 10l5 5 5-5z"></path>
          </svg>
        </div>
        <div class="user-dropdown" id="userDropdown">
          <a href="editar_perfil.php" class="dropdown-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M12 12c2.21 0 4-1.79 4-4s-1.79-4-4-4-4 1.79-4 4 1.79 4 4 4zm0 2c-2.67 0-8 1.34-8 4v2h16v-2c0-2.66-5.33-4-8-4z"/>
            </svg>
            Cambiar datos
          </a>
          <a href="logout.php" class="dropdown-item">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M17 7l-1.41 1.41L18.17 11H8v2h10.17l-2.58 2.58L17 17l5-5zM4 5h8V3H4c-1.1 0-2 .9-2 2v14c0 1.1.9 2 2 2h8v-2H4V5z"/>
            </svg>
            Cerrar sesión
          </a>
        </div>
      </div>
    </div>
  </header>

  <div class="notifications-overlay"></div>

  <main>
    <section class="profile-card">
      <h1>👤 Editar perfil</h1>
      
      <?php if ($mensaje): ?>
        <div class="mensaje <?php echo $tipo_mensaje; ?>">
          <?php echo $mensaje; ?>
        </div>
      <?php endif; ?>
      
      <form method="POST" class="profile-form">
        <div class="form-group">
          <label for="nombre">Nombre completo</label>
          <input type="text" id="nombre" name="nombre" value="<?php echo htmlspecialchars($_SESSION['nombre']); ?>" required>
        </div>
        
        <div class="form-group">
          <label for="contrasena_actual">contraseña actual</label>
          <input type="password" id="contrasena_actual" name="contrasena_actual" placeholder="Ingresa tu contraseña actual">
          <small>Solo necesaria si quieres cambiar la contraseña</small>
        </div>
        
        <div class="form-group">
          <label for="nueva_contrasena">nueva contraseña</label>
          <input type="password" id="nueva_contrasena" name="nueva_contrasena" placeholder="Ingresa nueva contraseña">
        </div>
        
        <div class="form-group">
          <label for="confirmar_contrasena">confirmar contraseña</label>
          <input type="password" id="confirmar_contrasena" name="confirmar_contrasena" placeholder="Confirma la nueva contraseña">
        </div>
        
        <div class="form-actions">
          <button type="submit" class="btn-primary">Guardar cambios</button>
          <a href="dashboard.php" class="btn-secondary">Cancelar</a>
        </div>
      </form>
    </section>
  </main>

  <script>
    document.addEventListener('DOMContentLoaded', function() {
      // Sistema de notificaciones
      const notificationsIcon = document.querySelector('.notifications-icon');
      const notificationsPanel = document.querySelector('.notifications-panel');
      const notificationsOverlay = document.querySelector('.notifications-overlay');
      const markReadButton = document.querySelector('.mark-read');
      const notificationItems = document.querySelectorAll('.notification-item');
      const notificationBadge = document.querySelector('.notification-badge');
      
      if (notificationsIcon && notificationsPanel) {
        notificationsIcon.addEventListener('click', function(e) {
          e.stopPropagation();
          notificationsPanel.classList.toggle('active');
          notificationsOverlay.style.display = notificationsPanel.classList.contains('active') ? 'block' : 'none';
        });
        
        notificationsOverlay.addEventListener('click', function() {
          notificationsPanel.classList.remove('active');
          notificationsOverlay.style.display = 'none';
        });
        
        if (markReadButton) {
          markReadButton.addEventListener('click', function() {
            notificationItems.forEach(item => {
              item.classList.remove('unread');
              const dot = item.querySelector('.notification-dot');
              if (dot) dot.remove();
            });
            
            notificationBadge.textContent = '0';
            notificationBadge.style.display = 'none';
          });
        }
        
        notificationItems.forEach(item => {
          item.addEventListener('click', async function() {
            if (this.classList.contains('unread')) {
              const notificationId = this.getAttribute('data-id');
              
              if (notificationId) {
                try {
                  const formData = new FormData();
                  formData.append('marcar_leida', '1');
                  formData.append('notificacion_id', notificationId);
                  formData.append('ajax', '1');
                  
                  const response = await fetch('editar_perfil.php', {
                    method: 'POST',
                    body: formData
                  });
                  
                  const data = await response.json();
                  
                  if (data.success) {
                    this.classList.remove('unread');
                    const dot = this.querySelector('.notification-dot');
                    if (dot) dot.remove();
                    
                    const unreadCount = document.querySelectorAll('.notification-item.unread').length;
                    if (notificationBadge) {
                      notificationBadge.textContent = unreadCount;
                      if (unreadCount === 0) {
                        notificationBadge.style.display = 'none';
                      }
                    }
                  }
                } catch (error) {
                  console.error('Error marcando notificación:', error);
                }
              }
            }
          });
        });
      }
      
      // Sistema de menú de usuario
      const userMenuButton = document.getElementById('userMenuButton');
      const userDropdown = document.getElementById('userDropdown');
      
      if (userMenuButton && userDropdown) {
        userMenuButton.addEventListener('click', function(e) {
          e.stopPropagation();
          userDropdown.classList.toggle('show');
        });
        
        document.addEventListener('click', function() {
          userDropdown.classList.remove('show');
        });
        
        userDropdown.addEventListener('click', function(e) {
          e.stopPropagation();
        });
      }
    });
  </script>
</body>
</html>