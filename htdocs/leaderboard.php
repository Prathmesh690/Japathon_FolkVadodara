<?php
session_start();
include 'connect.php';

if (!isset($_SESSION['user_id']) || !$_SESSION['is_admin']) {
    header("Location: index.php");
    exit();
}

$sql = "SELECT users.name, SUM(progress.rounds) as total_rounds
        FROM progress
        JOIN users ON progress.user_id = users.id
        GROUP BY users.name
        ORDER BY total_rounds DESC";
$result = $conn->query($sql);
$leaderboard_data = $result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Leaderboard - Japathon Tracker</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container" style="background: white; overflow:auto; max-height: 780px;">
        <h1>Leaderboard</h1>
        <a href="admin.php">Back to Admin Panel</a>
        <a href="download.php">Download Data</a>
        <a href="index.php">Logout</a>
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Total Rounds</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($leaderboard_data as $entry): ?>
                    <tr>
                        <td><?php echo $entry['name']; ?></td>
                        <td><?php echo $entry['total_rounds']; ?></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    </div>
</body>
</html>
