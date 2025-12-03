<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';
include 'funciones_notificaciones.php';

actualizarRacha($conexion, $_SESSION['usuario_id']);
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 2); // curso_id 2 para Cálculo

$curso_nombre = "Introducción al cálculo";
$curso_imagen = "https://encrypted-tbn0.gstatic.com/images?q=tbn:ANd9GcQTViThG8n-FveIk0zABfYQg1UKXiIQAq8F6g&s";
$curso_pagina = "introduccionCalculo_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Introducción al Cálculo - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_nar.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="Formación_inicial.php" class="back-btn">←</a>
            <div class="icon">📊</div>
            <h1>Introducción al Cálculo</h1>
            <p>Prepárate para el cálculo con límites, continuidad y conceptos fundamentales</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                
                    <div class="topic-card">
                        <h3>Funciones y Precálculo</h3>
                        <p>Repaso de funciones, dominio, rango, composición de funciones y funciones inversas</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_introCal.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Límites Intuitivos</h3>
                        <p>Concepto intuitivo de límite, interpretación gráfica y evaluación básica</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_introCal.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Propiedades de Límites</h3>
                        <p>Leyes de los límites, límites laterales, límites al infinito</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_introCal.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Continuidad</h3>
                        <p>Definición de continuidad, tipos de discontinuidades, teorema del valor intermedio</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_introCal.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Introducción a la Derivada</h3>
                        <p>Concepto de razón de cambio, pendiente de la recta tangente, definición de derivada </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_introCal.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Aplicaciones Básicas</h3>
                        <p>Problemas de tasas de cambio en contextos reales y preparación para cálculo diferencial </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_introCal.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Comprender el concepto de límite y su interpretación tanto gráfica como analítica </li>
                    <li>Evaluar límites utilizando propiedades algebraicas y técnicas básicas </li>
                    <li>Determinar la continuidad de funciones e identificar puntos de discontinuidad </li>
                    <li>Interpretar la derivada como razón de cambio instantánea y pendiente de recta tangente </li>
                    <li>Aplicar conceptos de límites y continuidad para resolver problemas prácticos </li>
                </ul>
            </div>

            
        </div>
    </div>
</body>
</html>