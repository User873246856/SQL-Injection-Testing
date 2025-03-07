<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Contact Us</title>
    <link rel="stylesheet" href="stylesheets/contact.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Contact Us</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="new_food_drink.php">Menu</a></li>
                    <li><a href="upcomingfilms.php">Upcoming Films</a></li>
                    <li><a href="contact.php">Contact Us</a></li>
                    <?php if (isset($_SESSION['username'])): ?>
                        <li><a href='logout.php'>Logout</a></li>
                        <li>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?>!</li>
                    <?php else: ?>
                        <li><a href='login.php'>Login</a></li>
                    <?php endif; ?>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="contact-form-container">
            <h2>We'd love to hear from you!</h2>
            <form action="submit_contact.php" method="post">
                <div class="form-group">
                    <label for="name">Name:</label>
                    <input type="text" id="name" name="name" required>
                </div>

                <div class="form-group">
                    <label for="email">Email:</label>
                    <input type="email" id="email" name="email" required>
                </div>

                <div class="form-group">
                    <label for="subject">Subject:</label>
                    <input type="text" id="subject" name="subject" required>
                </div>

                <div class="form-group">
                    <label for="message">Message:</label>
                    <textarea id="message" name="message" required></textarea>
                </div>

                <div class="form-group">
                    <input type="submit" value="Send Message" class="submit-btn">
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>© 2025 Projection Room. All Rights Reserved.</p>
    </footer>
</body>
</html>
