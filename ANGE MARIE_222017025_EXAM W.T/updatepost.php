<?php
// Connection details
include('database_connection.php');

// Check if post_id is set
if(isset($_REQUEST['post_id'])) {
    $pid = $_REQUEST['post_id']; // Initialize $pid variable
    
    $stmt = $connection->prepare("SELECT * FROM post WHERE post_id=?");
    $stmt->bind_param("i", $pid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['post_id'];
        $y = $row['forum_id'];
        $z = $row['user_id'];
        $w = $row['content'];
    } else {
        echo "Post entry not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Post</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update post form -->
        <h2><u>Update Form of Post</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
        
            <label for="forum_id">Forum ID:</label>
            <input type="number" name="forum_id" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="user_id">User ID:</label>
            <input type="number" name="user_id" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="content">Content:</label>
            <textarea name="content"><?php echo isset($w) ? $w : ''; ?></textarea>
            <br><br>
            <input type="submit" name="up" value="Update">
            
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $forum_id = $_POST['forum_id'];
    $user_id = $_POST['user_id'];
    $content = $_POST['content'];
    
    // Update the post in the database
    $stmt = $connection->prepare("UPDATE post SET forum_id=?, user_id=?, content=? WHERE post_id=?");
    $stmt->bind_param("iisi", $forum_id, $user_id, $content, $pid);
    if ($stmt->execute()) {
        // Redirect to forum.php or wherever appropriate
        header('Location: forum.php');
        exit();
    } else {
        echo "Error updating data: " . $stmt->error;
    }
}
?>
