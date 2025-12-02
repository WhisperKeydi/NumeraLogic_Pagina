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

// Registrar visita a este curso específico (curso_id 17 para taller de algoritmos)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 17);

// Registrar el acceso a este curso
$curso_nombre = "Taller de Algoritmos";
$curso_imagen = "https://tecnologia-informatica.com/wp-content/uploads/2022/02/programacion-estructurada.jpg";
$curso_pagina = "tallerAlgo_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Taller de Algoritmos - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_azul.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">💻</div>
            <h1>Taller de Algoritmos</h1>
            <p>Aprende a diseñar soluciones eficientes y desarrolla pensamiento lógico computacional/p>
        </div>

        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                
                    <div class="topic-card">
                        <h3>Introducción a Algortimos</h3>
                        <p>Conceptos básicos, características de un algoritmo, pseudocódigo y diagramas de flujo</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_talAlg.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Estructuras de Control</h3>
                        <p>Secuencia, selección (if-else, switch) y repetición (while, for, do-while)</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_talAlg.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Estructuras de Datos Básicas</h3>
                        <p>Arrays, listas, pilas, colas y sus operaciones fundamentales</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_talAlg.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Algoritmos de Búsqueda</h3>
                        <p>Búsqueda lineal, búsqueda binaria y análisis de complejidad temporal.</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_talAlg.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Algoritmos de Ordenamiento</h3>
                        <p>Bubble sort, selection sort, insertion sort, merge sort y quicksort</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_talAlg.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Recursividad</h3>
                        <p>Concepto de recursión, casos base, problemas recursivos clásicos</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_talAlg.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                <li>Comprender los principios fundamentales del diseño de algoritmos y su representación </li>
                <li>Implementar estructuras de control para resolver problemas lógicos de manera eficiente </li>
                <li>Utilizar estructuras de datos apropiadas según las necesidades del problema </li>
                <li>Analizar la complejidad temporal y espacial de algoritmos para optimizar soluciones </li>
                <li>Desarrollar algoritmos de búsqueda y ordenamiento aplicables a diversos contextos </li>
                <li>Aplicar técnicas de recursividad para resolver problemas complejos de manera elegante </li>
                </ul>
            </div>

            <a href="Formación_inicial.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>