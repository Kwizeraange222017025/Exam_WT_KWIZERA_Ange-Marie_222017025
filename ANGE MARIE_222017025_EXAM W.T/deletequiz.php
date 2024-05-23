<?php
// Connection details
include('database_connection.php');

// Function to show delete confirmation
function showDeleteConfirmation($qid) {
    echo <<<HTML
    <div id="confirmModal" style="position: fixed; top: 0; left: 0; width: 100%; height: 100%; background-color: rgba(0,0,0,0.5); display: flex; justify-content: center; align-items: center;">
        <div style="background: white; padding: 20px; border-radius: 5px; box-shadow: 0 0 15px rgba(0,0,0,0.2);">
            <h2>Confirm Deletion</h2>
            <p>Are you sure you want to delete this record?</p>
            <button onclick="confirmDeletion($qid)">Confirm</button>
            <button onclick="returnToQuiz()">Back</button>
        </div>
    </div>
    <script>
    function confirmDeletion(qid) {
        window.location.href = '?quiz_id=' + qid + '&confirm=yes';
    }
    function returnToQuiz() {
        window.location.href = 'quiz.php';
    }
    </script>
HTML;
}

// Check if quiz_id is set
if(isset($_REQUEST['quiz_id'])) {
    $qid = $_REQUEST['quiz_id'];
    
    // If confirmation is received, proceed with deletion
    if(isset($_GET['confirm']) && $_GET['confirm'] === 'yes') {
        // Prepare and execute the DELETE statement
        $stmt = $connection->prepare("DELETE FROM quiz WHERE quiz_id=?");
        $stmt->bind_param("i", $qid);
        if ($stmt->execute()) {
            echo "Record deleted successfully.<br><br>";
            echo "<a href='quiz.php'>OK</a>";
        } else {
            echo "Error deleting data: " . $stmt->error;
        }
    
        $stmt->close();
    } else {
        // Show delete confirmation if confirmation is not received
        showDeleteConfirmation($qid);
    }
} else {
    echo "Quiz ID is not set.";
}

$connection->close();
?>
