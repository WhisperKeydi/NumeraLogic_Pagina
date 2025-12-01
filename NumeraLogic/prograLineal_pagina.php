<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

if (usuarioExiste($conexion, $_SESSION['usuario_id'])) {
    $curso_nombre = "Programación Lineal";
    $curso_imagen = "https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop";
    $curso_pagina = "prograLineal_pagina.php";
    
    registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programación Lineal - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_verde.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">⚙️</div>
            <h1>Programación Lineal</h1>
            <p>Optimización de recursos y toma de decisiones efectiva</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    <div class="topic-card">
                        <h3>Fundamentos</h3>
                        <p>Introducción a los problemas de optimización y formulación de modelos matemáticos</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_proLi.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Formulación de Modelos</h3>
                        <p>Identificación de variables, restricciones y función objetivo en problemas reales</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_proLi.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Método Gráfico</h3>
                        <p>Resolución de problemas con dos variables mediante representación gráfica</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_proLi.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Método Simplex</h3>
                        <p>Algoritmo fundamental para resolver problemas de programación lineal de n variables</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_proLi.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Dualidad y Sensibilidad</h3>
                        <p>Teoría de dualidad, precios sombra y análisis post-óptimo</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_proLi.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Transporte</h3>
                        <p>Optimización de rutas de distribución y asignación de recursos</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_proLi.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Software y Excel</h3>
                        <p>Uso de Solver y herramientas computacionales para resolver problemas reales</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t7_proLi.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Optimizar recursos limitados para maximizar beneficios</li>
                    <li>Modelar problemas de la vida real matemáticamente</li>
                    <li>Aplicar el método Simplex para resolver sistemas complejos</li>
                    <li>Utilizar herramientas digitales para la toma de decisiones</li>
                </ul>
            </div>

            <a href="Matemáticas_apli.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>