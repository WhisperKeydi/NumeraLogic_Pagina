<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

// Verificar que el usuario existe antes de registrar el curso
if (usuarioExiste($conexion, $_SESSION['usuario_id'])) {
    // Registrar el acceso a este curso
    $curso_nombre = "Álgebra Lineal";
    $curso_imagen = "https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop";
    $curso_pagina = "algebraLineal_pagina.php";
    
    registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
}
?>
<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Álgebra Lineal - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_azul.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">🧮</div>
            <h1>Álgebra lineal</h1>
            <p>Vectores, matrices, sistemas y transformaciones</p>
        </div>
        
        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    
                    <div class="topic-card">
                        <h3>Geometría del Plano y el Espacio</h3>
                        <p>Puntos, rectas, planos, distancias y vectores en 2D y 3D </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_alg.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Sistemas de Ecuaciones Lineales</h3>
                        <p>Planteamiento, solución y clasificación de sistemas </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_alg.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Matrices</h3>
                        <p>Tipos de matrices, operaciones y aplicaciones</p>

                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_alg.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Determinantes</h3>
                        <p>Cálculo de determinantes y su uso en sistemas </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_alg.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Espacios Vectoriales</h3>
                        <p>Vectores, bases, dimensión y subespacios </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_alg.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Transformaciones Lineales</h3>
                        <p>Aplicaciones lineales, núcleo e imagen </p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_alg.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                </div>
            </div>
            
            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                   <li>Resolver sistemas de ecuaciones lineales mediante distintos métodos</li>
                    <li>Operar con matrices y aplicar sus propiedades</li>
                    <li>Calcular determinantes y utilizarlos en problemas algebraicos</li>
                    <li>Comprender y aplicar conceptos de espacios vectoriales y transformación lineal</li>
                </ul>
            </div>
            
            <a href="Formación_inicial.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>