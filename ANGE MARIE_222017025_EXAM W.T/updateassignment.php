<?php
// Connection details
include('database_connection.php');

// Check if assignment_id is set
if(isset($_REQUEST['assignment_id'])) {
    $aid = $_REQUEST['assignment_id']; // Fix: Initialize $aid variable
    
    $stmt = $connection->prepare("SELECT * FROM assignment WHERE assignment_id=?");
    $stmt->bind_param("i", $aid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['assignment_id'];
        $y = $row['title'];
        $z = $row['description'];
        $w = $row['course_id'];
        $d = $row['deadline']; // Added deadline variable
    } else {
        echo "Assignment entry not found."; // Fix: Corrected error message
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update assignment</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update assignment form -->
        <h2><u>Update Form of assignment</u></h2>
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

            <label for="ddl">Deadline:</label> <!-- Added deadline input field -->
            <input type="datetime-local" name="ddl" value="<?php echo isset($d) ? date('Y-m-d\TH:i', strtotime($d)) : ''; ?>">
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
    $course_id = $_POST['cid'];
    $deadline = $_POST['ddl']; // Added deadline variable
    
    // Update the assignment in the database
    $stmt = $connection->prepare("UPDATE assignment SET title=?, description=?, course_id=?, deadline=? WHERE assignment_id=?");
    $stmt->bind_param("sssii", $title, $description, $course_id, $deadline, $aid); // Fix: Changed "s" to "i" for course_id
    if ($stmt->execute()) {
        // Redirect to assignment.php
        header('Location: assignment.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating data: " . $stmt->error;
    }
}
?>
