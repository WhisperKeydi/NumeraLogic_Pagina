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

-- Insertar usuario de prueba (ID 1)
INSERT INTO usuarios (matricula, contrasena, nombre, email) 
VALUES ('00', '123', 'Usuario Demo', 'usuario@demo.com');

-- Insertar datos de progreso de ejemplo
INSERT INTO progreso (usuario_id, curso, progreso) VALUES
(1, 'Programación Orientada a Objetos', 75),
(1, 'Introducción al cálculo', 60),
(1, 'Sistemas digitales', 45);

-- Cursos iniciales (si no hay cursos se agregan estos 3)
INSERT INTO usuario_cursos_recientes (usuario_id, curso_nombre, curso_imagen, curso_pagina) VALUES
(1, 'Programación orientada a objetos', 'https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=400&h=300&fit=crop', 'poo_pagina.php'),
(1, 'Introducción al cálculo', 'https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop', 'introduccionCalculo_pagina.php'),
(1, 'Sistemas digitales', 'https://images.unsplash.com/photo-1518770660439-4636190af475?w=400&h=300&fit=crop', 'sistemasDigitales_pagina.php');


-- Tabla de notificaciones --
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