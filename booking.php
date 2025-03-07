<?php
session_start();
if (!isset($_SESSION['username'])) {
    header('location:login.php');
    exit; // Always exit after redirect
}

include "connect.php";
$username = $_SESSION['username'];

// Fetch user ID based on the logged-in username
$query = $db->prepare("SELECT * FROM user WHERE username = ?");
$query->execute(array($username));
$control = $query->fetch(PDO::FETCH_ASSOC);
$userid = $control['ID']; // Adjust if your user table schema uses a different naming convention

// Get the film ID from the query parameter
$ID = $_GET['ID'];
$query = $db->prepare("SELECT * FROM films WHERE ID = ?");
$query->execute(array($ID));
$bookfilm = $query->fetch(PDO::FETCH_ASSOC);
$filmid = $bookfilm['ID'];

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking - Projection Room</title>
    <link rel="stylesheet" href="stylesheets/booking.css">
</head>
<body>
    <header>
        <div class="container">
            <h1 class="logo">Projection Room</h1>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php">Return to Films</a></li>
                    <li><a href="admin.php">Admin Page</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <a href='logout.php'>Logout</a>
                        <li>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
                    <?php else: ?>
                        <a href='login.php'>Login</a>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <div class="welcome">
        <h4>Welcome, <?php echo htmlspecialchars($username); ?>!</h4>
    </div>

    <section class="booking-section">
        <h2 class="film-title"><?php echo htmlspecialchars($bookfilm['name']); ?></h2>
        <p class="film-description"><?php echo htmlspecialchars($bookfilm['description']); ?></p>
        <form action="booking2.php" method="POST" class="booking-form">
            <label for="tickets">Number of Tickets:</label>
            <select name="tickets" id="tickets" required>
                <option value="1">1</option>
                <option value="2">2</option>
                <option value="3">3</option>
                <option value="4">4</option>
                <option value="5">5</option>
            </select>
            <label for="timeslot">Select Time Slot:</label>
            <select name="timeslot" id="timeslot" required>
                <option value="1">13:00–16:30</option>
                <option value="2">18:00–21:30</option>
            </select>
            <input type="hidden" name="userid" value="<?php echo htmlspecialchars($userid); ?>">
            <input type="hidden" name="filmid" value="<?php echo htmlspecialchars($filmid); ?>">
            <button type="submit" class="submit-btn">Submit</button>
        </form>
    </section>
</body>