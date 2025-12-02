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

// Registrar visita a este curso específico (curso_id 16 para micro)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 16);

// Registrar el acceso a este curso
$curso_nombre = "Microcontroladores";
$curso_imagen = "https://incel.edu.co/wp-content/uploads/2025/01/diferencia-entre-microcontrolador-y-microprocesador.jpg";
$curso_pagina = "micro_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Microcontroladores - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_mor.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">🔧</div>
            <h1>Microcontroladores</h1>
            <p>Programación y aplicaciones de sistemas embebidos</p>
        </div>
        
        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    <div class="topic-card">
                        <h3>Introducción a MCU</h3>
                        <p>Arquitectura, familias de microcontroladores y aplicaciones</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_micro.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Puertos de E/S</h3>
                        <p>Configuración de pines digitales, lectura y escritura</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_micro.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Interrupciones</h3>
                        <p>Vectores de interrupción, prioridades y manejo de eventos</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_micro.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Timers y Contadores</h3>
                        <p>Temporizadores, PWM y generación de señales</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_micro.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Comunicación Serial</h3>
                        <p>UART, SPI, I2C y protocolos de comunicación</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_micro.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Conversión A/D y D/A</h3>
                        <p>ADC, DAC y procesamiento de señales analógicas</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_micro.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Programar microcontroladores para aplicaciones embebidas</li>
                    <li>Diseñar circuitos con sensores y actuadores</li>
                    <li>Implementar protocolos de comunicación serial</li>
                    <li>Desarrollar proyectos de IoT y automatización</li>
                </ul>
            </div>
            
            <a href="Ingeniería.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>