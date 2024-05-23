<?php
// Connection details
include('database_connection.php');

// Check if resource_id is set
if(isset($_REQUEST['resource_id'])) {
    $res_id = $_REQUEST['resource_id']; // Initialize $res_id variable
    
    $stmt = $connection->prepare("SELECT * FROM resource WHERE resource_id=?");
    $stmt->bind_param("i", $res_id);
    $stmt->execute();
    $result = $stmt->get_result();
    
    if($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $x = $row['resource_id'];
        $y = $row['lesson_id'];
        $z = $row['type'];
        $w = $row['url'];
    } else {
        echo "Resource entry not found."; // Fix: Corrected error message
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Update Resource</title>
    <!-- JavaScript validation and content load for update or modify data-->
    <script>
        function confirmUpdate() {
            return confirm('Are you sure you want to update this record?');
        }
    </script>
</head>
<body>
    <center>
        <!-- Update resource form -->
        <h2><u>Update Form of Resource</u></h2>
        <form method="POST" onsubmit="return confirmUpdate();">
        
            <label for="lesson_id">Lesson ID:</label>
            <input type="number" name="lesson_id" value="<?php echo isset($y) ? $y : ''; ?>">
            <br><br>

            <label for="type">Type:</label>
            <input type="text" name="type" value="<?php echo isset($z) ? $z : ''; ?>">
            <br><br>

            <label for="url">URL:</label>
            <input type="text" name="url" value="<?php echo isset($w) ? $w : ''; ?>">
            <br><br>
            <input type="submit" name="up" value="Update">
            
        </form>
    </center>
</body>
</html>

<?php
if(isset($_POST['up'])) {
    // Retrieve updated values from form
    $lesson_id = $_POST['lesson_id'];
    $type = $_POST['type'];
    $url = $_POST['url'];
    
    // Update the resource in the database
    $stmt = $connection->prepare("UPDATE resource SET lesson_id=?, type=?, url=? WHERE resource_id=?");
    $stmt->bind_param("issi", $lesson_id, $type, $url, $res_id);
    if ($stmt->execute()) {
        // Redirect to resource.php or wherever appropriate
        header('Location: resource.php');
        exit();
    } else {
        echo "Error updating data: " . $stmt->error;
    }
}
?>
