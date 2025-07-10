<?php
require_once '../config/db-connection.php';

header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$uuid = $data['uuid'] ?? null;
$eventType = $data['eventType'] ?? '';
$eventDetails = $data['eventDetails'] ?? '';

if (!$uuid || !$eventType) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'UUID y eventType son requeridos.']);
    exit;
}

$eventToColumnMap = [
    'interaction.create_alarm' => 'alarms_created_total',
    'interaction.create_timer' => 'timers_created_total',
    'interaction.create_clock' => 'clocks_created_total',
    'interaction.delete_alarm' => 'alarms_deleted_total',
    'interaction.delete_timer' => 'timers_deleted_total',
    'interaction.delete_clock' => 'clocks_deleted_total',
    'interaction.edit_alarm' => 'alarms_updated_total',
    'interaction.edit_timer' => 'timers_updated_total',
    'interaction.edit_clock' => 'clocks_updated_total',
    'interaction.start_stopwatch' => 'stopwatch_starts_total',
    'interaction.stop_stopwatch' => 'stopwatch_stops_total',
    'interaction.record_lap' => 'stopwatch_laps_total',
    'interaction.reset_stopwatch' => 'stopwatch_resets_total',
    'interaction.send_suggestion' => 'suggestions_sent_total'
];

$eventKey = $eventType . '.' . $eventDetails;
$columnToIncrement = $eventToColumnMap[$eventKey] ?? null;

if (!$columnToIncrement) {
    echo json_encode(['success' => true, 'message' => 'Evento no rastreado en métricas.']);
    exit;
}

// Inserta la fila del usuario si no existe, iniciando el contador en 1.
// Si ya existe, simplemente incrementa el contador de la columna correcta.
$sql = "INSERT INTO user_metrics (user_uuid, {$columnToIncrement})
        VALUES (?, 1)
        ON DUPLICATE KEY UPDATE
        {$columnToIncrement} = {$columnToIncrement} + 1";

$stmt = $conn->prepare($sql);

if ($stmt === false) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al preparar la consulta: ' . $conn->error]);
    exit;
}

$stmt->bind_param("s", $uuid);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Métrica de usuario actualizada.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al actualizar la métrica: ' . $stmt->error]);
}

$stmt->close();
$conn->close();
?>