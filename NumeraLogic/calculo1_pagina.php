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

// Registrar visita a este curso específico (curso_id 6 para cal1)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 6);

// Registrar el acceso a este curso
$curso_nombre = "Cálculo I";
$curso_imagen = "https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop";
$curso_pagina = "calculo1_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo I - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_verde.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">1️⃣</div>
            <h1>Cálculo I</h1>
            <p>Domina el cálculo diferencial e integral de funciones de una variable</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                
                    <div class="topic-card">
                        <h3>Límites y Continuidad</h3>
                        <p>Definición formal de límite, teoremas de límites, continuidad y tipos de discontinuidades </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_cal1.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Derivadas</h3>
                        <p>Definición de derivada, reglas de derivación, regla de la cadena, derivadas de orden superior </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_cal1.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Aplicaciones de las Derivadas</h3>
                        <p>Razones de cambio, máximos y mínimos, optimización, análisis de curva </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_cal1.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Teorema del Valor Medio</h3>
                        <p>Teoremas de Rolle y del valor medio, aplicaciones en análisis de funciones </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_cal1.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Integrales Indefinidas</h3>
                        <p>Antiderivadas, integral indefinida, técnicas básicas de integración </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_cal1.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Integrales Definidas</h3>
                        <p>Teorema fundamental del cálculo, cálculo de áreas, aplicaciones geométricas </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_cal1.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Calcular límites usando propiedades algebraicas y teoremas fundamentales </li>
                    <li>Aplicar reglas de derivación para encontrar derivadas de funciones complejas </li>
                    <li>Resolver problemas de optimización y análisis de funciones usando derivadas </li>
                    <li>Calcular integrales indefinidas y definidas usando técnicas apropiadas </li>
                    <li>Aplicar el teorema fundamental del cálculo para resolver problemas geométricos </li>
                </ul>
            </div>

            <a href="Formación_inicial.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>