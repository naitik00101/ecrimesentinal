<?php
$servername   = "localhost";
$db_username  = "root";
$db_password  = "";
$dbname       = "ecrime_sentinal";

$conn = new mysqli($servername, $db_username, $db_password, $dbname);

if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

$name      = $_POST['name'];
$dob       = $_POST['dob'];
$gender    = $_POST['gender'];
$email     = $_POST['email'];
$phone     = $_POST['phone'];
$address   = $_POST['address'];
$username  = $_POST['username'];
$password  = $_POST['password'];
$confirm   = $_POST['confirm_password'];

if ($password !== $confirm) {
    die("Error: Passwords do not match!");
}

$hashed_password = password_hash($password, PASSWORD_BCRYPT);

$stmt = $conn->prepare("INSERT INTO register 
    (name, dob, gender, email, phone, address, username, password) 
    VALUES (?, ?, ?, ?, ?, ?, ?, ?)");

$stmt->bind_param("ssssssss", $name, $dob, $gender, $email, $phone, $address, $username, $hashed_password);

if ($stmt->execute()) {
    header("Location: victimform.html");
    exit();
} else {
    echo "Error: " . $stmt->error;
}

$stmt->close();
$conn->close();
?>
