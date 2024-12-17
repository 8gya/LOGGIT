<?php
session_start();
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    include 'php/db.php';

    $username = trim($_POST['username']);
    $password = $_POST['password'];

    $stmt = $conn->prepare("SELECT id, password FROM users WHERE username = ?");
    $stmt->bind_param("s", $username);
    $stmt->execute();
    $stmt->store_result();
    $stmt->bind_result($id, $hashed_password);

    if ($stmt->fetch() && password_verify($password, $hashed_password)) {
        $_SESSION['user_id'] = $id;
        $_SESSION['username'] = $username;
        header("Location: profile.php");
        exit();
    } else {
        $error = "Invalid username or password.";
    }

    $stmt->close();
    $conn->close();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Log In</title>
    <link rel="stylesheet" href="css/logginstyles.css">
</head>
<body>
    <a href="index.php" class="back-button">BACK</a>
    <h1>LOGGIN</h1>
    <h2>Welcome Back!</h2>

    <div class="form-container">
        <?php if (isset($error)) echo "<p style='color: red;'>$error</p>"; ?>
        <form action="loggin.php" method="POST">
            <label for="username">Username:</label>
            <input type="text" name="username" id="username" required>

            <label for="password">Password:</label>
            <input type="password" name="password" id="password" required>

            <button type="submit" class="custom-button">LOG IN</button>
        </form>
    </div>
</body>
</html>