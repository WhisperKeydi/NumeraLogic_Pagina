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

// Registrar visita a este curso específico (curso_id 10 para estadística)
registrarVisitaCurso($conexion, $_SESSION['usuario_id'], 10);

// Registrar el acceso a este curso
$curso_nombre = "Estadística";
$curso_imagen = "https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop";
$curso_pagina = "estadistica_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Estadística - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_mor.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">📊</div>
            <h1>Estadística</h1>
            <p>Análisis descriptivo e inferencial</p>
        </div>

        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    <div class="topic-card">
                        <h3>Organización de Datos</h3>
                        <p>Clasificación de variables, codificación y estructuras básicas de datos</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_estad.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Variables Cualitativas</h3>
                        <p>Frecuencias, tablas de contingencia y representaciones gráficas</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_estad.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Variables Cuantitativas</h3>
                        <p>Media, mediana, varianza, desviación estándar y medidas de posición</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_estad.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Análisis Exploratorio</h3>
                        <p>Histogramas y análisis de distribución</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_estad.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Distribuciones Muestrales</h3>
                        <p>Comportamiento de la media muestral, proporciones y Teorema del Límite Central</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_estad.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Estimación Puntual</h3>
                        <p>Propiedades de los estimadores: insesgadez, consistencia y eficiencia</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_estad.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Intervalos de Confianza</h3>
                        <p>Estimación por intervalos para la media, proporción y diferencia de medias</p>
                        <<div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t7_estad.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>

                    <div class="topic-card">
                        <h3>Errores e Inferencia</h3>
                        <p>Error estándar, margen de error e interpretación de conclusiones estadísticas</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t8_estad.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>

            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Organizar y resumir grandes volúmenes de datos de manera efectiva</li>
                    <li>Interpretar medidas de tendencia central y dispersión</li>
                    <li>Realizar inferencias sobre poblaciones a partir de muestras</li>
                    <li>Construir e interpretar intervalos de confianza con precisión</li>
                </ul>
            </div>

            <a href="Matemáticas_apli.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>