<?php
header('Content-Type: application/json');
include 'connection.php';

$clientId = 1; // Replace this with session-based ID when login is implemented

$sql = "SELECT name, email, company, profile_photo FROM clients WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $clientId);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode([
        'name' => $data['name'],
        'email' => $data['email'],
        'company' => $data['company'],
        'profile_photo' => $data['profile_photo']
    ]);
} else {
    echo json_encode(['error' => 'Client not found']);
}
