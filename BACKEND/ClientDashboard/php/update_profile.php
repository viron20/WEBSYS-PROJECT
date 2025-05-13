<?php
session_start();
include '../../auth-app/connection.php'; // Adjust path to your DB connection

// Ensure user is logged in
if (!isset($_SESSION['user'])) {
    header('Location: ../../auth-app/login.php');
    exit();
}

$user_id = $_SESSION['user']['id']; // Assumes you have an 'id' field

// Sanitize input
$full_name = trim($_POST['full_name']);
$email = trim($_POST['email']);
$company = trim($_POST['company'] ?? '');

// Basic validation
if ($full_name === '' || $email === '') {
    echo "Full name and email are required.";
    exit();
}

// Update query
$sql = "UPDATE users SET first_name = ?, email = ?, company_name = ? WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("sssi", $full_name, $email, $company, $user_id);

if ($stmt->execute()) {
    // Update session values
    $_SESSION['user']['first_name'] = $full_name;
    $_SESSION['user']['email'] = $email;
    $_SESSION['user']['company_name'] = $company;

    header('Location: clientProfile.php?updated=true');
    exit();
} else {
    echo "Error updating profile.";
}
