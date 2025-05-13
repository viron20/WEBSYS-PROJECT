<?php
include 'connection.php'; // adjust path as needed

session_start();
$clientId = 1; // Change this to the logged-in user's ID (e.g., from $_SESSION)

// Form values
$fullName = $_POST['fullName'];
$email = $_POST['emailAddress'];
$company = $_POST['companyName'];

// Handle image
$photoName = '';
if (isset($_FILES['profile_photo']) && $_FILES['profile_photo']['error'] === UPLOAD_ERR_OK) {
    $uploadDir = 'uploads/';
    $tmpName = $_FILES['profile_photo']['tmp_name'];
    $photoName = basename($_FILES['profile_photo']['name']);
    $targetPath = $uploadDir . $photoName;

    // Move uploaded file
    if (move_uploaded_file($tmpName, $targetPath)) {
        // Success
    } else {
        die("Failed to upload image.");
    }
}

// Update DB
$query = "UPDATE clients SET full_name=?, email=?, company=?, profile_photo=? WHERE id=?";
$stmt = $conn->prepare($query);
$stmt->bind_param("ssssi", $fullName, $email, $company, $photoName, $clientId);

if ($stmt->execute()) {
    header("Location: clientProfile.html"); // or show success message
} else {
    echo "Error updating profile: " . $stmt->error;
}
?>
