<?php
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'php/db.php';
    $username = $_POST['username'];
    $email = $_POST['email'];
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm-password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);
        $stmt = $conn->prepare("INSERT INTO users (username, email, password) VALUES (?, ?, ?)");
        $stmt->bind_param("sss", $username, $email, $hashed_password);
        $stmt->execute();
        header("Location: loggin.php");
        exit();
    }
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Sign Up</title>
    <link rel="stylesheet" href="css/signupstyles.css">
</head>
<body>
    <a href="index.php" class="back-button">BACK</a>
    <h1>SIGNUP</h1>
    <form action="signup.php" method="POST">
        <label for="username">Username:</label>
        <input type="text" name="username" id="username" required>
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required>
        <label for="confirm-password">Confirm Password:</label>
        <input type="password" name="confirm-password" id="confirm-password" required>
        <button type="submit">SIGN UP</button>
    </form>
</body>
</html>