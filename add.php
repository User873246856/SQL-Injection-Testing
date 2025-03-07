<?php
session_start();
if(!isset($_SESSION['username'])) {
    header("location:index.php");
    exit;
} else {
    include "connect.php";
    $username = $_SESSION['username'];
    $query = $db->prepare("SELECT * FROM user WHERE username=?");
    $query->execute(array($username));
    $control = $query->fetch(PDO::FETCH_ASSOC);
    if($control['admin'] != 1) {
        header("Location:films.php");
        exit;
    }
}

$Name = $Description = "";
$errors = array('name'=>'', 'description'=>'');
$errorflag = 0;

if(isset($_POST['submit'])){
    if(empty($_POST['name'])) {
        $errors['name'] = 'Name is required.';
        $errorflag = 1;
    } else {
        $Name = htmlspecialchars($_POST['name']);
    }
    
    if(empty($_POST['description'])) {
        $errors['description'] = 'Description is required.';
        $errorflag = 1;
    } else {
        $Description = htmlspecialchars($_POST['description']);
    }
    
    if($errorflag == 0) {
        $nameEscaped = mysqli_real_escape_string($conn, $Name);
        $descriptionEscaped = mysqli_real_escape_string($conn, $Description);
        $sql = "INSERT INTO films (name, description) VALUES ('$nameEscaped', '$descriptionEscaped')";
        
        if(mysqli_query($conn, $sql)) {
            header("Location:admin.php");
            exit;
        } else {
            echo 'Error: ' . mysqli_error($conn);
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add New Film - Projection Room</title>
    <link rel="stylesheet" href="stylesheets/add-film.css">
</head>
<body>
    <header>
        <div class="container">
            <h1>Projection Room - Add Film</h1>
        </div>
    </header>
    <main>
        <div class="form-container">
            <p class="welcome">Welcome, <?php echo htmlspecialchars($username); ?></p>
            <h2>Add a New Film</h2>
            <form action="add.php" method="POST">
                <div class="form-group">
                    <label for="name">Film Name</label>
                    <input type="text" name="name" id="name" value="<?php echo htmlspecialchars($Name); ?>" required>
                    <span class="error"><?php echo $errors['name']; ?></span>
                </div>
                <div class="form-group">
                    <label for="description">Description</label>
                    <textarea name="description" id="description" rows="4" required><?php echo htmlspecialchars($Description); ?></textarea>
                    <span class="error"><?php echo $errors['description']; ?></span>
                </div>
                <div class="form-group">
                    <input type="submit" value="Add Film" name="submit" class="submit-btn">
                </div>
            </form>
            <div class="link-box">
                <a href="admin.php" class="btn">Back to Admin</a>
                <a href="logout.php" class="btn logout">Logout</a>
            </div>
        </div>
    </main>
    <footer>
        <p>© <?php echo date("Y"); ?> Projection Room. All rights reserved.</p>
    </footer>
</body>
</html>
