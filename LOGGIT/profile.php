<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: loggin.php");
    exit();
}

include 'php/db.php';
$user_id = $_SESSION['user_id'];

$query = $conn->prepare("SELECT * FROM games WHERE user_id = ?");
$query->bind_param("i", $user_id);
$query->execute();
$result = $query->get_result();

$games = [];
$total_hours = 0;
while ($row = $result->fetch_assoc()) {
    $games[] = $row;
    $total_hours += $row['hours'];
}

$query->close();
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>User Profile</title>
    <link rel="stylesheet" href="css/profilestyles.css">
</head>
<body>
    <div class="back-button-container">
        <a href="php/logout.php" class="back-button">LOGOUT</a>
    </div>
    <h1>LOGGIT</h1>

    <div class="profile-container">
        <p><strong>Games Logged:</strong> <?php echo count($games); ?></p>
        <p><strong>Total Hours Played:</strong> <?php echo $total_hours; ?></p>

        <div class="games-list">
            <h2>Logged Games</h2>
            <ul>
                <?php foreach ($games as $game): ?>
                    <li><?php echo htmlspecialchars($game['title']) . " - " . $game['hours'] . " Hours"; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
        <a href="loggames.php" class="custom-button">LOG NEW GAME</a>
    </div>
</body>
</html>