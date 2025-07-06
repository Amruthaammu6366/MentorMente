
<?php
// Database configuration for mentormentee project
$host = 'localhost';
$db   = 'mentormentee';
$user = 'root'; // Change as per your MySQL setup
$pass = '';

$conn = new mysqli($host, $user, $pass, $db);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}
?>
