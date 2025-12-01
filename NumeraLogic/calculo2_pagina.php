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

// Registrar visita a este curso específico (curso_id 7 para cal2)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 7);

// Registrar el acceso a este curso
$curso_nombre = "Cálculo II";
$curso_imagen = "https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop";
$curso_pagina = "calculo2_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo II - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_mor.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">2️⃣</div>
            <h1>Cálculo II</h1>
            <p>Técnicas avanzadas de integración, series y sucesiones</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                
                    <div class="topic-card">
                        <h3>Técnicas de Integración</h3>
                        <p>Integración por partes, sustitución trigonométrica, fracciones parciales </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_c2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Aplicaciones de la Integral</h3>
                        <p>Cálculo de áreas, volúmenes de revolución, longitud de arco, trabajo </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_c2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Integrales Impropias</h3>
                        <p>Integrales con límites infinitos, integrales con discontinuidades </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_c2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Sucesiones y Series</h3>
                        <p>Convergencia de sucesiones, series infinitas, criterios de convergencia </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_c2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Series de Potencias</h3>
                        <p>eries de Taylor y Maclaurin, radio de convergencia, aplicaciones </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_c2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Ecuaciones Paramétricas y Polares</h3>
                        <p>Curvas paramétricas, coordenadas polares, áreas en coordenadas polares </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_c2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Aplicar técnicas avanzadas de integración para resolver integrales complejas </li>
                    <li>Calcular volúmenes, áreas y otras aplicaciones geométricas usando integrales </li>
                    <li>Determinar la convergencia o divergencia de series infinitas </li>
                    <li>Representar funciones mediante series de potencias y series de Taylor </li>
                    <li>Trabajar con ecuaciones paramétricas y coordenadas polares en problemas aplicados </li>
                </ul>
            </div>

            <a href="Formación_inicial.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>