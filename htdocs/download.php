<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit();
}

header('Content-Type: text/csv');
header('Content-Disposition: attachment; filename="progress_data.csv"');

$output = fopen('php://output', 'w');
fputcsv($output, array('Name', 'Date', 'Rounds'));

$sql = "SELECT users.name, progress.date, progress.rounds 
        FROM progress 
        JOIN users ON progress.user_id = users.id";
$result = $conn->query($sql);

while ($row = $result->fetch_assoc()) {
    fputcsv($output, $row);
}

fclose($output);
$conn->close();
exit();
?>
