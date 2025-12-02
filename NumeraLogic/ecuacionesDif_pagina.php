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

// Registrar visita a este curso específico (curso_id 9 para ecuaciones diferenciales)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 9);

// Registrar el acceso a este curso
$curso_nombre = "Ecuaciones Diferenciales";
$curso_imagen = "https://ecuaciondiferencialejerciciosresueltos.com/wp-content/uploads/2014/05/atptL.png";
$curso_pagina = "ecuacionesDif_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Ecuaciones Diferenciales - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_verde.css">
</head>

<body>
    <div class="container">
        <div class="header">
            <div class="icon">📐</div>
            <h1>Ecuaciones Diferenciales</h1>
            <p>Domina las técnicas analíticas y numéricas para problemas complejos</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    
                    <div class="topic-card">
                        <h3>Introducción a EDOs</h3>
                        <p>Conceptos básicos, tipos y aplicaciones en ciencias e ingeniería.</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_ecDif.php" class="topic-btn">📄 Textos</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>EDOs de primer orden</h3>
                        <p>Métodos de solución: variables separables, lineales y exactas.</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_ecDif.php" class="topic-btn">📄 Textos</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>EDOs de segundo orden</h3>
                        <p>Solución de ecuaciones lineales con coeficientes constantes y homogéneas.</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_ecDif.php" class="topic-btn">📄 Textos</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>EDOs de orden n</h3>
                        <p>Extensión de métodos para ecuaciones lineales de orden superior.</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_ecDif.php" class="topic-btn">📄 Textos</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Sistemas de ecuaciones</h3>
                        <p>Análisis y solución de sistemas lineales usando métodos matriciales.</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_ecDif.php" class="topic-btn">📄 Textos</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Introducción a EDP</h3>
                        <p>Concepto básico, diferencias con EDO y ejemplos típicos.</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_ecDif.php" class="topic-btn">📄 Textos</a>
                        </div>
                    </div>

                </div>
            </div>

            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Identificar y resolver ecuaciones diferenciales de primer orden, segundo orden y de orden n.</li>
                    <li>Aplicar métodos analíticos fundamentales para la solución de EDO en problemas de ciencia e ingeniería.</li>
                    <li>Modelar fenómenos físicos utilizando ecuaciones diferenciales y sistemas de EDO.</li>
                    <li>Analizar sistemas de ecuaciones diferenciales y comprender su comportamiento y estabilidad.</li>
                </ul>
            </div>

            <a href="Matemáticas_apli.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>

</html>