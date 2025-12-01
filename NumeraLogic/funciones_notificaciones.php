<?php
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