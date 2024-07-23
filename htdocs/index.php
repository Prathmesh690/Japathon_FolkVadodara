<?php
include 'connect.php';

// Fetch leaderboard data
$leaderboard_sql = "SELECT users.name, SUM(progress.rounds) as total_rounds 
                    FROM progress 
                    JOIN users ON progress.user_id = users.id 
                    GROUP BY progress.user_id 
                    ORDER BY total_rounds DESC";
$leaderboard_result = $conn->query($leaderboard_sql);
$leaderboard = $leaderboard_result->fetch_all(MYSQLI_ASSOC);

// Fetch accomplished rounds till now
$accomplished_sql = "SELECT SUM(rounds) as accomplished_rounds FROM progress";
$accomplished_result = $conn->query($accomplished_sql);
$accomplished_rounds = $accomplished_result->fetch_assoc()['accomplished_rounds'];

// Calculate remaining rounds
$target_rounds = 25108;
$remaining_rounds = $target_rounds - $accomplished_rounds;

// Fetch today's total chanting
$today = date('Y-m-d');
$todays_sql = "SELECT SUM(rounds) as todays_rounds FROM progress WHERE date = '$today'";
$todays_result = $conn->query($todays_sql);
$todays_rounds = $todays_result->fetch_assoc()['todays_rounds'];

// Fetch daily progress
$daily_sql = "SELECT date, SUM(rounds) as rounds FROM progress GROUP BY date ORDER BY date DESC";
$daily_result = $conn->query($daily_sql);
$daily_progress = $daily_result->fetch_all(MYSQLI_ASSOC);

$conn->close();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Japathon Tracker</title>
    <link rel="stylesheet" type="text/css" href="style.css">
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Poppins:ital,wght@0,100;0,200;0,300;0,400;0,500;0,600;0,700;0,800;0,900;1,100;1,200;1,300;1,400;1,500&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.rawgit.com/objectivehtml/FlipClock/master/compiled/flipclock.css">
</head>
<body>
    <div class="cont" style="   
    display: flex;
    flex-direction: column;
    align-content: center;
    justify-content: center;
    align-items: center;
    height: 100%;">
        <div class="container">
            <div class="headr">
                <h1 style="font-size:2.5rem;">Japathon Tracker</h1>
            </div>
            
            <div class="progress-section" style="display: flex;
    flex-direction: column;
    justify-content: center;
    align-items: center;">
                <h2 style="font-size:50px"> Seva Target: 25,108 Rounds</h2>
                <h3>Seva Accomplished Till Now: <?php echo $accomplished_rounds; ?></h3>
                <h3>Balanced Target: <?php echo $remaining_rounds; ?></h3>
                <h3>Today's Total Chanting: <?php echo $todays_rounds; ?></h3>
            </div>
            <div class="flip-clock-container" style="display: flex; justify-content: center; align-items: center; margin-top: 20px;">
                <div class="clock" style="margin:2em;"></div>
            </div>
            <div class="update-section">
                <form id="loginForm" action="login.php" method="post">
                    <input type="email" name="email" placeholder="Email" required>
                    <input type="password" name="password" placeholder="Password" required>
                    <button type="submit">Login</button>
                </form>
                <a href="register.html">Don't have an account? Register</a>
            </div>
        </div>
    </div>
    <script src="https://ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
    <script src="https://cdn.rawgit.com/objectivehtml/FlipClock/master/compiled/flipclock.min.js"></script>
    <script type="text/javascript">
        $(document).ready(function() {
            var clock;

            // Set the date we're counting down to
            var targetDate = new Date('August 25, 2024 00:00:00').getTime();

            // Update the count down every 1 second
            var x = setInterval(function() {

                // Get today's date and time
                var now = new Date().getTime();

                // Find the distance between now and the count down date
                var distance = targetDate - now;

                // Time calculations for days, hours, minutes and seconds
                var days = Math.floor(distance / (1000 * 60 * 60 * 24));
                var hours = Math.floor((distance % (1000 * 60 * 60 * 24)) / (1000 * 60 * 60));
                var minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                var seconds = Math.floor((distance % (1000 * 60)) / 1000);

                // Output the result in an element with id="demo"
                clock.setTime(distance / 1000);
                clock.setCountdown(true);

                // If the count down is over, write some text 
                if (distance < 0) {
                    clearInterval(x);
                    document.getElementById("demo").innerHTML = "EXPIRED";
                }
            }, 1000);

            clock = $('.clock').FlipClock({
                clockFace: 'DailyCounter',
                autoStart: false,
                callbacks: {
                    stop: function() {
                        $('.message').html('The clock has stopped!')
                    }
                }
            });
            
            clock.start();
        });
    </script>
</body>
</html>
