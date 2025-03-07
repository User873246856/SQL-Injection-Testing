<?php
session_start();
include "connect.php"; // Database connection

// Fetch upcoming films from the database
try {
    $query = $db->query("SELECT * FROM films ORDER BY release_date ASC");
    $films = $query->fetchAll(PDO::FETCH_ASSOC);
} catch (Exception $e) {
    error_log($e->getMessage());
    $films = [];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Upcoming Films</title>
    <link rel="stylesheet" href="stylesheets/upcomingfilms.css">
</head>
<body>
<header>
    <div class="container">
        <h1 class="logo">Projection Room</h1>
        <nav>
            <ul class="nav-links">
                <li><a href="index.php">Home</a></li>
                <li><a href="upcomingfilms.php">Upcoming Films</a></li>
                <li><a href="food_drink.php">Food & Drink</a></li>
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


    <main>
        <section class="upcoming-films-section">
            <h2>Upcoming Films</h2>
            <?php if (count($films) > 0): ?>
                <?php foreach ($films as $film): ?>
                    <div class="film-card">
                        <h3><?php echo htmlspecialchars($film['name']); ?></h3>
                        <p><strong>Release Date:</strong> <?php echo htmlspecialchars($film['release_date']); ?></p>
                        <p><?php echo htmlspecialchars($film['description']); ?></p>
                        <div class="trailer">
                            <iframe width="560" height="315" 
                                src="<?php echo htmlspecialchars($film['trailer_url']); ?>" 
                                title="YouTube video player" frameborder="0" 
                                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture" 
                                allowfullscreen>
                            </iframe>
                        </div>
                    </div>
                <?php endforeach; ?>
            <?php else: ?>
                <p>No upcoming films available at the moment. Please check back later!</p>
            <?php endif; ?>
        </section>
    </main>

    <footer>
        <p>© 2025 Projection Room. All Rights Reserved.</p>
    </footer>
</body>
</html>
