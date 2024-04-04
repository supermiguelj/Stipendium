
<html>
<head>
    <link rel="stylesheet" href="style.css">
</head>
<body>
    <?php include('navbar.php'); ?>
    <div class="tab-content">
        
<?php
session_start();
$db = new mysqli('localhost', 'root', '', 'user_systems');

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $db->real_escape_string($_POST['username']);
    $password = $db->real_escape_string($_POST['password']);

    $query = $db->query("SELECT id FROM users WHERE username='$username' AND password='$password'");
    if ($query->num_rows === 1) {
        $_SESSION['user'] = $username;
        header("location: database.php");
    } else {
        echo "Invalid login credentials";
    }
}
?>

<form method="post" action="login.php">
    Username: <input type="text" name="username" required><br>
    Password: <input type="password" name="password" required><br>
    <input class="button" type="submit" value="Login">
</form>

    </div>
</body>
</html>
