<?php
// Connection details
include('database_connection.php');

// Function to show delete confirmation
function showDeleteConfirmation($rid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($rid)">Confirm</button>
            <button onclick="returnToResource()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(rid) {
        window.location.href = '?resource_id=' + rid + '&confirm=yes';
    }
    function returnToResource() {
        window.location.href = 'resource.php';
    }
    </script>
HTML;
}

// Check if resource_id is set
if(isset($_REQUEST['resource_id'])) {
    $rid = $_REQUEST['resource_id'];
    
    // If confirmation is received, proceed with deletion
    if(isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM resource WHERE resource_id=?");
        $stmt->bind_param("i", $rid);
        if ($stmt->execute()) {
            echo "Record deleted successfully.<br><br>";
            echo "<a href='resource.php'>OK</a>";
        } else {
            echo "Error deleting data: " . $stmt->error;
        }
    
        $stmt->close();
    } else {
        // Show delete confirmation if confirmation is not received
        showDeleteConfirmation($rid);
    }
} else {
    echo "Resource ID is not set.";
}

$connection->close();
?>
