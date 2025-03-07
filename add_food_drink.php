<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("location:index.php");
    exit;
} else {
    include "connect.php"; // Include your database connection file
    $username = $_SESSION['username'];
    $query = $db->prepare("SELECT * FROM user WHERE username=?");
    $query->execute([$username]);
    $control = $query->fetch(PDO::FETCH_ASSOC);
    if ($control['admin'] != 1) {
        header("Location:films.php");
        exit;
    }
}

// Process the form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $foodName = trim($_POST['foodName']);
    $description = trim($_POST['description']);
    $price = trim($_POST['price']);
    $isCombo = isset($_POST['isCombo']) ? 1 : 0; // Check if it's a combo item

    // Ensure price is a valid number
    if (!is_numeric($price) || $price < 0) {
        echo "<script>alert('Please enter a valid price.');</script>";
    } else {
        // Insert into the menu database
        $stmt = $db->prepare("INSERT INTO menu (name, description, price, is_combo) VALUES (?, ?, ?, ?)");
        if ($stmt->execute([$foodName, $description, $price, $isCombo])) {
            echo "<script>alert('Food item added successfully!');</script>";
        } else {
            echo "<script>alert('Error adding food item.');</script>";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Food Item</title>
    <link rel="stylesheet" href="stylesheets/food_admin.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Add Food Item</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="new_food_drink.php">Menu</a></li>
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
        <div class="add-food-form">
            <h2>Add New Food Item</h2>
            <form action="add_food_drink.php" method="post">
                <div class="form-group">
                    <label for="foodName">Food Name:</label>
                    <input type="text" name="foodName" required>
                </div>

                <div class="form-group">
                    <label for="description">Description:</label>
                    <textarea name="description" required></textarea>
                </div>

                <div class="form-group">
                    <label for="price">Price (£):</label>
                    <input type="text" name="price" required>
                </div>

                <div class="form-group checkbox">
                    <label for="isCombo">Is this a combo item?</label>
                    <input type="checkbox" name="isCombo" value="1">
                </div>

                <div class="form-group">
                    <input type="submit" value="Add Food" class="submit-btn">
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>© 2025 Projection Room. All Rights Reserved.</p>
    </footer>
</body>
</html>
