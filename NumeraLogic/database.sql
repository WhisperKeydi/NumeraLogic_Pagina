-- Eliminar la base de datos si existe y recrearla
DROP DATABASE IF EXISTS numeralogic;
CREATE DATABASE numeralogic;
USE numeralogic;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    matricula VARCHAR(20) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    nombre VARCHAR(100),
    email VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de progreso
CREATE TABLE progreso (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(11),
    curso VARCHAR(100),
    progreso INT(3) DEFAULT 0,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla para cursos recientes
CREATE TABLE usuario_cursos_recientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    curso_nombre VARCHAR(255),
    curso_imagen VARCHAR(500),
    curso_pagina VARCHAR(255),
    fecha_acceso TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de notificaciones
CREATE TABLE notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    mensaje TEXT NOT NULL,
    tipo ENUM('logro', 'curso', 'sistema', 'recordatorio') NOT NULL,
    leida BOOLEAN DEFAULT FALSE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de racha
CREATE TABLE usuario_rachas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    racha_actual INT DEFAULT 0,
    racha_max INT DEFAULT 0,
    ultima_visita DATE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de logros disponibles
CREATE TABLE logros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(500) DEFAULT NULL,
    condicion VARCHAR(100) NOT NULL,
    valor_requerido INT NOT NULL,
    puntos INT DEFAULT 10,
    categoria ENUM('progreso', 'habilidad', 'dedicacion', 'especial') DEFAULT 'progreso',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de logros desbloqueados por usuarios
CREATE TABLE usuario_logros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    logro_id INT NOT NULL,
    fecha_desbloqueo TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (logro_id) REFERENCES logros(id) ON DELETE CASCADE,
    UNIQUE KEY unico_usuario_logro (usuario_id, logro_id)
);

-- Tabla para estadísticas de usuario
CREATE TABLE usuario_estadisticas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    lecciones_vistas INT DEFAULT 0,
    cursos_visitados INT DEFAULT 0,
    horas_estudio INT DEFAULT 0,
    dias_visita INT DEFAULT 0,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    UNIQUE KEY unico_usuario (usuario_id)
);

-- Tabla para visitas a cursos específicos (CORREGIDA)
CREATE TABLE usuario_visitas_cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    fecha_visita TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_visita_date DATE AS (DATE(fecha_visita)) STORED,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    UNIQUE KEY unico_visita_diaria (usuario_id, curso_id, fecha_visita_date)
);

-- Insertar usuario de prueba (ID 1)
INSERT INTO usuarios (matricula, contrasena, nombre, email) 
VALUES ('00', '123', 'Usuario Demo', 'usuario@demo.com');

-- Insertar datos de progreso de ejemplo
INSERT INTO progreso (usuario_id, curso, progreso) VALUES
(1, 'Programación Orientada a Objetos', 75),
(1, 'Introducción al cálculo', 60),
(1, 'Sistemas digitales', 45);

