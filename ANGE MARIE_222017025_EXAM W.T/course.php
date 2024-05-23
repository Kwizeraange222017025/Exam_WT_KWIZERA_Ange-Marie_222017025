<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Course Page</title>
  <!-- Linking to external stylesheet -->
  <link rel="stylesheet" type="text/css" href="style.css" title="style 1" media="screen, tv, projection, handheld, print"/>
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
<section id="home" style="display: block;">
  <center><h1>Course</h1>
  <form method="post">
    <label for="course_id">Course ID:</label>
    <input type="number" id="course_id" name="course_id"/><br><br>
    <label for="title">Title:</label>
    <input type="text" id="title" name="title"/><br><br>
    <label for="description">Description:</label>
    <input type="text" id="description" name="description"/><br><br>
    <label for="instructor_id">Instructor ID:</label>
    <input type="number" id="instructor_id" name="instructor_id"/><br><br>
    <input type="submit" name="course" value="INSERT"/><br>
  </form></center>
  <?php
    // Connection details
    include('database_connection.php');

    // Check if the form is submitted
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        // Prepare and bind the parameters
        $stmt = $connection->prepare("INSERT INTO course (course_id, title, description, instructor_id) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssss", $cid, $tt, $desc, $insid);
        // Set parameters and execute
        $cid = $_POST['course_id'];
        $tt = $_POST['title'];
        $desc = $_POST['description'];
        $insid = $_POST['instructor_id'];
        if ($stmt->execute() == TRUE) {
            echo "New record has been added successfully";
        } else {
            echo "Error: " . $stmt->error;
        }
        $stmt->close();
    }
    $connection->close();
  ?>
</section>
<section>
  <center><h2>Table of Course</h2>
  <table border="5">
    <tr>
      <th>Course ID</th>
      <th>Title</th>
      <th>Description</th>
      <th>Instructor ID</th>
      <th>Delete</th>
      <th>Update</th>
    </tr>
    <?php
      // Connection details
      include('database_connection.php');

      // Prepare SQL query to retrieve all courses
      $sql = "SELECT * FROM course";
      $result = $connection->query($sql);

      // Check if there are any courses
      if ($result->num_rows > 0) {
          // Output data for each row
          while ($row = $result->fetch_assoc()) {
              $cid = $row['course_id'];
              echo "<tr>
                      <td>" . $row['course_id'] . "</td>
                      <td>" . $row['title'] . "</td>
                      <td>" . $row['description'] . "</td>
                      <td>" . $row['instructor_id'] . "</td>
                      <td><a style='padding:4px' href='deletecourse.php?course_Id=$cid'>Delete</a></td> 
                      <td><a style='padding:4px' href='updatecourse.php?course_id=$cid'>Update</a></td> 
                    </tr>";
          }
      } else {
          echo "<tr><td colspan='6'>No data found</td></tr>";
      }
      // Close the database connection
      $connection->close();
    ?>
  </table></center>
</section>
<footer>
  <marquee><i style="color: green;">&copy; 2024</i><b>WEB TECHNOLOGY CAT</b></marquee>
</footer>
</body>
</html>
