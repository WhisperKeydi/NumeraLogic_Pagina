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

// Registrar visita a este curso específico (curso_id 15 para sistemas digitales)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 15);

// Registrar el acceso a este curso
$curso_nombre = "Sistemas Digitales";
$curso_imagen = "https://tecnoelite.co/wp-content/uploads/2023/01/ejemplo-conversion-logica.png";
$curso_pagina = "sistemasDigitales_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistemas Digitales - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_azul.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">💻</div>
            <h1>Sistemas Digitales</h1>
            <p>Fundamentos de circuitos y lógica digital</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    <div class="topic-card">
                        <h3>Sistemas Numéricos</h3>
                        <p>Binario, octal, hexadecimal y conversiones entre sistemas</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_sisDig.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Álgebra Booleana</h3>
                        <p>Operaciones lógicas, teoremas y simplificación</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_sisDig.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Compuertas Lógicas</h3>
                        <p>AND, OR, NOT, NAND, NOR, XOR y sus aplicaciones</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_sisDig.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Lógica Combinacional</h3>
                        <p>Sumadores, multiplexores, decodificadores y comparadores</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_sisDig.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Circuitos Secuenciales</h3>
                        <p>Flip-flops, registros, contadores y máquinas de estado</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_sisDig.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Memorias Digitales</h3>
                        <p>RAM, ROM, tipos de memoria y arquitecturas</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_sisDig.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Diseñar y analizar circuitos digitales combinacionales y secuenciales</li>
                    <li>Aplicar álgebra booleana para simplificar expresiones lógicas</li>
                    <li>Comprender el funcionamiento de sistemas de memoria</li>
                    <li>Implementar soluciones digitales a problemas prácticos</li>
                </ul>
            </div>

            <a href="Ingeniería.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>