<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("location:index.php");
} else {
    include "connect.php";
    $username = $_SESSION['username'];
    $query = $db->prepare("SELECT * FROM user WHERE username=?");
    $query->execute(array($username));
    $control = $query->fetch(PDO::FETCH_ASSOC);
    if ($control['admin'] != 1) {
        header("Location:films.php");
        exit; // It's a good practice to call exit after a header redirect.
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projection Room - Admin</title>
    <link rel="stylesheet" type="text/css" href="stylesheets/content.css">
    <link rel="stylesheet" type="text/css" href="stylesheets/video.css"> 
    <link rel="stylesheet" type="text/css" href="stylesheets/admin.css"> 
</head>
<body>
    <header>
        <div class="container">
            <h1>Projection Room - Admin</h1>
            <nav>
                <ul>
                    <li><a href="films.php">Home</a></li>
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
                <li>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
            <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>
    
    <main>
        <div class="admin-container">
            <h4>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></h4>
            <p>Login Success!</p>
            <h3>Manage Films</h3>
            <?php
            include 'connect.php';
            $query = $db->query("SELECT * FROM films");
            echo "<table>";
            echo "<tr><th>Film Name</th><th>Description</th><th>Actions</th></tr>"; // Header row
            while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
                echo "<tr><td>";
                echo htmlspecialchars($row['name']);
                echo "</td><td>";
                echo htmlspecialchars($row['description']);
                echo "</td><td>";
                echo "<a href=\"delete.php?ID=" . $row['ID'] . "\">Delete</a> | ";
                echo "<a href=\"update.php?ID=" . $row['ID'] . "\">Update</a>";
                echo "</td></tr>";
            }
            echo "</table>";
            ?>
            <div class="add-film">
                <a href="add.php">Add new film</a>
                <a href="view_bookings.php">View Bookings</a>
            </div>
        </div>
    </main>

    <footer>
        <p>© <?php echo date("Y"); ?> Cineplex. All rights reserved.</p>
    </footer>
</body>
</html>