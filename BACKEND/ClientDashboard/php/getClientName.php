<?php
include 'connection.php';

$clientId = 1; // Hardcoded for now

$sql = "SELECT name FROM clients WHERE id = $clientId";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $data = $result->fetch_assoc();
    echo json_encode(['name' => $data['name']]);
} else {
    echo json_encode(['name' => 'Unknown']);
}