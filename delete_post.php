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

// Delete post from database
$sql = "DELETE FROM posts WHERE id = ?";
$stmt = $conn->prepare($sql);
$stmt->bind_param("i", $id);

if ($stmt->execute()) {
    header("Location: index.php"); // Redirect back to home
    exit;
} else {
    echo "Error deleting post: " . $stmt->error;
}
?>
