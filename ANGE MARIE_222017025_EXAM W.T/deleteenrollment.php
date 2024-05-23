<?php
// Connection details
include('database_connection.php');

// Function to show delete confirmation
function showDeleteConfirmation($eid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($eid)">Confirm</button>
            <button onclick="returnToEnrollment()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(eid) {
        window.location.href = '?enrollment_id=' + eid + '&confirm=yes';
    }
    function returnToEnrollment() {
        window.location.href = 'enrollment.php';
    }
    </script>
HTML;
}

// Check if enrollment_id is set
if(isset($_REQUEST['enrollment_id'])) {
    $eid = $_REQUEST['enrollment_id'];
    
    // If confirmation is received, proceed with deletion
    if(isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM enrollment WHERE enrollment_id=?");
        $stmt->bind_param("i", $eid);
        if ($stmt->execute()) {
            echo "Record deleted successfully.<br><br>";
            echo "<a href='enrollment.php'>OK</a>";
        } else {
            echo "Error deleting data: " . $stmt->error;
        }
    
        $stmt->close();
    } else {
        // Show delete confirmation if confirmation is not received
        showDeleteConfirmation($eid);
    }
} else {
    echo "Enrollment ID is not set.";
}

$connection->close();
?>
