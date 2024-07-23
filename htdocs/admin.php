<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT users.name, progress.date, progress.rounds 
        FROM progress 
        JOIN users ON progress.user_id = users.id";
$result = $conn->query($sql);
$progress_data = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Panel - Japathon Tracker</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container" style="background: white; overflow:auto; max-height: 780px;">
        <h1>Admin Panel</h1>
        <a href="leaderboard.php">View Leaderboard</a>
        <a href="daily_progress.php">View Daily Progress</a>
        <a href="download.php">Download Data</a>
        <a href="index.php">Logout</a>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Date</th>
                    <th>Rounds</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($progress_data as $entry): ?>
                    <tr>
                        <td><?php echo $entry['name']; ?></td>
                        <td><?php echo $entry['date']; ?></td>
                        <td><?php echo $entry['rounds']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
