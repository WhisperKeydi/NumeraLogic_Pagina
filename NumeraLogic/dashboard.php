<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
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
          <div class="notification-badge">3</div>
        </div>
        <div class="notifications-panel">
          <div class="notifications-header">
            <h3>Notificaciones</h3>
            <button class="mark-read">Marcar todas como leídas</button>
          </div>
          <div class="notifications-list">
            <div class="notification-item unread">
              <div class="notification-icon achievement">🏆</div>
              <div class="notification-content">
                <div class="notification-title">¡Nuevo logro desbloqueado!</div>
                <div class="notification-message">Has completado 10 ejercicios de cálculo.</div>
                <div class="notification-time">Hace 2 horas</div>
              </div>
              <div class="notification-dot"></div>
            </div>
            <div class="notification-item unread">
              <div class="notification-icon course">📚</div>
              <div class="notification-content">
                <div class="notification-title">Nuevo contenido disponible</div>
                <div class="notification-message">Se ha añadido un nuevo módulo a Programación Estructurada.</div>
                <div class="notification-time">Hace 1 día</div>
              </div>
              <div class="notification-dot"></div>
            </div>
            <div class="notification-item">
              <div class="notification-icon system">🔔</div>
              <div class="notification-content">
                <div class="notification-title">Recordatorio de estudio</div>
                <div class="notification-message">No olvides practicar hoy para mantener tu racha.</div>
                <div class="notification-time">Hace 3 días</div>
              </div>
            </div>
            <div class="notification-item">
              <div class="notification-icon achievement">⭐</div>
              <div class="notification-content">
                <div class="notification-title">Has subido de nivel</div>
                <div class="notification-message">Felicidades, ahora eres Nivel 12.</div>
                <div class="notification-time">Hace 5 días</div>
              </div>
            </div>
          </div>
          <div class="notifications-footer">
            <a href="#" class="view-all">Ver todas las notificaciones</a>
          </div>
        </div>
      </div>
      
      <!-- MENÚ DE USUARIO MEJORADO -->
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
        <button onclick="window.location.href='areas_disponibles.php'">Áreas disponibles</button>
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
        <div class="course-card">
          <img src="https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=400&h=300&fit=crop" alt="Programación Estructurada" class="course-image">
          <div class="course-content">
            <h4>Programación Estructurada</h4>
            <button>Ir al curso</button>
          </div>
        </div>

        <div class="course-card">
          <img src="https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop" alt="Introducción al cálculo" class="course-image">
          <div class="course-content">
            <h4>Introducción al cálculo</h4>
            <button>Ir al curso</button>
          </div>
        </div>

        <div class="course-card">
          <img src="https://images.unsplash.com/photo-1518770660439-4636190af475?w=400&h=300&fit=crop" alt="Sistemas digitales" class="course-image">
          <div class="course-content">
            <h4>Sistemas digitales</h4>
            <button>Ir al curso</button>
          </div>
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
      const markReadButton = document.querySelector('.mark-read');
      const notificationItems = document.querySelectorAll('.notification-item');
      const notificationBadge = document.querySelector('.notification-badge');
      
      if (notificationsIcon && notificationsPanel) {
        notificationsIcon.addEventListener('click', function(e) {
          e.stopPropagation();
          const isActive = notificationsPanel.classList.contains('active');
          notificationsPanel.classList.toggle('active');
          notificationsOverlay.style.display = isActive ? 'none' : 'block';
        });
      }
      
      if (notificationsOverlay) {
        notificationsOverlay.addEventListener('click', function() {
          notificationsPanel.classList.remove('active');
          notificationsOverlay.style.display = 'none';
        });
      }
      
      if (markReadButton) {
        markReadButton.addEventListener('click', function() {
          notificationItems.forEach(item => {
            item.classList.remove('unread');
            const dot = item.querySelector('.notification-dot');
            if (dot) dot.remove();
          });
          
          if (notificationBadge) {
            notificationBadge.textContent = '0';
            notificationBadge.style.display = 'none';
          }
        });
      }
      
      notificationItems.forEach(item => {
        item.addEventListener('click', function() {
          if (this.classList.contains('unread')) {
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
        });
      });

      // MENÚ DE USUARIO - CÓDIGO MEJORADO
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