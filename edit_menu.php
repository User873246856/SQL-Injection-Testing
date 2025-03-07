<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit;
}

include "connect.php"; // Include your database connection file
$username = $_SESSION['username'];
$query = $db->prepare("SELECT * FROM user WHERE username=?");
$query->execute([$username]);
$control = $query->fetch(PDO::FETCH_ASSOC);
if ($control['admin'] != 1) {
    header("Location: new_food_drink.php"); // Redirect for normal users
    exit; 
}

$name = $description = "";
$errors = ["name" => "", "description" => ""];
$errorsflag = 0;

// Check if ID is provided
if (!isset($_GET['id'])) {
    header("Location: new_food_drink.php"); // Redirect if no ID is provided
    exit;
}

$id = $_GET['id'];
$query = $db->prepare("SELECT * FROM menu WHERE ID=?");
$query->execute([$id]);
$foodItem = $query->fetch(PDO::FETCH_ASSOC);

if (!$foodItem) {
    header("Location: new_food_drink.php"); // Redirect if no matching food item is found
    exit; 
}

// Get existing values
$name = $foodItem['name'];
$description = $foodItem['description'];
$isCombo = false;

// Check if the food item is part of a combo
$comboCheckQuery = $db->prepare("SELECT * FROM combos WHERE food_item = ?");
$comboCheckQuery->execute([$name]);
if ($comboCheckQuery->rowCount() > 0) {
    $isCombo = true; // The item is part of a combo
}

// Handle form submission for editing the food item
if (isset($_POST['submit'])) {
    if (empty($_POST['name'])) {
        $errors['name'] = "Name is empty.<br>";
        $errorsflag = 1;
    } else {
        $name = htmlspecialchars($_POST['name']);
    }

    if (empty($_POST['description'])) {
        $errors['description'] = "Description is empty.<br>";
        $errorsflag = 1;
    } else {
        $description = htmlspecialchars($_POST['description']);
    }
    
    // Check if the food item should continue being part of the combo
    $shouldBeCombo = isset($_POST['isCombo']) ? 1 : 0;

    // If no errors, proceed to update
    if ($errorsflag == 0) {
        $sql = "UPDATE menu SET name = :name, description = :description WHERE ID = :id";
        $stmt = $db->prepare($sql);
        $stmt->bindParam(':name', $name);
        $stmt->bindParam(':description', $description);
        $stmt->bindParam(':id', $id);

        if ($stmt->execute()) {
            if ($shouldBeCombo) {
                // Add to combos if it is not already in the combo
                if (!$isCombo) {
                    $comboID = 'combo.php';
                    $comboStmt = $db->prepare("INSERT INTO combos (combo_id, food_item) VALUES (?, ?)");
                    $comboStmt->execute([$comboID, $name]);
                }
            } else {
                // If it was in the combo and now it is not, remove it from combos
                if ($isCombo) {
                    $removeComboStmt = $db->prepare("DELETE FROM combos WHERE food_item = ?");
                    $removeComboStmt->execute([$name]);
                }
            }
            header('Location: new_food_drink.php'); // Redirect after successful update
            exit;
        } else {
            echo 'Query Error: ' . $stmt->errorInfo()[2];
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Edit Menu Item</title>
    <link rel="stylesheet" href="stylesheets/edit_menu.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Projection Room - Edit Menu Item</h1>
            <nav>
                <ul>
                    <li><a href="index.php">Home</a></li>
                    <li><a href="new_food_drink.php">Menu</a></li>
                    <li><a href="logout.php">Logout</a></li>
                </ul>
            </nav>
        </div>
    </header>

    <main>
        <div class="admin-container">
            <h2>Edit Food Item</h2>
            <h4>Welcome, <?php echo htmlspecialchars($_SESSION['username']); ?></h4>

            <form action="edit_menu.php?id=<?php echo htmlspecialchars($id); ?>" method="POST" class="edit-form">
                <label for="name">Food Name</label>
                <input type="text" id="name" name="name" value="<?php echo htmlspecialchars($name); ?>" required>
                <div class="error"><?php echo $errors['name']; ?></div>

                <label for="description">Food Description</label>
                <textarea id="description" name="description" required><?php echo htmlspecialchars($description); ?></textarea>
                <div class="error"><?php echo $errors['description']; ?></div>

                <label class="combo-checkbox">
                    <input type="checkbox" name="isCombo" <?php echo $isCombo ? 'checked' : ''; ?>>
                    Is this part of a combo?
                </label>

                <div class="buttons">
                    <button type="submit" name="submit" class="btn">Submit</button>
                    <a href="new_food_drink.php" class="btn secondary">Cancel</a>
                </div>
            </form>
        </div>
    </main>

    <footer>
        <p>© 2025 Projection Room. All rights reserved.</p>
    </footer>
</body>
</html>
