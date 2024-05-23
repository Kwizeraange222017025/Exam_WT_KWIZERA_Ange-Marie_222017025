<?php
// Check if the 'query' GET parameter is set
if (isset($_GET['query']) && !empty($_GET['query'])) {
    include('database_connection.php');


    // Sanitize input to prevent SQL injection
    $searchTerm = $connection->real_escape_string($_GET['query']);

    // Queries for different tables
    $queries = [
        'assignment' => "SELECT assignment_id FROM assignment WHERE assignment_id LIKE '%$searchTerm%'",

        'course' => "SELECT course_id FROM course WHERE course_id LIKE '%$searchTerm%'",

        'discussion_forum' => "SELECT forum_id FROM discussion_forum WHERE forum_id LIKE '%$searchTerm%'",

        'enrollment' => "SELECT enrollment_id FROM enrollment WHERE enrollment_id LIKE '%$searchTerm%'",

        'lesson' => "SELECT lesson_id FROM lesson WHERE lesson_id LIKE '%$searchTerm%'",

        'post' => "SELECT post_id FROM post WHERE post_id LIKE '%$searchTerm%'",

        'quiz' => "SELECT quiz_id FROM quiz WHERE quiz_id LIKE '%$searchTerm%'",

        'resource' => "SELECT resource_id FROM resource WHERE resource_id LIKE '%$searchTerm%'",

        'submission' => "SELECT submission_id FROM submission WHERE submission_id LIKE '%$searchTerm%'",

    ];

    // Output search results
    echo "<h2><u>Search Results:</u></h2>";

    foreach ($queries as $table => $sql) {
        $result = $connection->query($sql);
        echo "<h3>Table: $table</h3>";

        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                echo "<p>" . $row[array_keys($row)[0]] . "</p>"; // Dynamic field extraction from result
            }
        } else {
            echo "<p>No results found in $table matching the search term: '$searchTerm'</p>";
        }
    }

    // Close the connection
    $connection->close();
} else {
    echo "<p>No search term was provided.</p>";
}
?>
