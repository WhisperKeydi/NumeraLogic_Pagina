<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

if (usuarioExiste($conexion, $_SESSION['usuario_id'])) {
    $curso_nombre = "Sistemas Operativos";
    $curso_imagen = "https://images.unsplash.com/photo-1635070041078-e363dbe005cb?w=400&h=300&fit=crop";
    $curso_pagina = "sistemaOp_pagina.php";
    
    registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
}
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Sistemas Operativos - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_verde.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">📱</div>
            <h1>Sistemas Operativos</h1>
            <p>Gestión de recursos y administración de sistemas</p>
        </div>
        
        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    <div class="topic-card">
                        <h3>Introducción a SO</h3>
                        <p>Conceptos básicos, funciones y tipos de sistemas operativos</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_sisOp.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Gestión de Procesos</h3>
                        <p>Creación, estados, hilos y planificación de procesos</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_sisOp.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Concurrencia</h3>
                        <p>Semáforos, mutex, condiciones de carrera y deadlocks</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_sisOp.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Gestión de Memoria</h3>
                        <p>Paginación, segmentación y memoria virtual</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_sisOp.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Sistemas de Archivos</h3>
                        <p>Estructura, organización y gestión de archivos</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_sisOp.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Seguridad y Protección</h3>
                        <p>Autenticación, autorización y cifrado de datos</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_sisOp.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Comprender el funcionamiento interno de un sistema operativo</li>
                    <li>Gestionar procesos, hilos y sincronización</li>
                    <li>Administrar memoria y sistemas de archivos</li>
                    <li>Implementar soluciones de seguridad y protección</li>
                </ul>
            </div>
            
            <a href="Ingeniería.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>