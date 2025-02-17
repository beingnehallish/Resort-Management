<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Add new reservation
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_reservation'])) {
    $guest_id = $_POST['guest_id'];
    $room_id = $_POST['room_id'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $total_price = $_POST['total_price'];
    $status = $_POST['status'];

    $query = "INSERT INTO reservations (guest_id, room_id, check_in_date, check_out_date, total_price, status) VALUES ('$guest_id', '$room_id', '$check_in_date', '$check_out_date', '$total_price', '$status')";
    mysqli_query($conn, $query);
    header("Location: reservations.php");
}

// Delete reservation
if (isset($_GET['delete_id'])) {
    $reservation_id = $_GET['delete_id'];
    $query = "DELETE FROM reservations WHERE reservation_id=$reservation_id";
    mysqli_query($conn, $query);
    header("Location: reservations.php");
}

// Fetch reservations
$query = "SELECT reservations.*, guests.first_name, guests.last_name, rooms.room_number FROM reservations JOIN guests ON reservations.guest_id = guests.guest_id JOIN rooms ON reservations.room_id = rooms.room_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Reservations</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Reservations</h1>
        <a href="dashboard.php" class="btn1">Back to Dashboard</a><br><br>
        <form method="post">
            <select name="guest_id" required>
                <?php
                $guest_query = "SELECT * FROM guests";
                $guest_result = mysqli_query($conn, $guest_query);
                while ($guest_row = mysqli_fetch_assoc($guest_result)) {
                    echo "<option value='{$guest_row['guest_id']}'>{$guest_row['first_name']} {$guest_row['last_name']}</option>";
                }
                ?>
            </select>
            <select name="room_id" required>
                <?php
                $room_query = "SELECT * FROM rooms WHERE status='available'";
                $room_result = mysqli_query($conn, $room_query);
                while ($room_row = mysqli_fetch_assoc($room_result)) {
                    echo "<option value='{$room_row['room_id']}'>Room {$room_row['room_number']}</option>";
                }
                ?>
            </select>
            <input type="date" name="check_in_date" placeholder="Check-in Date" required>
            <input type="date" name="check_out_date" placeholder="Check-out Date" required>
            <input type="text" name="total_price" placeholder="Total Price" required>
            <select name="status" required>
                <option value="">Confirmed/Cancelled</option>
                <option value="confirmed">Confirmed</option>
                <option value="cancelled">Cancelled</option>
            </select>
            <button type="submit" name="add_reservation">Add Reservation</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Guest</th>
                    <th>Room</th>
                    <th>Check-in</th>
                    <th>Check-out</th>
                    <th>Total Price</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['reservation_id']; ?></td>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?></td>
                        <td><?php echo $row['room_number']; ?></td>
                        <td><?php echo $row['check_in_date']; ?></td>
                        <td><?php echo $row['check_out_date']; ?></td>
                        <td><?php echo $row['total_price']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <a href="reservations.php?delete_id=<?php echo $row['reservation_id']; ?>">Delete</a>
                            <a href="edit_reservation.php?id=<?php echo $row['reservation_id']; ?>">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
