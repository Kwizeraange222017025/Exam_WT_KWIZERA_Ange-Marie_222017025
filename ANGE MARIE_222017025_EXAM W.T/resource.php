<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>resource Page</title>

  <style>
    /* Normal link */
    a {
      padding: 10px;
      color: white;
      background-color: blue;
      text-decoration: none;
      margin-right: 15px;
    }

    /* Visited link */
    a:visited {
      color: purple;
    }
    /* Unvisited link */
    a:link {
      color: brown; /* Changed to lowercase */
    }
    /* Hover effect */
    a:hover {
      background-color: white;
    }

    /* Active link */
    a:active {
      background-color: blue;
    }

    /* Extend margin left for search button */
    button.btn {
      margin-left: 15px; /* Adjust this value as needed */
      margin-top: 4px;
    }
    /* Extend margin left for search button */
    input.form-control {
      margin-left: 1300px; /* Adjust this value as needed */

      padding: 8px;
     
    }
    section{
    padding:32px;
    }
      footer{
    text-align: center;
    padding: 15px;
    background-color:darkgray;
}
header{
    background-color:darkgray;
    padding: 20px;
}

  </style>
  
<header>
   

</head>

<body bgcolor="brown">

  <form class="d-flex" role="search" action="search.php">
      <input class="form-control me-2" type="search" placeholder="Search" aria-label="Search" name="query">
      <button class="btn btn-outline-success" type="submit">Search</button>
    </form>
  <ul style="list-style-type: none; padding: 0;">
    <li style="display: inline; margin-right: 10px;">
   <img src="./Images/attachment.png" width="90" height="60" alt="Logo">
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./home.html">HOME</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./about.html">ABOUT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./contact.html">CONTACT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./course.php">COURSE</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./enrollment.php">ENROLLMENT</a>
  </li>
    <li style="display: inline; margin-right: 10px;"><a href="./lesson.php">LESSON</a>
  </li>
   <li style="display: inline; margin-right: 10px;"><a href="./resource.php">RESOURCE</a>
  </li>
   <li style="display: inline; margin-right: 10px;"><a href="./assignment.php">ASSIGNMENT</a>
  </li>
  <li style="display: inline; margin-right: 10px;"><a href="./submission.php">SUBMISSION</a>
  </li>
  <li style="display: inline; margin-right: 10px;"><a href="./discussion_forum.php">DISCUSSION_FORUM</a>
  </li>
  <li style="display: inline; margin-right: 10px;"><a href="./post.php">POST</a>
  </li>
  <li style="display: inline; margin-right: 10px;"><a href="./quiz.php">QUIZ</a>
  </li>

    <li class="dropdown">
      <a href="#" style="padding: 10px; color: white; background-color: hotpink; text-decoration: none; margin-right: 15px;">Settings</a>
      <div class="dropdown-contents">
        <!-- Links inside the dropdown menu -->
        <a href="login.html">Login</a>
        <a href="register.html">Register</a>
        <a href="logout.php">Logout</a>
      </div>
    </li>
  </ul>
 
</header>
  <center>
    <section id="home" style="display: block;">
		   <h1>Resource</h1>
    <form method="post" action="resource.php">
      <label for="resource_id">Resource ID:</label>
      <input type="number" id="resource_id" name="resource_id"/><br><br>

      <label for="lesson_id">Lesson ID:</label>
      <input type="number" id="lesson_id" name="lesson_id"/><br><br>

      <label for="type">Type:</label>
      <input type="text" id="type" name="type"/><br><br>

      <label for="url">URL:</label>
      <input type="text" id="url" name="url"/><br><br>

      <input type="submit" name="resource" value="INSERT"/><br>
    </form>
    <?php
    // Connection details
    include('database_connection.php');
    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['resource'])) {
        // Prepare and bind the parameters
        $stmt = $connection->prepare("INSERT INTO resource(resource_id, lesson_id, type, url) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("iiss", $resource_id, $lesson_id, $type, $url);
        // Set parameters and execute
        $resource_id = $_POST['resource_id'];
        $lesson_id = $_POST['lesson_id'];
        $type = $_POST['type'];
        $url = $_POST['url'];

        if ($stmt->execute()) {
            echo "New record has been added successfully.";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $connection->close();
    ?>

<?php
// Connection details
include('database_connection.php');
// SQL query to fetch data from the resource table
$sql = "SELECT * FROM resource";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of resource</title>
    <style>
        table {
            width: 100%;
            border-collapse: collapse;
        }

        th, td {
            border: 1px solid #ddd;
            padding: 8px;
            text-align: left;
        }

        th {
            background-color: #f2f2f2;
        }
    </style>
</head>
<body>
    <center><h2>Table of resource</h2></center>
    <table border="5">
        <tr>
            <th>resource_id </th>
            <th>lesson_id </th>
            <th>type </th>
            <th>url </th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
// Connection details
include('database_connection.php');

        // Prepare SQL query to retrieve all resource
        $sql = "SELECT * FROM resource";
        $result = $connection->query($sql);

        // Check if there are any resource
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $rid = $row['resource_id']; // Fetch the resource_id
                echo "<tr>
                    <td>" . $row['resource_id'] . "</td>
                    <td>" . $row['lesson_id'] . "</td>
                    <td>" . $row['type'] . "</td>
                    <td>" . $row['url'] . "</td>
                    <td><a style='padding:4px' href='deleteresource.php?resource_id=$rid'>Delete</a></td> 
                    <td><a style='padding:4px' href='updateresource.php?resource_id=$rid'>Update</a></td> 
                </tr>";
            }
        } else {
            echo "<tr><td colspan='6'>No data found</td></tr>";
        }
        // Close the database connection
        $connection->close();
        ?>
    </table>
<footer>
  <marquee><i style="color: green;">&copy; 2024</i><b>WEB TECHNOLOGY CAT</b></marquee>
</footer>
</body>
</html>