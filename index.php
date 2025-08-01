<?php
session_start();
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php");
    exit;
}
?>

<?php
require 'db.php';
echo "Database connected successfully!";
?>
<?php
require 'db.php';
$sql = "SELECT * FROM posts ORDER BY created_at DESC";
$result = $conn->query($sql);
?>
<!DOCTYPE html>
<html>
<head>
    <title>Blog Home</title>
</head>
<body>
    <h1>All Blog Posts</h1>
    <a href="add_post.php">+ Add New Post</a>
    <a href="logout.php" style="float:right;">Logout</a>
    <hr><br>

    <?php if ($result->num_rows > 0): ?>
        <?php while($row = $result->fetch_assoc()): ?>
            <div>
                <h3><?php echo htmlspecialchars($row['title']); ?></h3>
                <p><?php echo nl2br(htmlspecialchars($row['content'])); ?></p>
                <small>Posted on: <?php echo $row['created_at']; ?></small><br>

                <!-- Edit & Delete Buttons -->
                <a href="edit_post.php?id=<?php echo $row['id']; ?>">Edit</a> |
                <a href="delete_post.php?id=<?php echo $row['id']; ?>" onclick="return confirm('Are you sure you want to delete this post?');">Delete</a>
                <hr>
            </div>
        <?php endwhile; ?>
    <?php else: ?>
        <p>No posts found.</p>
    <?php endif; ?>
</body>
</html>
