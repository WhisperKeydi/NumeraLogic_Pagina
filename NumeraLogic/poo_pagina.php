<?php
session_start();
if (!isset($_SESSION['usuario_id'])) {
    header("Location: login.php");
    exit();
}

include 'conexion.php';

// Registrar el acceso a este curso
$curso_nombre = "Programación Orientada a Objetos";
$curso_imagen = "https://images.unsplash.com/photo-1461749280684-dccba630e2f6?w=400&h=300&fit=crop";
$curso_pagina = "poo_pagina.php";

registrarAccesoCurso($conexion, $_SESSION['usuario_id'], $curso_nombre, $curso_imagen, $curso_pagina);
?>

<!DOCTYPE html>
<html lang="es">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Programación Orientada a Objetos - NumeraLogic</title>
    <link rel="stylesheet" href="css/cursos_nar.css">
</head>
<body>
    <div class="container">
        <div class="header">
            <div class="icon">🔷</div>
            <h1>Programación Orientada a Objetos</h1>
            <p>Paradigma de programación moderno y eficiente</p>
        </div>
        
        <div class="content">
            <div class="section">
                <h2>📚 Temas del Curso</h2>
                <div class="topics">
                    <div class="topic-card">
                        <h3>Conceptos Básicos POO</h3>
                        <p>Paradigmas, abstracción y pensamiento orientado a objetos</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t1_poo.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Clases y Objetos</h3>
                        <p>Definición, instanciación, atributos y métodos</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t2_poo.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Encapsulamiento</h3>
                        <p>Modificadores de acceso, getters, setters y ocultamiento</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t3_poo.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Herencia</h3>
                        <p>Jerarquías de clases, superclases y subclases</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t4_poo.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Polimorfismo</h3>
                        <p>Sobrecarga, sobreescritura e interfaces</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t5_poo.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                    <div class="topic-card">
                        <h3>Patrones de Diseño</h3>
                        <p>Singleton, Factory, Observer y mejores prácticas</p>
                        <div class="button-group">
                            <a href="#" class="topic-btn">▶ Videos</a>
                            <a href="t6_poo.php" class="topic-btn">📄 Notas</a>
                        </div>
                    </div>
                </div>
            </div>
            
            <div class="section">
                <h2>🎯 Objetivos de Aprendizaje</h2>
                <p>Al finalizar este curso serás capaz de:</p>
                <ul style="margin-top: 15px; line-height: 2; margin-left: 20px;">
                    <li>Diseñar y desarrollar aplicaciones usando POO</li>
                    <li>Aplicar los pilares de POO: encapsulamiento, herencia y polimorfismo</li>
                    <li>Implementar patrones de diseño en proyectos reales</li>
                    <li>Crear código modular, reutilizable y mantenible</li>
                </ul>
            </div>
            
            <a href="Ingeniería.php" class="back-btn">← Explorar más cursos</a>
        </div>
    </div>
</body>
</html>