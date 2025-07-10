<?php
require_once '../config/db-connection.php';

header('Content-Type: application/json');

$input = file_get_contents('php://input');
$data = json_decode($input, true);

$uuid = $data['uuid'] ?? null;
$country = $data['country'] ?? 'Unknown';
$os = $data['os'] ?? 'Unknown';
$browser = $data['browser'] ?? 'Unknown';
$browser_version = $data['browser_version'] ?? 'Unknown';
$language = $data['language'] ?? 'Unknown';

if (!$uuid) {
    http_response_code(400);
    echo json_encode(['success' => false, 'message' => 'UUID es requerido.']);
    exit;
}

$stmt = $conn->prepare("SELECT id FROM user_activity WHERE uuid = ?");
$stmt->bind_param("s", $uuid);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    // Usuario Existente: Actualiza la actividad y la información del navegador/idioma
    $updateStmt = $conn->prepare("UPDATE user_activity SET last_activity = NOW(), browser = ?, browser_version = ?, preferred_language = ? WHERE uuid = ?");
    $updateStmt->bind_param("ssss", $browser, $browser_version, $language, $uuid);
    
    if ($updateStmt->execute()) {
        echo json_encode(['success' => true, 'status' => 'updated']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al actualizar la actividad.']);
    }
    $updateStmt->close();

} else {
    // Nuevo Usuario: Inserta registro completo
    $insertStmt = $conn->prepare("INSERT INTO user_activity (uuid, country, operating_system, browser, browser_version, preferred_language) VALUES (?, ?, ?, ?, ?, ?)");
    $insertStmt->bind_param("ssssss", $uuid, $country, $os, $browser, $browser_version, $language);

    if ($insertStmt->execute()) {
        http_response_code(201);
        echo json_encode(['success' => true, 'status' => 'created']);
    } else {
        http_response_code(500);
        echo json_encode(['success' => false, 'message' => 'Error al registrar el nuevo usuario.']);
    }
    $insertStmt->close();
}

$stmt->close();
$conn->close();
?>