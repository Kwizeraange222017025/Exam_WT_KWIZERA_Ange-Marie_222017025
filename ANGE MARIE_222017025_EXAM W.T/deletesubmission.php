<?php
// Connection details
include('database_connection.php');

// Function to show delete confirmation
function showDeleteConfirmation($sid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($sid)">Confirm</button>
            <button onclick="returnTosubmission()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(sid) {
        window.location.href = '?submission_id=' + sid + '&confirm=yes';
    }
    function returnTosubmission() {
        window.location.href = 'submission.php';
    }
    </script>
HTML;
}

// Check if submission_Id is set
if(isset($_REQUEST['submission_id'])) {
    $sid = $_REQUEST['submission_id'];
    
    // If confirmation is received, proceed with deletion
    if(isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM submission WHERE submission_id=?");
        $stmt->bind_param("i", $sid);
        if ($stmt->execute()) {
            echo "Record deleted successfully.<br><br>";
            echo "<a href='submission.php'>OK</a>";
        } else {
            echo "Error deleting data: " . $stmt->error;
        }
    
        $stmt->close();
    } else {
        // Show delete confirmation if confirmation is not received
        showDeleteConfirmation($sid);
    }
} else {
    echo "submission ID is not set.";
}

$connection->close();
?>
