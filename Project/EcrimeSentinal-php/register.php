<?php
// register.php
include 'db_connect.php'; // connect to DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = $_POST['name'];
    $dob = $_POST['dob'];
    $gender = $_POST['gender'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];
    $username = $_POST['username'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    // check password match
    if ($password !== $confirm_password) {
        die("Passwords do not match.");
    }

    // hash password
    $hashed_password = password_hash($password, PASSWORD_DEFAULT);

    // decide table
    if (strpos($username, '.sentinel') !== false) {
        $table = "reg_admin";   // admins
    } else {
        $table = "register";    // victims
    }

    // insert
    $sql = "INSERT INTO $table (name, dob, gender, email, phone, address, username, password) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?)";

    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssssssss", $name, $dob, $gender, $email, $phone, $address, $username, $hashed_password);

    if ($stmt->execute()) {
    // after successful registration, go to login page
    header("Location: login.html");
      exit();
        } else {
        echo "Error: " . $stmt->error;
        }  
}
?>