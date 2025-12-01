<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir conexión y funciones de notificaciones
include 'conexion.php';
include 'funciones_notificaciones.php';

// ===== AÑADIDO: Actualizar racha del usuario al acceder a la página =====
actualizarRacha($conexion, $_SESSION['usuario_id']);
// ========================================================================

// Obtener estadísticas del usuario
$estadisticas = obtenerEstadisticasUsuario($conexion, $_SESSION['usuario_id']);

// Obtener logros del usuario
$logros = obtenerLogrosUsuario($conexion, $_SESSION['usuario_id']);

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
  <title>NumeraLogic - Mis Logros</title>
  <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700;800&display=swap" rel="stylesheet">
  <link rel="stylesheet" href="css/logros.css">
  <style>
    /* Animación sutil de entrada para las tarjetas */
    @keyframes fadeInUp {
      from {
        opacity: 0;
        transform: translateY(30px);
      }
      to {
        opacity: 1;
        transform: translateY(0);
      }
    }
    
    .achievement {
      animation: fadeInUp 0.6s ease forwards;
      opacity: 0;
    }
    
    .achievement:nth-child(1) { animation-delay: 0.1s; }
    .achievement:nth-child(2) { animation-delay: 0.2s; }
    .achievement:nth-child(3) { animation-delay: 0.3s; }
    .achievement:nth-child(4) { animation-delay: 0.4s; }
    .achievement:nth-child(5) { animation-delay: 0.5s; }
    .achievement:nth-child(6) { animation-delay: 0.6s; }
    .achievement:nth-child(7) { animation-delay: 0.7s; }
    
    /* Puntos de conexión animados para el fondo del hero */
    .hero-card::after {
      content: '✦';
      position: absolute;
      top: 20px;
      right: 30px;
      font-size: 2rem;
      color: rgba(255, 255, 255, 0.3);
      animation: twinkle 3s infinite;
    }
    
    @keyframes twinkle {
      0%, 100% { opacity: 0.3; }
      50% { opacity: 0.8; }
    }

    /* Estilos para logros bloqueados/desbloqueados */
    .achievement.locked {
      opacity: 0.7;
      filter: grayscale(50%);
    }

    .achievement.locked .achievement-img-container {
      position: relative;
    }

    .achievement-lock {
      position: absolute;
      top: 50%;
      left: 50%;
      transform: translate(-50%, -50%);
      font-size: 2rem;
      color: rgba(0, 0, 0, 0.5);
    }

    .achievement.unlocked {
      animation: glowUnlock 0.5s ease forwards;
    }

    @keyframes glowUnlock {
      0% { box-shadow: 0 4px 20px rgba(255, 215, 0, 0); }
      50% { box-shadow: 0 4px 30px rgba(255, 215, 0, 0.6); }
      100% { box-shadow: 0 4px 20px rgba(255, 215, 0, 0.2); }
    }

    .achievement-progress {
      margin: 10px 0;
      background: #e0e0e0;
      border-radius: 10px;
      overflow: hidden;
      height: 6px;
    }

    .achievement-progress-bar {
      background: linear-gradient(90deg, #4CAF50, #8BC34A);
      height: 100%;
      transition: width 0.5s ease;
    }

    .achievement-date {
      font-size: 0.8rem;
      color: #666;
      margin-top: 5px;
      text-align: center;
    }

    .achievement-requirement {
      font-size: 0.8rem;
      color: #ff6b6b;
      margin-top: 5px;
      text-align: center;
      font-weight: 500;
    }

    .achievement-points {
      background: #FFD700;
      color: #333;
      padding: 2px 8px;
      border-radius: 12px;
      font-size: 0.8rem;
      margin-left: 5px;
      font-weight: bold;
    }
  </style>
</head>
<body>

  <!-- Navbar -->
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
      <a href="logros.php" class="active">
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
    <!-- Hero Card -->
    <section class="hero-card">
      <h2>🏆 Mis Logros y Recompensas</h2>
      <p>Tu registro de victorias. Mide tu dominio, mantén tu racha y desbloquea todas las medallas para subir de nivel</p>
    </section>

    <!-- Stats -->
    <section class="stats">
      <div class="stat">⭐ <span>Nivel <?php echo $estadisticas['nivel_actual']; ?></span></div>
      <div class="stat">🔥 <span><?php echo $estadisticas['racha_actual']; ?> Días de racha</span></div>
      <div class="stat">🏆 <span><?php echo $estadisticas['logros_desbloqueados']; ?> Logros</span></div>
    </section>

    <!-- Achievements -->
    <section class="achievements">
      <?php foreach ($logros as $logro): ?>
      <div class="achievement <?php echo $logro['desbloqueado'] ? 'unlocked' : 'locked'; ?>" data-id="<?php echo $logro['id']; ?>">
        <div class="achievement-img-container">
          <img src="<?php echo htmlspecialchars($logro['imagen']); ?>" alt="<?php echo htmlspecialchars($logro['nombre']); ?>">
          <?php if (!$logro['desbloqueado']): ?>
            <div class="achievement-lock">🔒</div>
          <?php endif; ?>
        </div>
        <h3><?php echo htmlspecialchars($logro['nombre']); ?></h3>
        <p><?php echo htmlspecialchars($logro['descripcion']); ?></p>
        <div class="achievement-progress">
          <?php if ($logro['desbloqueado']): ?>
            <div class="achievement-progress-bar" style="width: 100%"></div>
            <div class="achievement-date">
              <?php echo date('d M Y', strtotime($logro['fecha_desbloqueo'])); ?>
            </div>
          <?php else: ?>
            <div class="achievement-progress-bar" style="width: 0%"></div>
            <div class="achievement-requirement">
              Requiere: <?php echo $logro['valor_requerido']; ?>
            </div>
          <?php endif; ?>
        </div>
        <span class="achievement-status <?php echo $logro['desbloqueado'] ? 'unlocked' : 'locked'; ?>">
          <?php echo $logro['desbloqueado'] ? 'Desbloqueado' : 'Bloqueado'; ?>
          <?php if ($logro['desbloqueado']): ?>
            <span class="achievement-points">+<?php echo $logro['puntos']; ?> pts</span>
          <?php endif; ?>
        </span>
      </div>
      <?php endforeach; ?>
    </section>
  </main>

  <!-- Modal para logros expandidos -->
  <div class="achievement-modal" id="achievementModal">
    <div class="modal-content">
      <button class="modal-close">&times;</button>
      <div class="modal-body">
        <div class="modal-header">
          <div class="modal-icon">
            <img id="modalIcon" src="" alt="Logro">
          </div>
          <h2 class="modal-title" id="modalTitle"></h2>
          <p class="modal-description" id="modalDescription"></p>
        </div>
        <div class="modal-details">
          <h4>Detalles del Logro</h4>
          <p id="modalDetails"></p>
          <div class="modal-date">
            <svg width="16" height="16" viewBox="0 0 24 24" fill="currentColor">
              <path d="M19 4h-1V2h-2v2H8V2H6v2H5c-1.11 0-1.99.9-1.99 2L3 20c0 1.1.89 2 2 2h14c1.1 0 2-.9 2-2V6c0-1.1-.9-2-2-2zm0 16H5V10h14v10zm0-12H5V6h14v2z"/>
            </svg>
            <span id="modalDate"></span>
          </div>
        </div>
      </div>
    </div>
  </div>

  <script>
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
      
      // Efecto de aparición para las tarjetas de logros
      const observerOptions = {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
      };
      
      const observer = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
          if (entry.isIntersecting) {
            entry.target.style.opacity = '1';
          }
        });
      }, observerOptions);
      
      document.querySelectorAll('.achievement').forEach(el => {
        observer.observe(el);
      });

      // === MEJORAS PARA LOS LOGROS (MODAL Y EXPANSIÓN) ===
      // Datos extendidos para cada logro (tomados de la base de datos)
      const achievementData = {
        <?php foreach ($logros as $logro): ?>
        <?php echo $logro['id']; ?>: {
          title: "<?php echo addslashes($logro['nombre']); ?>",
          description: "<?php echo addslashes($logro['descripcion']); ?>",
          details: "<?php echo addslashes($logro['descripcion']); ?> Logro de la categoría <?php echo $logro['categoria']; ?>. Requería alcanzar <?php echo $logro['valor_requerido']; ?> en <?php echo $logro['condicion']; ?>.",          date: "<?php echo $logro['desbloqueado'] ? 'Obtenido: ' . date('d M Y', strtotime($logro['fecha_desbloqueo'])) : 'Aún no desbloqueado'; ?>",
          progress: <?php echo $logro['desbloqueado'] ? 100 : 0; ?>,
          unlocked: <?php echo $logro['desbloqueado'] ? 'true' : 'false'; ?>,
          points: <?php echo $logro['puntos']; ?>,
          category: "<?php echo $logro['categoria']; ?>"
        },
        <?php endforeach; ?>
      };

      // Referencias a elementos del modal
      const achievementModal = document.getElementById('achievementModal');
      const modalClose = document.querySelector('.modal-close');
      const modalTitle = document.getElementById('modalTitle');
      const modalDescription = document.getElementById('modalDescription');
      const modalDetails = document.getElementById('modalDetails');
      const modalDate = document.getElementById('modalDate');
      const modalIcon = document.getElementById('modalIcon');

      // Abrir modal al hacer clic en un logro
      document.querySelectorAll('.achievement').forEach((card) => {
        card.addEventListener('click', function(e) {
          e.stopPropagation();
          
          // Remover clase active de todas las tarjetas
          document.querySelectorAll('.achievement').forEach(c => c.classList.remove('active'));
          
          // Agregar clase active a la tarjeta clickeada
          this.classList.add('active');
          
          // Obtener datos del logro
          const achievementId = this.getAttribute('data-id');
          const data = achievementData[achievementId];
          
          if (data) {
            // Obtener imagen de la tarjeta
            const imgSrc = this.querySelector('img').src;
            
            // Llenar modal con datos
            modalTitle.textContent = data.title;
            modalDescription.textContent = data.description;
            modalDetails.textContent = data.details;
            modalDate.textContent = data.date;
            modalIcon.src = imgSrc;
            
            // Mostrar modal
            achievementModal.classList.add('active');
            document.body.style.overflow = 'hidden'; // Prevenir scroll
          }
        });
      });

      // Cerrar modal
      modalClose.addEventListener('click', function() {
        achievementModal.classList.remove('active');
        document.body.style.overflow = 'auto';
        document.querySelectorAll('.achievement').forEach(c => c.classList.remove('active'));
      });

      // Cerrar modal al hacer clic fuera
      achievementModal.addEventListener('click', function(e) {
        if (e.target === this) {
          this.classList.remove('active');
          document.body.style.overflow = 'auto';
          document.querySelectorAll('.achievement').forEach(c => c.classList.remove('active'));
        }
      });

      // Cerrar modal con Escape
      document.addEventListener('keydown', function(e) {
        if (e.key === 'Escape' && achievementModal.classList.contains('active')) {
          achievementModal.classList.remove('active');
          document.body.style.overflow = 'auto';
          document.querySelectorAll('.achievement').forEach(c => c.classList.remove('active'));
        }
      });

      // === CORREGIR BUG DE EFECTOS VISUALES ===
      // Asegurar que los efectos no interfieran con el mouse
      const fixVisualBug = () => {
        // Remover efectos problemáticos en elementos específicos
        const logo = document.querySelector('.logo');
        if (logo) {
          logo.style.overflow = 'hidden';
        }
        
        // Asegurar que los pseudo-elementos no capturen eventos
        document.querySelectorAll('*').forEach(el => {
          const style = window.getComputedStyle(el, '::after');
          if (style.content !== 'none') {
            el.style.position = 'relative';
            el.style.zIndex = '1';
          }
        });
      };

      // Ejecutar corrección después de que la página cargue completamente
      setTimeout(fixVisualBug, 100);
    });
  </script>
</body>
</html>