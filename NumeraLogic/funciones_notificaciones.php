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
                
                // VERIFICAR LOGROS DE RACHA
                verificarLogrosRacha($conexion, $usuario_id, $nueva_racha);
            }
            
            // VERIFICAR LOGROS DE NIVEL (con la racha máxima)
            $nivel = calcularNivel($nueva_racha_max);
            verificarLogrosNivel($conexion, $usuario_id, $nivel);
            
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

// ======================================================================
// FUNCIONES NUEVAS PARA EL SISTEMA DE LOGROS
// ======================================================================

// Función para verificar logros
function verificarLogros($conexion, $usuario_id, $tipo_logro, $valor_actual) {
    // Buscar logros no desbloqueados que cumplan la condición
    $stmt = $conexion->prepare("
        SELECT l.* 
        FROM logros l
        WHERE l.condicion = ? 
          AND l.valor_requerido <= ?
          AND l.id NOT IN (
              SELECT ul.logro_id 
              FROM usuario_logros ul 
              WHERE ul.usuario_id = ?
          )
    ");
    $stmt->bind_param("sii", $tipo_logro, $valor_actual, $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $logros_desbloqueados = [];
    
    while ($logro = $result->fetch_assoc()) {
        // Desbloquear logro
        $stmt2 = $conexion->prepare("INSERT INTO usuario_logros (usuario_id, logro_id) VALUES (?, ?)");
        $stmt2->bind_param("ii", $usuario_id, $logro['id']);
        $stmt2->execute();
        $stmt2->close();
        
        // Crear notificación
        crearNotificacion($conexion, $usuario_id, 
            "🏆 Logro Desbloqueado: {$logro['nombre']}", 
            $logro['descripcion'] . " (+{$logro['puntos']} puntos)", 
            'logro'
        );
        
        $logros_desbloqueados[] = $logro;
    }
    
    $stmt->close();
    return $logros_desbloqueados;
}

// Función para registrar vista de lección
function registrarVistaLeccion($conexion, $usuario_id) {
    // Actualizar estadísticas
    $stmt = $conexion->prepare("
        INSERT INTO usuario_estadisticas (usuario_id, lecciones_vistas, dias_visita) 
        VALUES (?, 1, 1)
        ON DUPLICATE KEY UPDATE 
        lecciones_vistas = lecciones_vistas + 1,
        dias_visita = IF(DATE(fecha_actualizacion) != CURDATE(), dias_visita + 1, dias_visita),
        fecha_actualizacion = CURRENT_TIMESTAMP
    ");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $stmt->close();
    
    // Obtener conteo actual de lecciones
    $stmt = $conexion->prepare("SELECT lecciones_vistas FROM usuario_estadisticas WHERE usuario_id = ?");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $lecciones_vistas = $data ? $data['lecciones_vistas'] : 0;
    $stmt->close();
    
    // Verificar logros por lecciones
    verificarLogros($conexion, $usuario_id, 'lecciones_completadas', $lecciones_vistas);
    verificarLogros($conexion, $usuario_id, 'lecciones_vistas', $lecciones_vistas);
    
    return $lecciones_vistas;
}

// Función para registrar visita a curso
function registrarVisitaCurso($conexion, $usuario_id, $curso_id) {
    // Actualizar conteo de cursos visitados
    // Primero verificar si ya visitó este curso hoy
    $stmt = $conexion->prepare("
        INSERT INTO usuario_estadisticas (usuario_id, cursos_visitados) 
        VALUES (?, 1)
        ON DUPLICATE KEY UPDATE 
        cursos_visitados = IF(
            NOT EXISTS (
                SELECT 1 FROM usuario_visitas_cursos 
                WHERE usuario_id = ? 
                AND curso_id = ? 
                AND DATE(fecha_visita) = CURDATE()
            ),
            cursos_visitados + 1,
            cursos_visitados
        ),
        fecha_actualizacion = CURRENT_TIMESTAMP
    ");
    $stmt->bind_param("iii", $usuario_id, $usuario_id, $curso_id);
    $stmt->execute();
    $stmt->close();
    
    // Registrar visita específica
    $stmt = $conexion->prepare("
        INSERT INTO usuario_visitas_cursos (usuario_id, curso_id) 
        VALUES (?, ?)
        ON DUPLICATE KEY UPDATE fecha_visita = CURRENT_TIMESTAMP
    ");
    $stmt->bind_param("ii", $usuario_id, $curso_id);
    $stmt->execute();
    $stmt->close();
    
    // Obtener conteo de cursos únicos visitados
    $stmt = $conexion->prepare("
        SELECT COUNT(DISTINCT curso_id) as total_cursos 
        FROM usuario_visitas_cursos 
        WHERE usuario_id = ?
    ");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    $data = $result->fetch_assoc();
    $total_cursos = $data ? $data['total_cursos'] : 0;
    $stmt->close();
    
    // Verificar logros por cursos visitados
    verificarLogros($conexion, $usuario_id, 'cursos_visitados', $total_cursos);
    
    return $total_cursos;
}

// Función para verificar logros de racha (llamar desde actualizarRacha)
function verificarLogrosRacha($conexion, $usuario_id, $racha_actual) {
    return verificarLogros($conexion, $usuario_id, 'dias_racha', $racha_actual);
}

// Función para verificar logros de nivel
function verificarLogrosNivel($conexion, $usuario_id, $nivel) {
    return verificarLogros($conexion, $usuario_id, 'nivel_alcanzado', $nivel);
}

// Función para obtener logros del usuario
function obtenerLogrosUsuario($conexion, $usuario_id) {
    $stmt = $conexion->prepare("
        SELECT 
            l.*,
            ul.fecha_desbloqueo,
            CASE WHEN ul.usuario_id IS NOT NULL THEN 1 ELSE 0 END as desbloqueado
        FROM logros l
        LEFT JOIN usuario_logros ul ON l.id = ul.logro_id AND ul.usuario_id = ?
        ORDER BY l.categoria, l.valor_requerido
    ");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $logros = [];
    while ($row = $result->fetch_assoc()) {
        $logros[] = $row;
    }
    $stmt->close();
    
    return $logros;
}

// Función para obtener estadísticas del usuario
function obtenerEstadisticasUsuario($conexion, $usuario_id) {
    $stmt = $conexion->prepare("
        SELECT 
            COALESCE(ue.lecciones_vistas, 0) as lecciones_vistas,
            COALESCE(ue.cursos_visitados, 0) as cursos_visitados,
            COALESCE(ue.horas_estudio, 0) as horas_estudio,
            COALESCE(ue.dias_visita, 0) as dias_visita,
            COUNT(ul.id) as logros_desbloqueados,
            COALESCE(SUM(l.puntos), 0) as puntos_totales
        FROM usuarios u
        LEFT JOIN usuario_estadisticas ue ON u.id = ue.usuario_id
        LEFT JOIN usuario_logros ul ON u.id = ul.usuario_id
        LEFT JOIN logros l ON ul.logro_id = l.id
        WHERE u.id = ?
        GROUP BY u.id, ue.lecciones_vistas, ue.cursos_visitados, ue.horas_estudio, ue.dias_visita
    ");
    $stmt->bind_param("i", $usuario_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    $estadisticas = $result->fetch_assoc();
    $stmt->close();
    
    if (!$estadisticas) {
        $estadisticas = [
            'lecciones_vistas' => 0,
            'cursos_visitados' => 0,
            'horas_estudio' => 0,
            'dias_visita' => 0,
            'logros_desbloqueados' => 0,
            'puntos_totales' => 0
        ];
    }
    
    // Agregar nivel actual
    $racha = obtenerRacha($conexion, $usuario_id);
    $estadisticas['nivel_actual'] = calcularNivel($racha['racha_max']);
    $estadisticas['racha_actual'] = $racha['racha_actual'];
    $estadisticas['racha_max'] = $racha['racha_max'];
    
    return $estadisticas;
}
?>