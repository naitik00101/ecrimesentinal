<?php
$servername = "localhost";
$db_username = "root";
$db_password = "";
$dbname = "ecrime_sentinal";

$conn = new mysqli($servername, $db_username, $db_password, $dbname, 3300);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}