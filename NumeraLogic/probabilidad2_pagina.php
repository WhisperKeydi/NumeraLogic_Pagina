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

// Registrar visita a este curso específico (curso_id 12 para probabilidad)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 12);

// Registrar el acceso a este curso
$curso_nombre = "Probabilidad II";
$curso_imagen = "https://img-c.udemycdn.com/course/750x422/5122480_74db.jpg";
$curso_pagina = "probabilidad2_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Probabilidad II - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_azul.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">🎲</div>
            <h1>Probabilidad II</h1>
            <p>Variables continuas, distribuciones multivariadas y teoría límite</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    <div class="topic-card">
                        <h3>Variables Continuas</h3>
                        <p>Propiedades, integrales de probabilidad y transformaciones de variables aleatorias</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_proba2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Distribuciones Clave</h3>
                        <p>Normal, exponencial, gamma, beta, chi-cuadrada y sus aplicaciones</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_proba2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Vectores Aleatorios</h3>
                        <p>Densidad conjunta, dependencias y cálculo de probabilidades en regiones</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_proba2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Marginales y Condicionales</h3>
                        <p>Relaciones entre componentes de un vector aleatorio y distribuciones derivadas</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_proba2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Independencia y Correlación</h3>
                        <p>Indicadores estadísticos para el análisis de variabilidad y dependencia lineal</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_proba2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Momentos</h3>
                        <p>Media, varianza, covarianza y matrices de momentos de orden superior</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_proba2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Distribuciones Multivariadas</h3>
                        <p>La distribución Normal multivariada, contornos de densidad y propiedades geométricas</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t7_proba2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Convergencia</h3>
                        <p>Convergencia en probabilidad, en distribución y leyes límite (TCL)</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t8_proba2.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Modelar eventos aleatorios continuos utilizando funciones de densidad</li>
                    <li>Calcular probabilidades conjuntas y condicionales en múltiples dimensiones</li>
                    <li>Analizar la dependencia y correlación entre variables aleatorias</li>
                    <li>Aplicar los teoremas de convergencia para aproximar distribuciones</li>
                </ul>
            </div>

            <a href="Matemáticas_apli.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>