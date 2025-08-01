<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
require 'db.php';
if (isset($_POST['submit'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "INSERT INTO posts (title, content) VALUES (?, ?)";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ss", $title, $content);

    if ($stmt->execute()) {
        echo "Post added successfully!";
    } else {
        echo "Error: " . $stmt->error;
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Add Post</title>
</head>
<body>
    <h2>Add New Blog Post</h2>
    <form method="POST" action="">
        <label>Title:</label><br>
        <input type="text" name="title" required><br><br>

        <label>Content:</label><br>
        <textarea name="content" rows="5" cols="40" required></textarea><br><br>

        <input type="submit" name="submit" value="Add Post">
    </form>

    <br>
    <a href="index.php">Back to Home</a>
</body>
</html>
