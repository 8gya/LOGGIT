<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: loggin.php");
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'php/db.php';

    $user_id = $_SESSION['user_id'];
    $title = trim($_POST['game-title']);
    $hours = intval($_POST['hours-played']);
    $rating = floatval($_POST['game-rating']);
    $review = trim($_POST['game-review']);

    $stmt = $conn->prepare("INSERT INTO games (user_id, title, hours, rating, review) VALUES (?, ?, ?, ?, ?)");
    $stmt->bind_param("isdis", $user_id, $title, $hours, $rating, $review);
    $stmt->execute();

    header("Location: profile.php");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log New Game</title>
    <link rel="stylesheet" href="css/logstyles.css">
</head>
<body>
    <a href="profile.php" class="back-button">BACK</a>
    <h1>LOG NEW GAME</h1>

    <div class="form-container">
        <form action="loggames.php" method="POST">
            <label for="game-title">Game Title:</label>
            <input type="text" name="game-title" id="game-title" required>

            <label for="hours-played">Hours Played:</label>
            <input type="number" name="hours-played" id="hours-played" min="0" required>

            <label for="game-rating">Rating (1-10):</label>
            <input type="number" name="game-rating" id="game-rating" min="1" max="10" step="0.1" required>

            <label for="game-review">Review:</label>
            <textarea name="game-review" id="game-review" rows="5" required></textarea>

            <button type="submit" class="custom-button">LOG GAME</button>
        </form>
    </div>
</body>
</html>