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

// Registrar visita a este curso específico (curso_id 18 para taller de matemáticas)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 18);

// Registrar el acceso a este curso
$curso_nombre = "Taller de Matemáticas";
$curso_imagen = "https://matematicasiesoja.wordpress.com/wp-content/uploads/2021/12/0a1-61.png";
$curso_pagina = "tallerMate_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller de Matemáticas - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_verde.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <a href="Formación_inicial.php" class="back-btn">←</a>
            <div class="icon">📐</div>
            <h1>Taller de Matemáticas</h1>
            <p>Fortalece tus bases matemáticas con ejercicios prácticos y teoría fundamental</p>
        </div>
        
        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    
                    <div class="topic-card">
                        <h3>Números y Operaciones</h3>
                        <p>Números naturales, enteros, racionales e irracionales. Operaciones fundamentales.</p>
                        <div class="button-group">
                            <a href="v1_talMa.php" class="topic-btn">▶ Videos</a>
                            <a href="t1_talMa.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Álgebra Básica</h3>
                        <p>Expresiones algebraicas, ecuaciones lineales, factorización y productos notables.</p>
                        <div class="button-group">
                            <a href="v2_talMa.php" class="topic-btn">▶ Videos</a>
                            <a href="t2_talMa.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Geometría Plana</h3>
                        <p>Figuras geométricas, teorema de Pitágoras, áreas, perímetros y triángulos.</p>
                        <div class="button-group">
                            <a href="v3_talMa.php" class="topic-btn">▶ Videos</a>
                            <a href="t3_talMa.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Funciones y Gráficas</h3>
                        <p>Concepto de función, dominio y rango, funciones lineales y cuadráticas.</p>
                        <div class="button-group">
                            <a href="v4_talMa.php" class="topic-btn">▶ Videos</a>
                            <a href="t4_talMa.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Trigonometría Básica</h3>
                        <p>Razones trigonométricas, triángulos rectángulos e identidades fundamentales.</p>
                        <div class="button-group">
                            <a href="v5_talMa.php" class="topic-btn">▶ Videos</a>
                            <a href="t5_talMa.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Estadística Descriptiva</h3>
                        <p>Medidas de tendencia central, dispersión y representación gráfica de datos.</p>
                        <div class="button-group">
                            <a href="v6_talMa.php" class="topic-btn">▶ Videos</a>
                            <a href="t6_talMa.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Dominar las operaciones básicas con números y comprender sus propiedades.</li>
                    <li>Resolver ecuaciones algebraicas y aplicar técnicas de factorización.</li>
                    <li>Identificar y calcular propiedades geométricas de figuras planas.</li>
                    <li>Analizar y graficar funciones matemáticas básicas en el plano cartesiano.</li>
                    <li>Aplicar conceptos trigonométricos para resolver problemas prácticos.</li>
                    <li>Organizar e interpretar datos utilizando herramientas estadísticas básicas.</li>
                </ul>
            </div>
            
            
        </div>
    </div>
</body>
</html>