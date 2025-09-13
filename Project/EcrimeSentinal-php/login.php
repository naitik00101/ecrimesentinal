<?php
session_start();
include 'db_connect.php'; // connect to DB

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $_POST['username'];
    $password = $_POST['password'];

    // Decide which table to check
    if (strpos($username, '.sentinel') !== false) {
        $table = "reg_admin";
    } else {
        $table = "register";
    }

    // Fetch user from chosen table
    $sql = "SELECT * FROM $table WHERE username = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $result = $stmt->get_result();

    if ($result->num_rows === 1) {
        $row = $result->fetch_assoc();
        
        // Verify hashed password
        if (password_verify($password, $row['password'])) {
            $_SESSION['username'] = $row['username']; // store in session

            if ($table === "reg_admin") {
                header("Location: admpanel.php");
                exit();
            } else {
                header("Location: vicpanel.php");
                exit();
            }
        } else {
            echo "Invalid password.";
        }
    } else {
        echo "No such user found.";
    }
}
?>