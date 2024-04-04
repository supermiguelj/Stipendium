<?php
// Database connection details
$servername = "localhost";
$username = "root";  // Replace with your MySQL username
$password = "";  // Replace with your MySQL password
$dbname = "user_systems";

// Create connection
$conn = new mysqli($servername, $username, $password, $dbname);

// Check connection
if ($conn->connect_error) {
    die("Connection failed: " . $conn->connect_error);
}

// Handling form submissions
if (isset($_POST['submit_record'])) {
    // Handle form submission for employee records
    $username = $conn->real_escape_string($_POST['username']);
    $department = $conn->real_escape_string($_POST['department']);
    $job_title = $conn->real_escape_string($_POST['job_title']);
    $clock_in = $conn->real_escape_string($_POST['clock_in']);
    $clock_out = $conn->real_escape_string($_POST['clock_out']);
    $output = "";

    // SQL to insert data
    $sql = "INSERT INTO employee_records (username, department, job_title, clock_in, clock_out) 
            VALUES ('$username', '$department', '$job_title', '$clock_in', '$clock_out')";

    if ($conn->query($sql) === TRUE) {
        echo "New record created successfully";
    } else {
        echo "Error: " . $sql . "<br>" . $conn->error;
    }

} elseif (isset($_POST['lookup_hours'])) {
    // Handle username lookup
    $username = $conn->real_escape_string($_POST['username_lookup']);

    // SQL to retrieve data
    $sql = "SELECT * FROM employee_records WHERE username = '$username'";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        // Calculate total hours
        $totalHours = 0;
        while($row = $result->fetch_assoc()) {
            $in = new DateTime($row["clock_in"]);
            $out = new DateTime($row["clock_out"]);
            $interval = $in->diff($out);
            $hours = $interval->h + ($interval->i / 60);
            $totalHours += $hours;
        }
        $output= "Total Hours Worked: " . $totalHours;
    } else {
        $output= "No records found";
    }
}

// Close connection
$conn->close();
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport">
  <title>Welcome</title>
  <link rel="stylesheet" href="style.css">
</head>
<body>
  <?php include('navbar.php'); ?>
  <div id="Welcome" class="tab-content" style="display: block;">
    <h1>Welcome Page</h1>
    <p>Welcome to our project!</p>
    <h1>Stipendium</h1>
    <p>Below is an example of the form that will be used to capture data to the SQL database server.</p>
    <br><br><br><br>
  </div>

  <!-- Employee Record Form -->
  <form action="database.php" method="post" class="tab-content">
    Username: <input type="text" name="username"><br>
    Department: <input type="text" name="department"><br>
    Job Title: <input type="text" name="job_title"><br>
    Clock In: <input type="datetime-local" name="clock_in"><br>
    Clock Out: <input type="datetime-local" name="clock_out"><br>
    <input type="submit" name="submit_record" value="Submit Record">
  </form>

  <!-- Username Lookup Form -->
  <form action="database.php" method="post" class="tab-content">
    <h2>Check Your Hours</h2>
    Enter Username: <input type="text" name="username_lookup"><br>
    <input type="submit" name="lookup_hours" value="Lookup Hours">
  </form>

  
  <div id="output" class="scrollable tab-content">
    <?php echo $output; ?>
  </div>

  <footer class="center">
    <p>Group 34, CAP3104 Hensel Fall 2023</p>
  </footer>
</body>
</html>