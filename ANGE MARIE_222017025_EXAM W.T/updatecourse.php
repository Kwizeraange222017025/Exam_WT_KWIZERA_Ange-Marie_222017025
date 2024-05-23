<?php
// Connection details
include('database_connection.php');

// Check if course_id is set
if(isset($_REQUEST['course_id'])) {
    $cid = $_REQUEST['course_id']; // Fix: Initialize $cid variable
    
    $stmt = $connection->prepare("SELECT * FROM course WHERE course_id=?");
    $stmt->bind_param("i", $cid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['course_id'];
        $y = $row['title'];
        $z = $row['description'];
        $w = $row['instructor_id'];
    } else {
        echo "Course entry not found."; // Fix: Corrected error message
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update course</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update course form -->
        <h2><u>Update Form of course</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
        
            <label for="tit">Title:</label>
            <input type="text" name="tit" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="desc">Description:</label> <!-- Fix: Corrected spelling of "description" -->
            <input type="text" name="desc" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="iid">Instructor ID:</label> <!-- Fix: Corrected label text -->
            <input type="number" name="iid" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>
            <input type="submit" name="up" value="Update">
            
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $title = $_POST['tit'];
    $description = $_POST['desc']; // Fix: Corrected variable name
    $instructor_id = $_POST['iid'];
    
    // Update the course in the database
    $stmt = $connection->prepare("UPDATE course SET title=?, description=?, instructor_id=? WHERE course_id=?");
    $stmt->bind_param("ssii", $title, $description, $instructor_id, $cid); // Fix: Changed "s" to "i" for instructor_id
    if ($stmt->execute()) {
        // Redirect to course.php
        header('Location: course.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating data: " . $stmt->error;
    }
}
?>
