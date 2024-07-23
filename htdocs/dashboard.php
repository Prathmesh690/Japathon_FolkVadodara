<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: index.php");
    exit();
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT SUM(rounds) as total_rounds FROM progress WHERE user_id='$user_id'";
$result = $conn->query($sql);
$total_rounds = $result->fetch_assoc()['total_rounds'];

$sql = "SELECT * FROM progress WHERE user_id='$user_id'";
$result = $conn->query($sql);
$progress = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();

include 'dashboard.html';
?>
