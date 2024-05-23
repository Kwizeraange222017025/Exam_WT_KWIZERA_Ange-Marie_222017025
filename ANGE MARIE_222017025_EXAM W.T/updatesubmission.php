<?php
// Connection details
include('database_connection.php');

// Check if assignment_id is set
if(isset($_REQUEST['assignment_id'])) {
    $assignment_id = $_REQUEST['assignment_id']; // Initialize $assignment_id variable
    
    $stmt = $connection->prepare("SELECT * FROM submission WHERE assignment_id=?");
    $stmt->bind_param("i", $assignment_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['assignment_id'];
        $y = $row['user_id'];
        $z = $row['submission_date'];
        $w = $row['file_url'];
    } else {
        echo "Submission entry not found."; // Corrected error message
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Submission</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update submission form -->
        <h2><u>Update Form of Submission</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
        
            <label for="user_id">User ID:</label>
            <input type="number" name="user_id" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="submission_date">Submission Date:</label>
            <input type="text" name="submission_date" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="file_url">File URL:</label>
            <input type="text" name="file_url" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>
            <input type="submit" name="up" value="Update">
            
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $user_id = $_POST['user_id'];
    $submission_date = $_POST['submission_date'];
    $file_url = $_POST['file_url'];
    
    // Update the submission in the database
    $stmt = $connection->prepare("UPDATE submission SET user_id=?, submission_date=?, file_url=? WHERE assignment_id=?");
    $stmt->bind_param("issi", $user_id, $submission_date, $file_url, $assignment_id);
    if ($stmt->execute()) {
        // Redirect to submission.php or wherever appropriate
        header('Location: submission.php');
        exit();
    } else {
        echo "Error updating data: " . $stmt->error;
    }
}
?>
