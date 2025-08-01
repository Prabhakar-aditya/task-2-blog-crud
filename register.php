<?php
require 'db.php';

if (isset($_POST['register'])) {
    $username = trim($_POST['username']);
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT);

    $sql = "INSERT INTO users (username, password) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $username, $password);

    if ($stmt->execute()) {
        echo "Registration successful. <a href='login.php'>Login now</a>";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head><title>Register</title></head>
<body>
    <h2>Register</h2>
    <form method="POST">
        Username:<br>
        <input type="text" name="username" required><br><br>
        Password:<br>
        <input type="password" name="password" required><br><br>
        <input type="submit" name="register" value="Register">
    </form>
    <br>
    <a href="login.php">Already have an account? Login</a>
</body>
</html>
