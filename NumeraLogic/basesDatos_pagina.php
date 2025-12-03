<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

// Incluir conexión y funciones de notificaciones
include 'conexion.php';
include 'funciones_notificaciones.php';

// Actualizar racha del usuario al acceder al curso
actualizarRacha($conexion, $_SESSION['usuario_id']);

// Registrar visita a este curso específico (curso_id 5 para bases)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 5);

// Registrar el acceso a este curso
$curso_nombre = "Bases de Datos";
$curso_imagen = "https://img.datacentermarket.es/wp-content/uploads/2025/01/16115523/Bases-de-datos-como-Servicio-3.jpeg";
$curso_pagina = "basesDatos_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Bases de Datos - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_verde.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="Ingeniería.php" class="back-btn">←</a>
            <div class="icon">🗄️</div>
            <h1>Bases de Datos</h1>
            <p>Gestión y diseño de sistemas de información</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    <div class="topic-card">
                        <h3>Fundamentos de BD</h3>
                        <p>Conceptos básicos, tipos de bases de datos y SGBD</p>
                        <div class="button-group">
                            <a href="v1_bd.php" class="topic-btn">▶ Videos</a>
                            <a href="t1_bd.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Modelo Relacional</h3>
                        <p>Tablas, relaciones, claves primarias y foráneas</p>
                        <div class="button-group">
                            <a href="v2_bd.php" class="topic-btn">▶ Videos</a>
                            <a href="t2_bd.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>SQL</h3>
                        <p>Consultas, DDL, DML y gestión de datos con SQL</p>
                        <div class="button-group">
                            <a href="v3_bd.php" class="topic-btn">▶ Videos</a>
                            <a href="t3_bd.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Normalización</h3>
                        <p>Formas normales y optimización de estructuras</p>
                        <div class="button-group">
                            <a href="v4_bd.php" class="topic-btn">▶ Videos</a>
                            <a href="t4_bd.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Diseño de BD</h3>
                        <p>Modelo Entidad-Relación y diagramas ER</p>
                        <div class="button-group">
                            <a href="v5_bd.php" class="topic-btn">▶ Videos</a>
                            <a href="t5_bd.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Transacciones</h3>
                        <p>ACID, concurrencia y recuperación de datos</p>
                        <div class="button-group">
                            <a href="v6_bd.php" class="topic-btn">▶ Videos</a>
                            <a href="t6_bd.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Diseñar bases de datos relacionales eficientes</li>
                    <li>Escribir consultas SQL complejas para manipular datos</li>
                    <li>Normalizar esquemas de bases de datos</li>
                    <li>Implementar y gestionar sistemas de bases de datos</li>
                </ul>
            </div>

            
        </div>
    </div>
</body>
</html>