<?php
// Connection details
include('database_connection.php');

// Check if lesson_id is set
if(isset($_REQUEST['lesson_id'])) {
    $lid = $_REQUEST['lesson_id']; // Fix: Initialize $lid variable
    
    $stmt = $connection->prepare("SELECT * FROM lesson WHERE lesson_id=?");
    $stmt->bind_param("i", $lid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['lesson_id'];
        $y = $row['title'];
        $z = $row['description'];
        $w = $row['course_id'];
    } else {
        echo "Lesson entry not found."; // Fix: Corrected error message
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update lesson</title>
 <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body><center>
    <!-- Update products form -->
    <h2><u>Update Form of lesson</u></h2>
    <form method="POST" onsubmit="return confirmUpdate();">
    
        <label for="tit">Title:</label>
        <input type="text" name="tit" value="<?php echo isset($y) ? $y : ''; ?>">
        <br><br>

        <label for="desc">Description:</label> <!-- Fix: Corrected spelling of "description" -->
        <input type="text" name="desc" value="<?php echo isset($z) ? $z : ''; ?>">
        <br><br>

        <label for="cid">Course ID:</label> <!-- Fix: Corrected label text -->
        <input type="number" name="cid" value="<?php echo isset($w) ? $w : ''; ?>">
        <br><br>
        <input type="submit" name="up" value="Update">
        
    </form>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $title = $_POST['tit'];
    $description = $_POST['desc']; // Fix: Corrected variable name
    $course_id = $_POST['cid'];
    
    // Update the lesson in the database
    $stmt = $connection->prepare("UPDATE lesson SET title=?, description=?, course_id=? WHERE lesson_id=?");
    $stmt->bind_param("ssii", $title, $description, $course_id, $lid); // Fix: Changed "s" to "i" for course_id
    if ($stmt->execute()) {
        // Redirect to lesson.php
        header('Location: lesson.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating data: " . $stmt->error;
    }
}
?>
