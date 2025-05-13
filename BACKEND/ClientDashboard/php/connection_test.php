<?php
$host = 'localhost';
$user = 'root';
$password = '';
$dbname = 'profolio_system'; // ✅ Correct database name

$conn = new mysqli($host, $user, $password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}
?>

