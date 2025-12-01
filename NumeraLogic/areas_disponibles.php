<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir conexión y funciones de notificaciones
include 'conexion.php';
include 'funciones_notificaciones.php';

// Obtener notificaciones no leídas
$notificaciones = obtenerNotificacionesNoLeidas($conexion, $_SESSION['usuario_id']);
$total_notificaciones = contarNotificacionesNoLeidas($conexion, $_SESSION['usuario_id']);

// Procesar marcar como leídas si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['marcar_todas_leidas'])) {
        marcarTodasLeidas($conexion, $_SESSION['usuario_id']);
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
    
    if (isset($_POST['marcar_leida'])) {
        $notificacion_id = $_POST['notificacion_id'];
        marcarNotificacionLeida($conexion, $notificacion_id, $_SESSION['usuario_id']);
        // Responder para AJAX
        if (isset($_POST['ajax'])) {
            echo json_encode(['success' => true]);
            exit();
        }
        header("Location: " . $_SERVER['PHP_SELF']);
        exit();
    }
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Áreas - NumeraLogic</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/areas_disponibles.css">
</head>
<body>
<header>
  <div class="brand">
    <a href="dashboard.php" style="display: flex; align-items: center; gap: 10px; text-decoration: none; color: inherit;">
      <div class="logo">
        <img src="imagenes/logo.jpg" alt="Logo" style="width: 100%; height: 100%; border-radius: 50%;">
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
        <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z">
        </path>
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
    <section class="hero-section">
      <div class="hero-container">
        <h1>🧠 Áreas disponibles</h1>
        <p>Elige un área para filtrar el catálogo y mostrar los cursos relevantes para tu ruta de aprendizaje</p>
      </div>
    </section>

    <div class="areas-grid">
      <div class="area-card green" onclick="window.location.href='Formación_Inicial.php'">
        <div class="area-icon">👨‍🏫</div>
        <h3>Formación<br>inicial</h3>
        <button onclick="event.stopPropagation(); window.location.href='Formación_Inicial.php'">Comenzar</button>
      </div>

      <div class="area-card red" onclick="window.location.href='Matemáticas_apli.php'">
        <div class="area-icon">📐</div>
        <h3>Matemáticas aplicadas</h3>
        <button onclick="event.stopPropagation(); window.location.href='Matemáticas_apli.php'">Comenzar</button>
      </div>

      <div class="area-card blue" onclick="window.location.href='Ingeniería.php'">
        <div class="area-icon">💻</div>
        <h3>Ingeniería en computación</h3>
        <button onclick="event.stopPropagation(); window.location.href='Ingeniería.php'">Comenzar</button>
      </div>
    </div>
  </main>

  <script>
    // Sistema de notificaciones y menú de usuario
    document.addEventListener('DOMContentLoaded', function() {
      const notificationsIcon = document.querySelector('.notifications-icon');
      const notificationsPanel = document.querySelector('.notifications-panel');
      const notificationsOverlay = document.querySelector('.notifications-overlay');
      const notificationItems = document.querySelectorAll('.notification-item.unread');
      const notificationBadge = document.querySelector('.notification-badge');
      
      // Mostrar/ocultar panel de notificaciones
      notificationsIcon.addEventListener('click', function(e) {
        e.stopPropagation();
        notificationsPanel.classList.toggle('active');
        notificationsOverlay.style.display = notificationsPanel.classList.contains('active') ? 'block' : 'none';
      });
      
      // Cerrar panel al hacer clic fuera
      notificationsOverlay.addEventListener('click', function() {
        notificationsPanel.classList.remove('active');
        notificationsOverlay.style.display = 'none';
      });
      
      // Marcar notificación leída una por una (AJAX)
      document.querySelectorAll('.notification-item.unread').forEach(item => {
        item.addEventListener('click', function() {
          const notificacionId = this.getAttribute('data-id');
          const currentFile = '<?php echo basename($_SERVER["PHP_SELF"]); ?>';
          
          // Marcar como leída via AJAX
          fetch(currentFile, {
            method: 'POST',
            headers: {
              'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'marcar_leida=1&notificacion_id=' + notificacionId + '&ajax=1'
          })
          .then(response => response.json())
          .then(data => {
            if (data.success) {
              this.classList.remove('unread');
              const dot = this.querySelector('.notification-dot');
              if (dot) dot.remove();
              
              // Actualizar el contador
              const unreadCount = document.querySelectorAll('.notification-item.unread').length;
              if (notificationBadge) {
                notificationBadge.textContent = unreadCount;
                if (unreadCount === 0) {
                  notificationBadge.style.display = 'none';
                }
              }
            }
          });
        });
      });

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