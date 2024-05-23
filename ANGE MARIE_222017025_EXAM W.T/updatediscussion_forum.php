<?php
// Connection details
include('database_connection.php');

// Check if forum_id is set
if(isset($_REQUEST['forum_id'])) {
    $fid = $_REQUEST['forum_id']; // Fix: Initialize $fid variable
    
    $stmt = $connection->prepare("SELECT * FROM discussion_forum WHERE forum_id=?");
    $stmt->bind_param("i", $fid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['forum_id'];
        $y = $row['course_id'];
        $z = $row['title'];
        $w = $row['description'];
    } else {
        echo "Forum entry not found."; // Fix: Corrected error message
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Discussion Forum</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update discussion forum form -->
        <h2><u>Update Form of Discussion Forum</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
        
            <label for="cid">Course ID:</label>
            <input type="number" name="cid" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="tit">Title:</label>
            <input type="text" name="tit" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="desc">Description:</label> <!-- Fix: Corrected spelling of "description" -->
            <input type="text" name="desc" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <input type="submit" name="up" value="Update">
            
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $course_id = $_POST['cid'];
    $title = $_POST['tit'];
    $description = $_POST['desc']; // Fix: Corrected variable name
    
    // Update the discussion forum in the database
    $stmt = $connection->prepare("UPDATE discussion_forum SET course_id=?, title=?, description=? WHERE forum_id=?");
    $stmt->bind_param("issi", $course_id, $title, $description, $fid); // Fix: Changed "s" to "i" for course_id
    if ($stmt->execute()) {
        // Redirect to discussion_forum.php
        header('Location: discussion_forum.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating data: " . $stmt->error;
    }
}
?>
