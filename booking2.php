<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:login.php");
    exit;  // Stop script execution after redirection
}

include "connect.php"; // Ensure this file connects to your database

// Initialize variables for booking information
$bookingMessage = '';
$totalCost = 0;
$filmDetails = null;

// Check if the form is submitted
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $userid = $_POST['userid']; // Get the user ID safely
    $filmid = $_POST['filmid']; // Get the film ID
    $tickets = $_POST['tickets']; // Get tickets from form
    $timeslot = $_POST['timeslot']; //Gets ticket from timeslot

    // Prepare and execute the booking insert statement
    $stmt = $db->prepare("INSERT INTO bookings (userid, filmsid, tickets, timeslot) VALUES (?, ?, ?, ?)");

    if ($stmt->execute([$userid, $filmid, $tickets, $timeslot])) {
        // Booking Success
        $bookingMessage = "Booking Success!<br>";

        // Fetch film details
        $query = $db->prepare("SELECT * FROM films WHERE ID = ?");
        $query->execute([$filmid]);
        $filmDetails = $query->fetch(PDO::FETCH_ASSOC);

        // Fetch film name and cost calculation
        if ($filmDetails) {
            $filmname = htmlspecialchars($filmDetails['name']); // Sanitize output
            $totalCost = $tickets * 4.99;  // Assuming each ticket costs £4.99

            // Prepare final messages
            $bookingMessage .= "You have booked $tickets ticket(s) for <strong>$filmname</strong>.<br>";
            $bookingMessage .= "The total cost is £" . number_format($totalCost, 2) . ".";
        } else {
            $bookingMessage .= "No film found with that ID.";
        }
    } else {
        $bookingMessage = 'Query Error: ' . $stmt->errorInfo()[2]; // Provide error feedback
    }
} else {
    header("location:films.php");
    exit;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Booking Confirmation</title>
    <link rel="stylesheet" type="text/css" href="stylesheets/confirmation.css"> <!-- Booking confirmation-specific styles -->
</head>
<body>
    <header>
    <div class="container">
            <h1 class="logo">Projection Room - Booking Confirmation</h1>
            <nav>
                <ul class="nav-links">
                    <li><a href="index.php">Return to Films</a></li>
                    <li><a href="admin.php">Admin Page</a></li>
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

    <div class="container">
        <div class="welcome">
            <h4>Welcome <?php echo htmlspecialchars($_SESSION['username']); ?></h4>
        </div>

        <div class="confirmation">
            <h2>Booking Confirmation</h2>
            <p class="booking-message"><?php echo $bookingMessage; ?></p>

            <?php if ($filmDetails): ?>
                <div class="film-details">
                    <?php
                    $posterFileName = strtolower(str_replace(' ', '', $filmDetails['name'])) . '.jpg'; // Assuming JPG format
                    ?>
                    <img src='images/<?php echo $posterFileName; ?>' alt='<?php echo htmlspecialchars($filmDetails['name']); ?>' class='film-poster'>

                    <div class="booking-info">
                        <h4>Film: <?php echo htmlspecialchars($filmDetails['name']); ?></h4>
                        <p><strong>Description:</strong> <?php echo htmlspecialchars($filmDetails['description']); ?></p>
                        <p><strong>Number of Tickets:</strong> <?php echo $tickets; ?></p>
                        <p><strong>Time Slot:</strong> <?php echo htmlspecialchars($timeslot); ?></p>
                        <p><strong>Total Cost:</strong> £<?php echo number_format($totalCost, 2); ?></p>
                    </div>
                </div>
            <?php endif; ?>
        </div>
    </div>

    <footer>
        <p>&copy; 2025 Projection Room. All rights reserved.</p>
    </footer>
</body>
</html>

