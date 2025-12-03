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

// Registrar visita a este curso específico (curso_id 4 para arqui)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 4);

// Registrar el acceso a este curso
$curso_nombre = "Arquitectura de Computadoras";
$curso_imagen = "https://images.unsplash.com/photo-1700427296131-0cc4c4610fc6?fm=jpg&ixid=M3wxMjA3fDB8MHxwaG90by1wYWdlfHx8fGVufDB8fHx8fA%3D%3D&ixlib=rb-4.1.0&q=60&w=3000";
$curso_pagina = "arqui_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Arquitectura de Computadoras - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_azul.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="Ingeniería.php" class="back-btn">←</a>
            <div class="icon">🖥️</div>
            <h1>Arquitectura de Computadoras</h1>
            <p>Organización y diseño de sistemas computacionales</p>
        </div>
        
        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    
                    <div class="topic-card">
                        <h3>Modelo de Von Neumann</h3>
                        <p>Arquitectura básica, CPU, memoria y buses de datos.</p>
                        <div class="button-group">
                            <a href="v1_arqui.php" class="topic-btn">▶ Videos</a>
                            <a href="t1_arqui.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Unidad Central de Proceso</h3>
                        <p>ALU, registros, unidad de control y ciclo de instrucción.</p>
                        <div class="button-group">
                            <a href="v2_arqui.php" class="topic-btn">▶ Videos</a>
                            <a href="t2_arqui.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Ensamblador</h3>
                        <p>Lenguaje máquina, instrucciones y programación en bajo nivel.</p>
                        <div class="button-group">
                            <a href="v3_arqui.php" class="topic-btn">▶ Videos</a>
                            <a href="t3_arqui.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Jerarquía de Memoria</h3>
                        <p>Cache, RAM, memoria virtual y gestión de memoria.</p>
                        <div class="button-group">
                            <a href="v4_arqui.php" class="topic-btn">▶ Videos</a>
                            <a href="t4_arqui.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Segmentación y Pipeline</h3>
                        <p>Procesamiento paralelo, hazards y optimización.</p>
                        <div class="button-group">
                            <a href="v5_arqui.php" class="topic-btn">▶ Videos</a>
                            <a href="t5_arqui.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Entrada/Salida</h3>
                        <p>Dispositivos periféricos, DMA y controladores.</p>
                        <div class="button-group">
                            <a href="v6_arqui.php" class="topic-btn">▶ Videos</a>
                            <a href="t6_arqui.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Comprender la organización interna de un computador</li>
                    <li>Analizar el rendimiento y optimización de sistemas</li>
                    <li>Programar en lenguaje ensamblador</li>
                    <li>Diseñar y evaluar arquitecturas computacionales</li>
                </ul>
            </div>
            
            
        </div>
    </div>
</body>
</html>