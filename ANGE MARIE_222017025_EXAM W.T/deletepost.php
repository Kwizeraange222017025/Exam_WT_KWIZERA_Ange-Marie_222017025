<?php
// Connection details
include('database_connection.php');

// Function to show delete confirmation
function showDeleteConfirmation($pid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($pid)">Confirm</button>
            <button onclick="returnTopost()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(pid) {
        window.location.href = '?post_id=' + pid + '&confirm=yes';
    }
    function returnTopost() {
        window.location.href = 'post.php';
    }
    </script>
HTML;
}

// Check if post_id is set and is numeric
if(isset($_REQUEST['post_id']) && is_numeric($_REQUEST['post_id'])) {
    $pid = $_REQUEST['post_id'];
    
    // Prepare and execute the DELETE statement
    $stmt = $connection->prepare("DELETE FROM post WHERE post_id=?");
    $stmt->bind_param("i", $pid);
    if ($stmt->execute()) {
        if ($stmt->affected_rows > 0) {
            echo "Record deleted successfully.";
        } else {
            echo "No record found with the specified post_id.";
        }
    } else {
        echo "Error deleting data: " . $stmt->error;
    }

    $stmt->close();
} else {
    echo "post_id is not set or is not a valid numeric value.";
}

$connection->close();
?>
