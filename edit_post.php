<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
require 'db.php';

if (!isset($_GET['id'])) {
    echo "No post ID provided.";
    exit;
}

$id = $_GET['id'];
$successMessage = "";

$sql = "SELECT * FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);
$stmt->execute();
$result = $stmt->get_result();
$post = $result->fetch_assoc();

if (!$post) {
    echo "Post not found.";
    exit;
}

if (isset($_POST['update'])) {
    $title = $_POST['title'];
    $content = $_POST['content'];

    $sql = "UPDATE posts SET title = ?, content = ? WHERE id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("ssi", $title, $content, $id);

    if ($stmt->execute()) {
        $successMessage = "Post updated successfully!";
        header("Location: index.php");
        exit;
    } else {
        echo "Error updating post: " . $stmt->error;
    }
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Post</title>
</head>
<body>
    <h2>Edit Blog Post</h2>

    <?php if ($successMessage) echo "<p style='color: green;'>$successMessage</p>"; ?>

    <form method="POST">
        <label>Title:</label><br>
        <input type="text" name="title" value="<?php echo htmlspecialchars($post['title']); ?>" required><br><br>

        <label>Content:</label><br>
        <textarea name="content" rows="5" cols="40" required><?php echo htmlspecialchars($post['content']); ?></textarea><br><br>

        <input type="submit" name="update" value="Update Post">
    </form>

    <br>
    <a href="index.php">Back to Home</a>
</body>
</html>
