<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;
}

// Get film name from the query string
$filmname = isset($_GET['filmname']) ? htmlspecialchars($_GET['filmname']) : 'unknown film';
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Delete Confirmation</title>
    <link rel="stylesheet" type="text/css" href="stylesheets/delete_confirmation.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Projection Room - Delete Confirmation</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="upcomingfilms.php">Upcoming Films</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                    <!-- Show Logout Button if Logged In -->
                    <a href='logout.php'>Logout</a>
                <?php else: ?>
                    <!-- Show Login Button if Not Logged In -->
                    <a href='login.php'>Login</a>
                <?php endif; ?>
            <?php if (isset($_SESSION['username'])): ?>
            <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="admin-container" style="text-align:center;">
            <h2>Success!</h2>
            <p>All bookings for <strong><?php echo $filmname; ?></strong> have been successfully deleted.</p>
            <a href="view_bookings.php" class="btn">Return to View Bookings</a>
        </div>
    </main>

    <footer>
        <p>© 2025 Projection Room. All rights reserved.</p>
    </footer>
</body>
</html>