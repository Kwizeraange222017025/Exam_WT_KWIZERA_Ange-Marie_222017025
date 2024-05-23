<?php
// Connection details
include('database_connection.php');

// Check if quiz_id is set
if(isset($_REQUEST['quiz_id'])) {
    $qid = $_REQUEST['quiz_id']; // Initialize $qid variable
    
    $stmt = $connection->prepare("SELECT * FROM quiz WHERE quiz_id=?");
    $stmt->bind_param("i", $qid);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['quiz_id'];
        $y = $row['title'];
        $z = $row['description'];
        $w = $row['course_id'];
    } else {
        echo "Quiz entry not found.";
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Quiz</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update quiz form -->
        <h2><u>Update Form of Quiz</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
        
            <label for="title">Title:</label>
            <input type="text" name="title" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="description">Description:</label>
            <input type="text" name="description" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="course_id">Course ID:</label>
            <input type="number" name="course_id" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>
            <input type="submit" name="up" value="Update">
            
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $title = $_POST['title'];
    $description = $_POST['description'];
    $course_id = $_POST['course_id'];
    
    // Update the quiz in the database
    $stmt = $connection->prepare("UPDATE quiz SET title=?, description=?, course_id=? WHERE quiz_id=?");
    $stmt->bind_param("ssii", $title, $description, $course_id, $qid);
    if ($stmt->execute()) {
        // Redirect to quiz.php or wherever appropriate
        header('Location: quiz.php');
        exit();
    } else {
        echo "Error updating data: " . $stmt->error;
    }
}
?>
