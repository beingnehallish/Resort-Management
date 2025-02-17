<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: rooms.php");
    exit();
}

// Get room ID from URL
if (isset($_GET['id'])) {
    $room_id = $_GET['id'];

    // Fetch room details
    $query = "SELECT * FROM rooms WHERE room_id = $room_id";
    $result = mysqli_query($conn, $query);
    $room = mysqli_fetch_assoc($result);

    if (!$room) {
        echo "Room not found!";
        exit();
    }
} else {
    header("Location: rooms.php");
    exit();
}

// Update room details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_room'])) {
    $room_type = $_POST['room_type'];
    $room_number = $_POST['room_number'];
    $status = $_POST['status'];
    $price = $_POST['price'];

    $update_query = "UPDATE rooms SET room_type = '$room_type', room_number = '$room_number', status = '$status', price = '$price' WHERE room_id = $room_id";
    mysqli_query($conn, $update_query);

    header("Location: rooms.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Room</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Room</h1>
        <form method="post">
            <label for="room_type">Room Type:</label>
            <input type="text" name="room_type" value="<?php echo $room['room_type']; ?>" required>

            <label for="room_number">Room Number:</label>
            <input type="text" name="room_number" value="<?php echo $room['room_number']; ?>" required>

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="available" <?php echo ($room['status'] == 'available') ? 'selected' : ''; ?>>Available</option>
                <option value="booked" <?php echo ($room['status'] == 'booked') ? 'selected' : ''; ?>>Booked</option>
                <option value="maintenance" <?php echo ($room['status'] == 'maintenance') ? 'selected' : ''; ?>>Maintenance</option>
            </select>

            <label for="price">Price:</label>
            <input type="text" name="price" value="<?php echo $room['price']; ?>" required>

            <button type="submit" name="update_room">Update Room</button>
        </form>
        <a href="rooms.php" class="btn1">Back to Rooms</a> <!-- Back to Rooms link -->
    </div>
</body>
</html>
