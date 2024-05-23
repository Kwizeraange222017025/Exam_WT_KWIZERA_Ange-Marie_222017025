<!DOCTYPE html>
<html lang="en">
<head>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
  <!-- Defining character encoding -->
  <meta charset="utf-8">
  <!-- Setting viewport for responsive design -->
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>submission Page</title>

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
  <!-- <div class="col-3 offset">-->
</header>
  <center>
    <section id="home" style="display: block;">
		<h1>submission</h1>
<form method="post" action="submission.php">

<label for="submission_id">submission_id:</label>
<input type="number" id="submission_id" name="submission_id"/><br><br>

<label for="assignment_id ">assignment_id:</label>
<input type="number" id="assignment_id" name="assignment_id"/><br><br>

<label for="user_id">user_id:</label>
<input type="number" id="user_id" name="user_id"/><br><br>

<label for="submission_date">submission_date:</label>
<input type="date" id="submission_date" name="submission_date"/><br><br>

<label for="file_url">file_url:</label>
<input type="text" id="file_url" name="file_url"/><br><br>


<input type="submit" name="submission" value="INSERT"/><br>

					


	

	</form>
	<?php
// Connection details
include('database_connection.php');
// Check if the form is submitted
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    // Prepare and bind the parameters
    $stmt = $connection->prepare("INSERT INTO submission( assignment_id, user_id, submission_date, file_url ) VALUES (?, ?, ?, ?)");
    $stmt->bind_param("ssss",  $assid, $uid, $sd, $fu);
    // Set parameters and execute
    $assid = $_POST['assignment_id'];
    $uid = $_POST['user_id'];
    $fd = $_POST['submission_date'];
    $fu = $_POST['file_url'];
   
    if ($stmt->execute() == TRUE) {
        echo "New record has been added successfully";
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
// SQL query to fetch data from the submission table
$sql = "SELECT * FROM submission";
$result = $connection->query($sql);

?>

<!DOCTYPE html>
<html>
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Detail information Of submission</title>
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
    <center><h2>Table of submission</h2></center>
    <table border="5">
        <tr>
            <th>submission_id </th>
            <th>assignment_id </th>
            <th>user_id </th>
            <th>submission_date </th>
             <th>file_url </th>
            <th>Delete</th>
            <th>Update</th>
        </tr>
        <?php
// Connection details
include('database_connection.php');

        // Prepare SQL query to retrieve all submission
        $sql = "SELECT * FROM submission";
        $result = $connection->query($sql);

        // Check if there are any submission
        if ($result->num_rows > 0) {
            // Output data for each row
            while ($row = $result->fetch_assoc()) {
                $sid = $row['submission_id']; // Fetch the submission_id
                echo "<tr>
                    <td>" . $row['submission_id'] . "</td>
                    <td>" . $row['assignment_id'] . "</td>
                    <td>" . $row['user_id'] . "</td>
                    <td>" . $row['submission_date'] . "</td>
                    <td>" . $row['file_url'] . "</td>
                    <td><a style='padding:4px' href='deletesubmission.php?submission_id=$sid'>Delete</a></td> 
                    <td><a style='padding:4px' href='updatesubmission.php?submission_id=$sid'>Update</a></td> 
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