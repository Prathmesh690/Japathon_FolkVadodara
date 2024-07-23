<?php
include 'connect.php';

$name = $_POST['name'];
$phone = $_POST['phone'];
$email = $_POST['email'];
$password = $_POST['password'];

// Email validation
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    echo "<script>alert('Invalid email format');window.location.href='register.html';</script>";
    exit();
}

// Phone number validation
if (!preg_match('/^[0-9]{10}$/', $phone)) {
    echo "<script>alert('Phone number must be 10 digits');window.location.href='register.html';</script>";
    exit();
}

// Password validation (at least 8 characters, include at least one letter and one number)
if (!preg_match('/^(?=.*[A-Za-z])(?=.*\d)[A-Za-z\d]{8,}$/', $password)) {
    echo "<script>alert('Password must be at least 8 characters, include at least one letter and one number');window.location.href='register.html';</script>";
    exit();
}

$hashed_password = password_hash($password, PASSWORD_DEFAULT);

$sql = "INSERT INTO users (name, phone, email, password) VALUES ('$name', '$phone', '$email', '$hashed_password')";
if ($conn->query($sql) === TRUE) {
    echo "<script>alert('Registration successful');window.location.href='index.php';</script>";
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
