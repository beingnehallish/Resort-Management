<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Get guest ID from URL
if (isset($_GET['id'])) {
    $guest_id = $_GET['id'];

    // Fetch guest details
    $query = "SELECT * FROM guests WHERE guest_id = $guest_id";
    $result = mysqli_query($conn, $query);
    $guest = mysqli_fetch_assoc($result);

    if (!$guest) {
        echo "Guest not found!";
        exit();
    }
} else {
    header("Location: guests.php");
    exit();
}

// Update guest details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_guest'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $address = $_POST['address'];

    $update_query = "UPDATE guests SET first_name = '$first_name', last_name = '$last_name', email = '$email', phone = '$phone', address = '$address' WHERE guest_id = $guest_id";
    mysqli_query($conn, $update_query);

    header("Location: guests.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Guest</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Guest</h1>
        <form method="post">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo $guest['first_name']; ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $guest['last_name']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $guest['email']; ?>" required>

            <label for="phone">Phone:</label>
            <input type="text" name="phone" value="<?php echo $guest['phone']; ?>" required>

            <label for="address">Address:</label>
            <textarea name="address" required><?php echo $guest['address']; ?></textarea>

            <button type="submit" name="update_guest">Update Guest</button>
        </form>
        <a href="guests.php" class="btn1">Back to Guests</a> <!-- Back to Guests link -->
    </div>
</body>
</html>