-- Cursos iniciales
INSERT INTO usuario_cursos_recientes (usuario_id, curso_nombre, curso_imagen, curso_pagina) VALUES
(1, 'Programación orientada a objetos', 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=400&h=300&fit=crop', 'poo_pagina.php'),
(1, 'Introducción al cálculo', 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop', 'introduccionCalculo_pagina.php'),
(1, 'Sistemas digitales', 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=400&h=300&fit=crop', 'sistemasDigitales_pagina.php');

-- Insertar logros predeterminados
-- Eliminar la base de datos si existe y recrearla
DROP DATABASE IF EXISTS numeralogic;
CREATE DATABASE numeralogic;
USE numeralogic;

-- Tabla de usuarios
CREATE TABLE usuarios (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    matricula VARCHAR(20) UNIQUE NOT NULL,
    contrasena VARCHAR(255) NOT NULL,
    nombre VARCHAR(100),
    email VARCHAR(100),
    fecha_registro TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de progreso
CREATE TABLE progreso (
    id INT(11) AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT(11),
    curso VARCHAR(100),
    progreso INT(3) DEFAULT 0,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla para cursos recientes
CREATE TABLE usuario_cursos_recientes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    usuario_id INT,
    curso_nombre VARCHAR(255),
    curso_imagen VARCHAR(500),
    curso_pagina VARCHAR(255),
    fecha_acceso TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de notificaciones
CREATE TABLE notificaciones (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    titulo VARCHAR(255) NOT NULL,
    mensaje TEXT NOT NULL,
    tipo ENUM('logro', 'curso', 'sistema', 'recordatorio') NOT NULL,
    leida BOOLEAN DEFAULT FALSE,
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de racha
CREATE TABLE usuario_rachas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    racha_actual INT DEFAULT 0,
    racha_max INT DEFAULT 0,
    ultima_visita DATE,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE
);

-- Tabla de logros disponibles
CREATE TABLE logros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    nombre VARCHAR(255) NOT NULL,
    descripcion TEXT NOT NULL,
    imagen VARCHAR(500) DEFAULT NULL,
    condicion VARCHAR(100) NOT NULL,
    valor_requerido INT NOT NULL,
    puntos INT DEFAULT 10,
    categoria ENUM('progreso', 'habilidad', 'dedicacion', 'especial') DEFAULT 'progreso',
    fecha_creacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Tabla de logros desbloqueados por usuarios
CREATE TABLE usuario_logros (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    logro_id INT NOT NULL,
    fecha_desbloqueo TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    FOREIGN KEY (logro_id) REFERENCES logros(id) ON DELETE CASCADE,
    UNIQUE KEY unico_usuario_logro (usuario_id, logro_id)
);

-- Tabla para estadísticas de usuario
CREATE TABLE usuario_estadisticas (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    lecciones_vistas INT DEFAULT 0,
    cursos_visitados INT DEFAULT 0,
    horas_estudio INT DEFAULT 0,
    dias_visita INT DEFAULT 0,
    fecha_actualizacion TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    UNIQUE KEY unico_usuario (usuario_id)
);

-- Tabla para visitas a cursos específicos (CORREGIDA)
CREATE TABLE usuario_visitas_cursos (
    id INT AUTO_INCREMENT PRIMARY KEY,
    usuario_id INT NOT NULL,
    curso_id INT NOT NULL,
    fecha_visita TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    fecha_visita_date DATE AS (DATE(fecha_visita)) STORED,
    FOREIGN KEY (usuario_id) REFERENCES usuarios(id) ON DELETE CASCADE,
    UNIQUE KEY unico_visita_diaria (usuario_id, curso_id, fecha_visita_date)
);

-- Insertar usuario de prueba (ID 1)
INSERT INTO usuarios (matricula, contrasena, nombre, email) 
VALUES ('00', '123', 'Usuario Demo', 'usuario@demo.com');

-- Insertar datos de progreso de ejemplo
INSERT INTO progreso (usuario_id, curso, progreso) VALUES
(1, 'Programación Orientada a Objetos', 75),
(1, 'Introducción al cálculo', 60),
(1, 'Sistemas digitales', 45);

-- Cursos iniciales
INSERT INTO usuario_cursos_recientes (usuario_id, curso_nombre, curso_imagen, curso_pagina) VALUES
(1, 'Programación orientada a objetos', 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=400&h=300&fit=crop', 'poo_pagina.php'),
(1, 'Introducción al cálculo', 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop', 'introduccionCalculo_pagina.php'),
(1, 'Sistemas digitales', 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=400&h=300&fit=crop', 'sistemasDigitales_pagina.php');

-- Insertar logros predeterminados
INSERT INTO logros (nombre, descripcion, imagen, condicion, valor_requerido, puntos, categoria) VALUES
('Primer Paso', 'Completó su primera lección', 'https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQ4xtBbL4HB5UPZSFJmASPpXHJ6NT1JuJ5B4g&s', 'lecciones_completadas', 1, 10, 'progreso'),
('Aprendiz Curioso', 'Vió 3 lecciones diferentes', 'https://cdn-icons-png.freepik.com/512/11445/11445795.png', 'lecciones_vistas', 3, 20, 'progreso'),
('Racha Inicial', 'Mantiene una racha de 3 días', 'https://img.freepik.com/vector-premium/icono-vector-llama-fuego-logo_393879-437.jpg', 'dias_racha', 3, 30, 'dedicacion'),
('Semana Productiva', 'Mantiene una racha de 7 días', 'https://img.icons8.com/color/96/calendar.png', 'dias_racha', 7, 50, 'dedicacion'),
('Explorador', 'Visitó todos los cursos disponibles', 'https://img.icons8.com/color/96/compass.png', 'cursos_visitados', 5, 40, 'progreso'),
('Racha de Oro', '15 días consecutivos estudiando', 'https://img.icons8.com/color/96/gold-medal.png', 'dias_racha', 15, 100, 'dedicacion'),
('Maestro de la Constancia', '30 días consecutivos estudiando', 'https://img.icons8.com/color/96/trophy.png', 'dias_racha', 30, 200, 'dedicacion'),
('Nivel 5 Alcanzado', 'Subió al nivel 5', 'https://img.icons8.com/color/96/level-up.png', 'nivel_alcanzado', 5, 50, 'habilidad'),
('Nivel 10 Alcanzado', 'Subió al nivel 10', 'https://png.pngtree.com/png-vector/20240104/ourmid/pngtree-level-10-educate-png-image_11279513.png', 'nivel_alcanzado', 10, 100, 'habilidad'),
('Completista', 'Completó un curso al 100%', 'https://img.icons8.com/color/96/checkmark.png', 'curso_completado_100', 1, 150, 'especial'),
('Maratón de Estudio', 'Estudió 5 horas en total', 'https://img.icons8.com/color/96/time.png', 'horas_estudio', 5, 80, 'dedicacion'),
('Ritmo Sostenido', 'Visitó la plataforma 10 días diferentes', 'https://cdn-icons-png.flaticon.com/512/520/520647.png', 'dias_visita', 10, 70, 'dedicacion');