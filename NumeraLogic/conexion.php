<?php
$host = "localhost";
$usuario = "root";
$password = "";
$base_datos = "numeralogic";

$conexion = new mysqli($host, $usuario, $password, $base_datos);

if ($conexion->connect_error) {
    die("Error de conexión: " . $conexion->connect_error);
}

$conexion->set_charset("utf8");

function usuarioExiste($conexion, $usuario_id) {
    $stmt = $conexion->prepare("SELECT id FROM usuarios WHERE id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $existe = $result->num_rows > 0;
    $stmt->close();
    return $existe;
}

// Función para obtener cursos recientes (MySQLi)
function obtenerCursosRecientes($conexion, $usuario_id, $limite = 4) {
    // Primero verificar si el usuario existe
    if (!usuarioExiste($conexion, $usuario_id)) {
        return [];
    }
    
    $stmt = $conexion->prepare("
        SELECT curso_nombre, curso_imagen, curso_pagina 
        FROM usuario_cursos_recientes 
        WHERE usuario_id = ? 
        ORDER BY fecha_acceso DESC 
        LIMIT ?
    ");
    $stmt->bind_param("ii", $usuario_id, $limite);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $cursos = [];
    while ($row = $result->fetch_assoc()) {
        $cursos[] = $row;
    }
    $stmt->close();
    
    return $cursos;
}

// Función para registrar acceso a curso (MySQLi) - CORREGIDA
function registrarAccesoCurso($conexion, $usuario_id, $curso_nombre, $curso_imagen, $curso_pagina) {
    // Verificar que el usuario existe antes de continuar
    if (!usuarioExiste($conexion, $usuario_id)) {
        error_log("Error: Usuario con ID $usuario_id no existe");
        return false;
    }
    
    // Primero verificar si ya existe un registro reciente
    $stmt = $conexion->prepare("
        SELECT id FROM usuario_cursos_recientes 
        WHERE usuario_id = ? AND curso_pagina = ?
    ");
    $stmt->bind_param("is", $usuario_id, $curso_pagina);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        // Actualizar fecha de acceso
        $stmt = $conexion->prepare("
            UPDATE usuario_cursos_recientes 
            SET fecha_acceso = CURRENT_TIMESTAMP 
            WHERE usuario_id = ? AND curso_pagina = ?
        ");
        $stmt->bind_param("is", $usuario_id, $curso_pagina);
        $resultado = $stmt->execute();
        $stmt->close();
        return $resultado;
    } else {
        // Insertar nuevo registro
        $stmt = $conexion->prepare("
            INSERT INTO usuario_cursos_recientes (usuario_id, curso_nombre, curso_imagen, curso_pagina) 
            VALUES (?, ?, ?, ?)
        ");
        $stmt->bind_param("isss", $usuario_id, $curso_nombre, $curso_imagen, $curso_pagina);
        $resultado = $stmt->execute();
        
        if ($resultado) {
            // Mantener solo los 4 más recientes
            $stmt = $conexion->prepare("
                DELETE FROM usuario_cursos_recientes 
                WHERE usuario_id = ? AND id NOT IN (
                    SELECT id FROM (
                        SELECT id FROM usuario_cursos_recientes 
                        WHERE usuario_id = ? 
                        ORDER BY fecha_acceso DESC 
                        LIMIT 4
                    ) temp
                )
            ");
            $stmt->bind_param("ii", $usuario_id, $usuario_id);
            $stmt->execute();
        }
        
        $stmt->close();
        return $resultado;
    }
}
?>