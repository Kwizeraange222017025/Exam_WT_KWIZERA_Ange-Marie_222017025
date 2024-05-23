<?php
// Connection details
include('database_connection.php');

// Function to show delete confirmation
function showDeleteConfirmation($assid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($assid)">Confirm</button>
            <button onclick="returnToAssignment()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(assid) {
        window.location.href = '?assignment_id=' + assid + '&confirm=yes';
    }
    function returnToAssignment() {
        window.location.href = 'assignment.php';
    }
    </script>
HTML;
}

// Check if assignment_Id is set
if(isset($_REQUEST['assignment_id'])) {
    $assid = $_REQUEST['assignment_id'];
    
    // If confirmation is received, proceed with deletion
    if(isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM assignment WHERE assignment_id=?");
        $stmt->bind_param("i", $assid);
        if ($stmt->execute()) {
            echo "Record deleted successfully.<br><br>";
            echo "<a href='assignment.php'>OK</a>";
        } else {
            echo "Error deleting data: " . $stmt->error;
        }
    
        $stmt->close();
    } else {
        // Show delete confirmation if confirmation is not received
        showDeleteConfirmation($assid);
    }
} else {
    echo "Assignment ID is not set.";
}

$connection->close();
?>
