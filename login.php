<?php 

session_start();
include "connect.php";

if(isset($_POST["login"])) {
    if($_POST["username"] == "" or $_POST["password"] == "") {
        echo "<center><h1>Username and Password required</h1></center>";
    }
    else {
        $username = strip_tags(trim($_POST["username"]));
        $password = strip_tags(trim($_POST["password"]));
        $hash = MD5($password);
        $query = $db->prepare("SELECT * FROM user WHERE username=?");
        $query->execute(array($username));
        $control = $query->fetch(PDO::FETCH_ASSOC);
        if($control > 0 && ($hash == $control['password'])) {
            session_start();
            $_SESSION['username'] = $username;
            header('Location:index.php');
        } else {
            echo '<center><h1> Incorrect Username or <br> Password </h1></center>';
        }
    }
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="stylesheets/login.css"> <!-- Link to the login CSS file -->
    <title>Projection Room - Login</title>
</head>
<body>
    <div class="login-container">
        <h1>Welcome to Projection Room</h1>
        <form method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" name="username" type="text" placeholder="Enter your username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" name="password" type="password" placeholder="Enter your password" required>
            </div>
            <button type="submit" name="login" class="btn-login">Login</button>
        </form>
        <p class="register-text">Don't have an account? <a class="register-link" href="register.php">Register Here</a></p>
    </div>
</body>
</html>
