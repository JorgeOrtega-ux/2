<?php
require_once '../config/db-connection.php';

header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$uuid = $data['uuid'] ?? null;
$eventType = $data['eventType'] ?? null;
$eventDetails = $data['eventDetails'] ?? null;

if (!$uuid || !$eventType) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'UUID y eventType son requeridos.']);
    exit;
}

$stmt = $conn->prepare("INSERT INTO user_events (user_uuid, event_type, event_details) VALUES (?, ?, ?)");
$stmt->bind_param("sss", $uuid, $eventType, $eventDetails);

if ($stmt->execute()) {
    echo json_encode(['success' => true, 'message' => 'Evento registrado.']);
} else {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => 'Error al registrar el evento.']);
}

$stmt->close();
$conn->close();
?>