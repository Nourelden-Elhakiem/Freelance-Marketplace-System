<?php
/**
 * Example Database Configuration
 *
 * Copy this file and rename it to:
 * db.php
 *
 * Then replace the placeholder values below with your real local or hosting
 * MySQL credentials.
 */

$host = 'your_mysql_host';
$username = 'your_mysql_username';
$password = 'your_mysql_password';
$database = 'your_database_name';

$conn = new mysqli($host, $username, $password, $database);

if ($conn->connect_error) {
    die('Database connection failed. Please check your database configuration.');
}

$conn->set_charset('utf8mb4');
?>
