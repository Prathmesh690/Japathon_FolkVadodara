<?php
session_start();
include 'connect.php';

$email = $_POST['email'];
$password = $_POST['password'];

$sql = "SELECT * FROM users WHERE email='$email'";
$result = $conn->query($sql);

if ($result->num_rows > 0) {
    $row = $result->fetch_assoc();
    if (password_verify($password, $row['password'])) {
        $_SESSION['user_id'] = $row['id'];
        $_SESSION['name'] = $row['name'];
        $_SESSION['is_admin'] = $row['is_admin'];
        if ($row['is_admin']) {
            header("Location: admin.php");
        } else {
            header("Location: dashboard.php");
        }
    } else {
        echo "<script>alert('Invalid password');window.location.href='index.php';</script>";
    }
} else {
    echo "<script>alert('No user found with that email');window.location.href='index.php';</script>";
}

$conn->close();
?>
