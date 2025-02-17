<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: reservation.php");
    exit();
}

// Get reservation ID from URL
if (isset($_GET['id'])) {
    $reservation_id = $_GET['id'];

    // Fetch reservation details
    $query = "SELECT reservations.*, guests.first_name, guests.last_name, rooms.room_number FROM reservations
              JOIN guests ON reservations.guest_id = guests.guest_id
              JOIN rooms ON reservations.room_id = rooms.room_id
              WHERE reservation_id = $reservation_id";
    $result = mysqli_query($conn, $query);
    $reservation = mysqli_fetch_assoc($result);

    if (!$reservation) {
        echo "Reservation not found!";
        exit();
    }
} else {
    header("Location: reservations.php");
    exit();
}

// Update reservation details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_reservation'])) {
    $guest_id = $_POST['guest_id'];
    $room_id = $_POST['room_id'];
    $check_in_date = $_POST['check_in_date'];
    $check_out_date = $_POST['check_out_date'];
    $total_price = $_POST['total_price'];
    $status = $_POST['status'];

    $update_query = "UPDATE reservations SET guest_id = '$guest_id', room_id = '$room_id', check_in_date = '$check_in_date',
                    check_out_date = '$check_out_date', total_price = '$total_price', status = '$status' 
                    WHERE reservation_id = $reservation_id";
    mysqli_query($conn, $update_query);

    header("Location: reservations.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Reservation</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Reservation</h1>
        <form method="post">
            <label for="guest_id">Guest:</label>
            <select name="guest_id" required>
                <?php
                $guest_query = "SELECT * FROM guests";
                $guest_result = mysqli_query($conn, $guest_query);
                while ($guest_row = mysqli_fetch_assoc($guest_result)) {
                    $selected = ($guest_row['guest_id'] == $reservation['guest_id']) ? 'selected' : '';
                    echo "<option value='{$guest_row['guest_id']}' $selected>{$guest_row['first_name']} {$guest_row['last_name']}</option>";
                }
                ?>
            </select>

            <label for="room_id">Room:</label>
            <select name="room_id" required>
                <?php
                $room_query = "SELECT * FROM rooms";
                $room_result = mysqli_query($conn, $room_query);
                while ($room_row = mysqli_fetch_assoc($room_result)) {
                    $selected = ($room_row['room_id'] == $reservation['room_id']) ? 'selected' : '';
                    echo "<option value='{$room_row['room_id']}' $selected>{$room_row['room_number']}</option>";
                }
                ?>
            </select>

            <label for="check_in_date">Check-in Date:</label>
            <input type="date" name="check_in_date" value="<?php echo $reservation['check_in_date']; ?>" required>

            <label for="check_out_date">Check-out Date:</label>
            <input type="date" name="check_out_date" value="<?php echo $reservation['check_out_date']; ?>" required>

            <label for="total_price">Total Price:</label>
            <input type="text" name="total_price" value="<?php echo $reservation['total_price']; ?>" required>

            <label for="status">Status:</label>
            <select name="status" required>
                <option value="confirmed" <?php echo ($reservation['status'] == 'confirmed') ? 'selected' : ''; ?>>Confirmed</option>
                <option value="cancelled" <?php echo ($reservation['status'] == 'cancelled') ? 'selected' : ''; ?>>Cancelled</option>
            </select>

            <button type="submit" name="update_reservation">Update Reservation</button>
        </form>
        <a href="reservations.php" class="back-to-reservations">Back to Reservations</a> <!-- Back to Reservations link -->
    </div>
</body>
</html>
