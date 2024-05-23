<?php
// Connection details
include('database_connection.php');

// Check if enrollment_id is set
if(isset($_REQUEST['enrollment_id'])) {
    $eid = $_REQUEST['enrollment_id']; // Fix: Initialize $eid variable
    
    $stmt = $connection->prepare("SELECT * FROM enrollment WHERE enrollment_id=?");
    $stmt->bind_param("i", $eid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['enrollment_id'];
        $y = $row['user_id'];
        $z = $row['course_id'];
        $w = $row['enroll_date'];
    } else {
        echo "Enrollment entry not found."; // Fix: Corrected error message
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Enrollment</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update enrollment form -->
        <h2><u>Update Form of Enrollment</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
        
            <label for="uid">User ID:</label>
            <input type="number" name="uid" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="cid">Course ID:</label>
            <input type="number" name="cid" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="date">Enroll Date:</label>
            <input type="date" name="date" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>

            <input type="submit" name="up" value="Update">
            
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $user_id = $_POST['uid'];
    $course_id = $_POST['cid'];
    $enroll_date = $_POST['date'];
    
    // Update the enrollment in the database
    $stmt = $connection->prepare("UPDATE enrollment SET user_id=?, course_id=?, enroll_date=? WHERE enrollment_id=?");
    $stmt->bind_param("iisi", $user_id, $course_id, $enroll_date, $eid);
    if ($stmt->execute()) {
        // Redirect to enrollment.php
        header('Location: enrollment.php');
        exit(); // Ensure that no other content is sent after the header redirection
    } else {
        echo "Error updating data: " . $stmt->error;
    }
}
?>
