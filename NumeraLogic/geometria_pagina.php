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

// Registrar visita a este curso específico (curso_id 11 para geometría)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 11);

// Registrar el acceso a este curso
$curso_nombre = "Geometría Analítica";
$curso_imagen = "https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop";
$curso_pagina = "geometria_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Geometría - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_nar.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">📐</div>
            <h1>Geometría Analítica</h1>
            <p>Análisis algebraico de figuras y espacios geométricos</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    <div class="topic-card">
                        <h3>Introducción e Historia</h3>
                        <p>Panorama general del desarrollo de la geometría y su importancia actual</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_geo.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Álgebra en la Geometría</h3>
                        <p>Uso de ecuaciones, coordenadas y representación algebraica de objetos geométricos</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_geo.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Rectas y Planos</h3>
                        <p>Ecuaciones, intersecciones y distancias en 2D y 3D</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_geo.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Secciones Cónicas</h3>
                        <p>Análisis y ecuaciones de parábola, hipérbola y elipse</p>
                        <<div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_geo.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Superficies Cuadráticas</h3>
                        <p>Identificación y representación de esferas, cilindros, conos, elipsoides y paraboloides</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_geo.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Transformaciones Rígidas</h3>
                        <p>Traslaciones, rotaciones, simetrías y análisis de la ecuación cuadrática general</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_geo.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Comprender la evolución histórica del pensamiento geométrico</li>
                    <li>Modelar figuras geométricas mediante ecuaciones algebraicas</li>
                    <li>Analizar propiedades de curvas y superficies en el espacio</li>
                    <li>Aplicar transformaciones para simplificar ecuaciones complejas</li>
                </ul>
            </div>

            <a href="Matemáticas_apli.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>