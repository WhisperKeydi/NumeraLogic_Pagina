<?php
include 'conexion.php';
include 'funciones_notificaciones.php';

// Insertar notificaciones de ejemplo para el usuario 1
crearNotificacion($conexion, 1, '¡Nuevo logro desbloqueado!', 'Has completado 10 ejercicios de cálculo.', 'logro');
crearNotificacion($conexion, 1, 'Nuevo contenido disponible', 'Se ha añadido un nuevo módulo a Programación Estructurada.', 'curso');
crearNotificacion($conexion, 1, 'Recordatorio de estudio', 'No olvides practicar hoy para mantener tu racha.', 'recordatorio');
crearNotificacion($conexion, 1, 'Has subido de nivel', 'Felicidades, ahora eres Nivel 12.', 'logro');

echo "Notificaciones de ejemplo insertadas correctamente";
?>