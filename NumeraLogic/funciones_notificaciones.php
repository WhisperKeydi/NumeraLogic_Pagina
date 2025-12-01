<?php
// funciones_notificaciones.php

// FUNCIONES NUEVAS PARA EL SISTEMA DE RACHAS
// Función para actualizar la racha del usuario
function actualizarRacha($conexion, $usuario_id) {
    $hoy = date('Y-m-d');
    
    // Obtener registro de racha actual
    $stmt = $conexion->prepare("SELECT * FROM usuario_rachas WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows == 0) {
        // Primer registro
        $stmt = $conexion->prepare("INSERT INTO usuario_rachas (usuario_id, racha_actual, racha_max, ultima_visita) VALUES (?, 1, 1, ?)");
        $stmt->bind_param("is", $usuario_id, $hoy);
        $stmt->execute();
        $stmt->close();
        
        // Notificación de primera racha
        crearNotificacion($conexion, $usuario_id, "¡Comienza tu racha!", "Has iniciado tu racha de estudio. ¡Vuelve mañana para mantenerla!", 'logro');
        return 1;
    } else {
        $racha = $result->fetch_assoc();
        $ultima_visita = $racha['ultima_visita'];
        $racha_actual = $racha['racha_actual'];
        $racha_max = $racha['racha_max'];
        
        // Si ya visitó hoy, no hacer nada
        if ($ultima_visita == $hoy) {
            return $racha_actual;
        }
        
        // Calcular si la última visita fue ayer
        $ayer = date('Y-m-d', strtotime('-1 day'));
        if ($ultima_visita == $ayer) {
            // Incrementar racha
            $nueva_racha = $racha_actual + 1;
            $nueva_racha_max = max($racha_max, $nueva_racha);
            
            $stmt = $conexion->prepare("UPDATE usuario_rachas SET racha_actual = ?, racha_max = ?, ultima_visita = ? WHERE usuario_id = ?");
            $stmt->bind_param("iisi", $nueva_racha, $nueva_racha_max, $hoy, $usuario_id);
            $stmt->execute();
            $stmt->close();
            
            // Notificación de racha incrementada (solo si es mayor a 1)
            if ($nueva_racha > 1) {
                crearNotificacion($conexion, $usuario_id, "¡Racha de {$nueva_racha} días!", "Felicidades, has mantenido tu racha por {$nueva_racha} días consecutivos. ¡Sigue así!", 'logro');
            }
            
            return $nueva_racha;
        } else {
            // Reiniciar racha (no fue consecutivo)
            $stmt = $conexion->prepare("UPDATE usuario_rachas SET racha_actual = 1, ultima_visita = ? WHERE usuario_id = ?");
            $stmt->bind_param("si", $hoy, $usuario_id);
            $stmt->execute();
            $stmt->close();
            
            // Notificación de racha reiniciada
            crearNotificacion($conexion, $usuario_id, "Racha reiniciada", "Has roto tu racha. ¡Vuelve a empezar!", 'recordatorio');
            return 1;
        }
    }
}

// Función para obtener datos de racha
function obtenerRacha($conexion, $usuario_id) {
    $stmt = $conexion->prepare("SELECT racha_actual, racha_max FROM usuario_rachas WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if ($result->num_rows > 0) {
        return $result->fetch_assoc();
    } else {
        return ['racha_actual' => 0, 'racha_max' => 0];
    }
}

// Funciones auxiliares para el sistema de niveles
function calcularNivel($racha_max) {
    return min(50, floor($racha_max / 7) + 1);
}

function obtenerTituloNivel($racha_max) {
    $nivel = calcularNivel($racha_max);
    $titulos = [
        1 => "Principiante",
        5 => "Aprendiz",
        10 => "Estudiante",
        15 => "Avanzado", 
        20 => "Experto",
        25 => "Maestro",
        30 => "Gran Maestro"
    ];
    
    foreach(array_reverse($titulos, true) as $nivelMin => $titulo) {
        if ($nivel >= $nivelMin) {
            return $titulo;
        }
    }
    return "Principiante";
}

function calcularProgresoNivel($racha_actual) {
    return min(100, ($racha_actual % 7) * 100 / 7);
}

// FUNCIONES ORIGINALES DE NOTIFICACIONES

function obtenerNotificacionesNoLeidas($conexion, $usuario_id) {
    $sql = "SELECT * FROM notificaciones 
            WHERE usuario_id = ? AND leida = FALSE 
            ORDER BY fecha_creacion DESC 
            LIMIT 10";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $notificaciones = [];
    while ($row = $result->fetch_assoc()) {
        $notificaciones[] = $row;
    }
    $stmt->close();
    
    return $notificaciones;
}

function contarNotificacionesNoLeidas($conexion, $usuario_id) {
    $sql = "SELECT COUNT(*) as total FROM notificaciones 
            WHERE usuario_id = ? AND leida = FALSE";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $row = $result->fetch_assoc();
    $stmt->close();
    
    return $row['total'];
}

function marcarNotificacionLeida($conexion, $notificacion_id, $usuario_id) {
    $sql = "UPDATE notificaciones SET leida = TRUE 
            WHERE id = ? AND usuario_id = ?";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("ii", $notificacion_id, $usuario_id);
    $result = $stmt->execute();
    $stmt->close();
    
    return $result;
}

function marcarTodasLeidas($conexion, $usuario_id) {
    $sql = "UPDATE notificaciones SET leida = TRUE 
            WHERE usuario_id = ? AND leida = FALSE";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("i", $usuario_id);
    $result = $stmt->execute();
    $stmt->close();
    
    return $result;
}

// Función para crear notificaciones (solo una vez)
function crearNotificacion($conexion, $usuario_id, $titulo, $mensaje, $tipo) {
    $sql = "INSERT INTO notificaciones (usuario_id, titulo, mensaje, tipo) 
            VALUES (?, ?, ?, ?)";
    $stmt = $conexion->prepare($sql);
    $stmt->bind_param("isss", $usuario_id, $titulo, $mensaje, $tipo);
    $result = $stmt->execute();
    $stmt->close();
    
    return $result;
}

function formatearTiempo($fecha) {
    $fechaActual = new DateTime();
    $fechaNotificacion = new DateTime($fecha);
    $diferencia = $fechaActual->diff($fechaNotificacion);
    
    if ($diferencia->y > 0) return "Hace " . $diferencia->y . " año" . ($diferencia->y > 1 ? 's' : '');
    if ($diferencia->m > 0) return "Hace " . $diferencia->m . " mes" . ($diferencia->m > 1 ? 'es' : '');
    if ($diferencia->d > 0) return "Hace " . $diferencia->d . " día" . ($diferencia->d > 1 ? 's' : '');
    if ($diferencia->h > 0) return "Hace " . $diferencia->h . " hora" . ($diferencia->h > 1 ? 's' : '');
    if ($diferencia->i > 0) return "Hace " . $diferencia->i . " minuto" . ($diferencia->i > 1 ? 's' : '');
    
    return "Hace unos segundos";
}
?>