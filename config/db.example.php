<?php
// Copy this file to db.php and replace the placeholders with your real MySQL credentials.
$host = 'sqlXXX.infinityfree.com';
$username = 'epiz_xxxxxxxx';
$password = 'your_database_password';
$database = 'epiz_xxxxxxxx_freelance_marketplace';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die('Database connection failed: ' . $conn->connect_error);
}

$conn->set_charset('utf8');
?>
