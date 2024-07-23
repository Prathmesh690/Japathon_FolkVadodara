<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];
$rounds = $_POST['rounds'];
$date = date('Y-m-d');

$sql = "INSERT INTO progress (user_id, date, rounds) VALUES ('$user_id', '$date', '$rounds')";
if ($conn->query($sql) === TRUE) {
    header("Location: dashboard.php");
    exit();
} else {
    echo "Error: " . $sql . "<br>" . $conn->error;
}

$conn->close();
?>
