<?php
$servername = "localhost";
$username = "root";
$password = ""; // Default password is empty in XAMPP
$dbname = "profolio_system"; // updated database name

// Create connection
$con = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($con->connect_error) {
    die("Connection failed: " . $con->connect_error);
}
echo "Connected successfully to MySQL database!";
?>
