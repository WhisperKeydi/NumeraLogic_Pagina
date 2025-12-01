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

// Registrar visita a este curso específico (curso_id 8 para calIV)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 8);

// Registrar el acceso a este curso
$curso_nombre = "Cálculo IV";
$curso_imagen = "https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop";
$curso_pagina = "calculoiv_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Cálculo IV - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_azul.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">∫</div>
            <h1>Cálculo IV</h1>
            <p>Análisis vectorial e integración múltiple en espacios euclidianos</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    <div class="topic-card">
                        <h3>Integración Múltiple</h3>
                        <p>Introducción a integrales dobles y triples y sus aplicaciones</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_caliv.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Cambio de Variables</h3>
                        <p>Transformaciones como coordenadas polares, cilíndricas y esféricas</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_caliv.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Curvas y Campos</h3>
                        <p>Representación, longitud de arco y análisis de campos en el plano y espacio</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_caliv.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Integración en Curvas</h3>
                        <p>Integrales de línea para campos escalares y vectoriales</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_caliv.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Superficies</h3>
                        <p>Áreas, orientación y flujos de campos vectoriales en superficies parametrizadas</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_caliv.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Teoremas Fundamentales</h3>
                        <p>Green, Gauss y Stokes, con aplicaciones físicas y geométricas</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_caliv.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Calcular volúmenes y áreas utilizando integrales múltiples</li>
                    <li>Aplicar cambios de coordenadas para simplificar problemas complejos</li>
                    <li>Analizar el comportamiento de campos vectoriales en el espacio</li>
                    <li>Utilizar los teoremas integrales para resolver problemas </li>
                </ul>
            </div>

            <a href="Matemáticas_apli.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>