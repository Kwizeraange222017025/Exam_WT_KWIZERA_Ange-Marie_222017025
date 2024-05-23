<?php
// Connection details
include('database_connection.php');

// Function to show delete confirmation
function showDeleteConfirmation($fid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($fid)">Confirm</button>
            <button onclick="returnToDiscussionForum()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(fid) {
        window.location.href = '?forum_id=' + fid + '&confirm=yes';
    }
    function returnToDiscussionForum() {
        window.location.href = 'discussion_forum.php';
    }
    </script>
HTML;
}

// Check if forum_id is set
if(isset($_REQUEST['forum_id'])) {
    $fid = $_REQUEST['forum_id'];
    
    // Check if deletion is confirmed
    if(isset($_REQUEST['confirm']) && $_REQUEST['confirm'] == 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM discussion_forum WHERE forum_id=?");
        $stmt->bind_param("i", $fid);
        if ($stmt->execute()) {
            if ($stmt->affected_rows > 0) {
                echo "Record deleted successfully.<br><br>";
                echo "<a href='discussion_forum.php'>OK</a>";
            } else {
                echo "No records deleted. forum ID not found.";
            }
        } else {
            echo "Error deleting data: " . $stmt->error;
        }
        $stmt->close();
    } else {
        showDeleteConfirmation($fid);
    }
} else {
    echo "forum ID is not set.";
}

$connection->close();
?>
