<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Add new room
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_room'])) {
    $room_type = $_POST['room_type'];
    $room_number = $_POST['room_number'];
    $status = $_POST['status'];
    $price = $_POST['price'];

    $query = "INSERT INTO rooms (room_type, room_number, status, price) VALUES ('$room_type', '$room_number', '$status', '$price')";
    mysqli_query($conn, $query);
    header("Location: rooms.php");
}

// Delete room
if (isset($_GET['delete_id'])) {
    $room_id = $_GET['delete_id'];
    $query = "DELETE FROM rooms WHERE room_id=$room_id";
    mysqli_query($conn, $query);
    header("Location: rooms.php");
}

// Fetch rooms
$query = "SELECT * FROM rooms";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Rooms</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Rooms</h1>
        <a href="dashboard.php" class="btn1">Back to Dashboard</a><br><br>
        <form method="post">
            <input type="text" name="room_type" placeholder="Room Type" required>
            <input type="text" name="room_number" placeholder="Room Number" required>
            <select name="status" required>
                <option value="available">Available</option>
                <option value="booked">Booked</option>
                <option value="maintenance">Maintenance</option>
            </select>
            <input type="text" name="price" placeholder="Price" required>
            <button type="submit" name="add_room">Add Room</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Room Type</th>
                    <th>Room Number</th>
                    <th>Status</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['room_id']; ?></td>
                        <td><?php echo $row['room_type']; ?></td>
                        <td><?php echo $row['room_number']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td>
                            <a href="rooms.php?delete_id=<?php echo $row['room_id']; ?>">Delete</a>
                            <a href="edit_room.php?id=<?php echo $row['room_id']; ?>">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
