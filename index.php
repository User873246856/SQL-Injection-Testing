<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Projection Room - Home</title>
    <link rel="stylesheet" href="stylesheets/main.css">
    <script src="scripts/main.js" defer></script>

</head>
<body>
<header>
    <div class="container">
        <h1 class="logo">Projection Room</h1>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="new_food_drink.php">Menu</a></li>
                <li><a href="upcomingfilms.php">Upcoming Films</a></li>
                <li><a href="contact.php">Contact Us</a></li>
                <?php if (isset($_SESSION['username'])): ?>
                    <li><a href="logout.php">Logout</a></li>
                    <li>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
                <?php else: ?>
                    <li><a href="login.php">Login</a></li>
                <?php endif; ?>
            </ul>
        </nav>
    </div>
</header>

<section class="welcome-banner">
    <div class="welcome-text">
        <h2>Welcome to Projection Room!</h2>
        <p>Your one-stop destination for amazing movies.</p>
    </div>
    <img src="images/logo.png" alt="Cinema Banner" class="banner-image">
</section>

<section class="films-list-section">
   <h2 class="section-title">All Films</h2>
    <div class="films-grid">
        <?php
        include "connect.php";
        $query = $db->query("SELECT * FROM films");
        while ($row = $query->fetch(PDO::FETCH_ASSOC)) {
            echo "<div class='film-card'>";
            echo "<img src='images/" . strtolower(str_replace(' ', '', $row['name'])) . ".jpg' alt='" . htmlspecialchars($row['name']) . "' class='film-poster'>";
            echo "<h3 class='film-title'>" . htmlspecialchars($row['name']) . "</h3>";
            echo "<p class='film-description'>" . htmlspecialchars(substr($row['description'], 0, 100)) . "...</p>";
            echo "<button class='view-details-btn' data-id='" . htmlspecialchars($row['ID']) . "'>View Details</button>";
            echo "<a href='booking.php?ID=" . htmlspecialchars($row['ID']) . "' class='book-btn'>Book Now</a>";
            echo "</div>";
        }
        ?>
    </div>
</section>

<!-- Modal Structure -->
<div id="details-modal" class="modal">
    <div class="modal-content">
        <span class="close-modal">&times;</span>
        <h3 id="modal-title"></h3>
        <p id="modal-description"></p>
        <p id="modal-director"></p>
        <p id="modal-genre"></p>
        <p id="modal-release"></p>
        <p id="modal-duration"></p>
    </div>
</div>


</html>