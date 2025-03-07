<?php
session_start();
if (isset($_SESSION['username'])) {
    header('Location: films.php');
}
include('connect.php');
$usename = $password = $email = '';
$admin = 0;
$errors = array('usename' => '', 'password' => '', 'email' => '');

if (isset($_POST['submit'])) {
    // Validate email
    if (empty($_POST['email'])) {
        $errors['email'] = 'Email space is empty<br>';
    } else {
        $email = $_POST['email'];
        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email space is not valid<br>'; 
        }
    }

    // Validate username
    if (empty($_POST['usename'])) {
        $errors['usename'] = 'Username space is empty<br>';
    } 

    // Validate password
    if (empty($_POST['password'])) {
        $errors['password'] = 'Password space is empty<br>';
    }

    // Check if there are any errors
    if (array_filter($errors)) {
        // Display errors to the user
        foreach ($errors as $error) {
            echo $error;
        }
    } else {
        $usename = mysqli_real_escape_string($conn, $_POST['usename']);
        $password = mysqli_real_escape_string($conn, $_POST['password']);
        $hashed_password = MD5($password);
        $email = mysqli_real_escape_string($conn, $_POST['email']);

        $sql = "INSERT into user (username, password, email, admin) VALUES ('$usename', '$hashed_password', '$email', '$admin')";

        if (mysqli_query($conn, $sql)) {
            $_SESSION['username'] = $usename;
            header('Location: films.php');
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    }
}

// stuff to do with form
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" type="text/css" href="stylesheets/register.css">
    <title>Projection Room - Register</title>
</head>
<body>
    <div class="register-container">
        <h1>Create Your Account</h1>
        <form action="register.php" method="POST">
            <div class="form-group">
                <label for="username">Username</label>
                <input id="username" type="text" name="username" placeholder="Choose a username" required>
            </div>
            <div class="form-group">
                <label for="password">Password</label>
                <input id="password" type="password" name="password" placeholder="Create a password" required>
            </div>
            <div class="form-group">
                <label for="email">Email</label>
                <input id="email" type="email" name="email" placeholder="Enter your email" required>
            </div>
            <button type="submit" name="submit" class="btn-register">Register</button>
        </form>
        <p class="login-text">Already have an account? <a class="login-link" href="login.php">Login Here</a></p>
    </div>
</body>
</html>
