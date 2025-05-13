<?php
session_start();
include 'connection.php'; // your DB connection

if (!isset($_SESSION['client_id'])) {
    die("Unauthorized access.");
}

$clientID = $_SESSION['client_id'];
$fullName = trim($_POST['fullName']);
$email = trim($_POST['emailAddress']);
$company = trim($_POST['companyName']);
$profilePhoto = null;

if ($_FILES['profile_photo']['name']) {
    $targetDir = "uploads/";
    if (!is_dir($targetDir)) {
        mkdir($targetDir, 0755, true);
    }

    $fileName = basename($_FILES['profile_photo']['name']);
    $fileExt = strtolower(pathinfo($fileName, PATHINFO_EXTENSION));
    $allowedTypes = ['jpg', 'jpeg', 'png', 'gif'];

    if (in_array($fileExt, $allowedTypes)) {
        $newName = "client_" . $clientID . "_" . time() . "." . $fileExt;
        $targetFile = $targetDir . $newName;

        if (move_uploaded_file($_FILES['profile_photo']['tmp_name'], $targetFile)) {
            $profilePhoto = $targetFile;
        } else {
            echo "Failed to upload image.";
            exit;
        }
    } else {
        echo "Invalid file type.";
        exit;
    }
}

// Prepare SQL
$sql = "UPDATE clients SET name = ?, email = ?, company = ?";
$params = [$fullName, $email, $company];
$types = "sss";

if ($profilePhoto) {
    $sql .= ", profile_photo = ?";
    $params[] = $profilePhoto;
    $types .= "s";
}

$sql .= " WHERE id = ?";
$params[] = $clientID;
$types .= "i";

$stmt = $conn->prepare($sql);
$stmt->bind_param($types, ...$params);

if ($stmt->execute()) {
    header("Location: clientProfile.html?updated=1");
    exit;
} else {
    echo "Database error: " . $stmt->error;
}
?>

