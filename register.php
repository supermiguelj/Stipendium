
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="tab-content">
        
<?php
$db = new mysqli('localhost', 'root', '', 'user_systems');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $db->real_escape_string($_POST['username']);
    $email = $db->real_escape_string($_POST['email']);
    $password = $db->real_escape_string($_POST['password']);

    $query = "INSERT INTO users (username, email, password) VALUES('$username', '$email', '$password')";
    if ($db->query($query)) {
        echo "Registration successful";
    } else {
        echo "Something went wrong";
    }
}
?>

<form method="post" action="register.php">
    Username: <input type="text" name="username" required><br>
    Email: <input type="email" name="email" required><br>
    Password: <input type="password" name="password" required><br>
    <input class="button" type="submit" value="Register">
</form>

    </div>
</body>
</html>
