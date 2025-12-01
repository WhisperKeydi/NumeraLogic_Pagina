<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir conexión y funciones
include 'conexion.php';
include 'funciones_notificaciones.php';

// Obtener cursos recientes del usuario
$cursos_recientes = obtenerCursosRecientes($conexion, $_SESSION['usuario_id']);

// Obtener notificaciones no leídas
$notificaciones = obtenerNotificacionesNoLeidas($conexion, $_SESSION['usuario_id']);
$total_notificaciones = contarNotificacionesNoLeidas($conexion, $_SESSION['usuario_id']);

// Procesar marcar como leídas si se envió el formulario
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    if (isset($_POST['marcar_todas_leidas'])) {
        marcarTodasLeidas($conexion, $_SESSION['usuario_id']);
        header("Location: dashboard.php");
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
        header("Location: dashboard.php");
        exit();
    }
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Inicio - NumeraLogic</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/pagina_principal.css">
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
      <a href="dashboard.php" class="active">
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
      
      <!-- MENÚ DE USUARIO -->
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
    <section class="hero-card">
      <div class="hero-left">
        <h2>🎓 ¡Bienvenido de vuelta <?php echo htmlspecialchars($_SESSION['nombre']); ?>!</h2>
        <p>¡Continúa con tu racha! Hoy tienes 3 nuevos ejercicios y 1 retroalimentación de tu profesor(a) esperándote</p>
        <p class="info-text">Accede a todos los materiales, ejercicios y recursos de tus materias</p>
        <button onclick="window.location.href='areas_disponibles.php'" class="primary-btn">
            📚 Explorar Materiales de Estudio
        </button>
      </div>
      <div class="hero-right">
        <div class="label">85%</div>
        <div class="label">Completado</div>
        <div class="sublabel" style="margin-top: 1rem;">10</div>
        <div class="sublabel">Esta semana</div>
      </div>
    </section>

    <div class="grid">
      <div class="courses">
        <div class="section-header">
            <h3>Cursos Recientes</h3>
            <p>Tus últimos cursos visitados</p>
        </div>
        
        <?php if (!empty($cursos_recientes)): ?>
            <div class="courses-grid">
                <?php foreach ($cursos_recientes as $curso): ?>
                <div class="course-card">
                    <img src="<?php echo htmlspecialchars($curso['curso_imagen']); ?>" 
                         alt="<?php echo htmlspecialchars($curso['curso_nombre']); ?>" 
                         class="course-image">
                    <div class="course-content">
                        <h4><?php echo htmlspecialchars($curso['curso_nombre']); ?></h4>
                        <button onclick="window.location.href='<?php echo htmlspecialchars($curso['curso_pagina']); ?>'">
                            Continuar estudiando
                        </button>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        <?php else: ?>
            <div class="no-courses-message">
                <div class="no-courses-icon">📚</div>
                <h3>Aún no has abierto ningún curso</h3>
                <p>Comienza explorando nuestros materiales de estudio disponibles</p>
                <button onclick="window.location.href='areas_disponibles.php'" class="primary-btn">
                    Explorar Cursos Disponibles
                </button>
            </div>
        <?php endif; ?>
        
        <div class="all-courses-link">
            <a href="areas_disponibles.php" class="view-all-btn">
                📚 Ver todos los materiales disponibles
            </a>
        </div>
      </div>

      <aside>
        <div class="level-card">
          <h3>Nivel 12</h3>
          <p class="subtitle">Desarrollador en Ascenso</p>
          
          <div class="xp-header">
            <span>XP Total</span>
            <span class="number">
              <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
                <path d="M12 2L15.09 8.26L22 9.27L17 14.14L18.18 21.02L12 17.77L5.82 21.02L7 14.14L2 9.27L8.91 8.26L12 2Z"/>
              </svg>
              2,450
            </span>
          </div>

          <div class="progress-bar-container">
            <div class="progress-label">Progreso al Nivel 13</div>
            <div class="progress-bar">
              <div class="progress-fill"></div>
            </div>
            <div class="xp-text">850/1,200 XP</div>
          </div>
        </div>

        <div class="stats">
          <div class="stat">
            <div class="stat-icon">🔥</div>
            <h4>7</h4>
            <p>Días de racha</p>
          </div>
          <div class="stat">
            <div class="stat-icon">🏆</div>
            <h4>24</h4>
            <p>Victorias</p>
          </div>
        </div>
      </aside>
    </div>
  </main>

  <script>
    // Animación de progreso
    setTimeout(() => {
      const progressFill = document.querySelector('.progress-fill');
      if (progressFill) {
        progressFill.style.width = '70%';
      }
    }, 300);

    // Sistema de notificaciones y menú de usuario MEJORADO
    document.addEventListener('DOMContentLoaded', function() {
      // Notificaciones
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
          
          // Marcar como leída via AJAX
          fetch('dashboard.php', {
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

      // MENÚ DE USUARIO
      const userMenuButton = document.getElementById('userMenuButton');
      const userDropdown = document.getElementById('userDropdown');
      
      if (userMenuButton && userDropdown) {
        userMenuButton.addEventListener('click', function(e) {
          e.stopPropagation();
          userDropdown.classList.toggle('show');
        });
        
        // Cerrar menú al hacer clic fuera
        document.addEventListener('click', function(event) {
          if (!userMenuButton.contains(event.target) && !userDropdown.contains(event.target)) {
            userDropdown.classList.remove('show');
          }
        });
        
        // Prevenir que el clic en el menú lo cierre
        userDropdown.addEventListener('click', function(e) {
          e.stopPropagation();
        });
      }
    });
  </script>
</body>
</html>