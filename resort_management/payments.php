<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: dashboard.php");
    exit();
}

// Add new payment
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_payment'])) {
    $reservation_id = $_POST['reservation_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $payment_method = $_POST['payment_method'];

    $query = "INSERT INTO payments (reservation_id, amount, payment_date, payment_method) VALUES ('$reservation_id', '$amount', '$payment_date', '$payment_method')";
    mysqli_query($conn, $query);
    header("Location: payments.php");
}

// Delete payment
if (isset($_GET['delete_id'])) {
    $payment_id = $_GET['delete_id'];
    $query = "DELETE FROM payments WHERE payment_id=$payment_id";
    mysqli_query($conn, $query);
    header("Location: payments.php");
}

// Fetch payments
$query = "SELECT payments.*, reservations.check_in_date, reservations.check_out_date, guests.first_name, guests.last_name FROM payments JOIN reservations ON payments.reservation_id = reservations.reservation_id JOIN guests ON reservations.guest_id = guests.guest_id";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Payments</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Payments</h1>
        <a href="dashboard.php" class="btn1">Back to Dashboard</a><br><br>
        <form method="post">
            <select name="reservation_id" required>
                <?php
                $reservation_query = "SELECT reservations.*, guests.first_name, guests.last_name FROM reservations JOIN guests ON reservations.guest_id = guests.guest_id";
                $reservation_result = mysqli_query($conn, $reservation_query);
                while ($reservation_row = mysqli_fetch_assoc($reservation_result)) {
                    echo "<option value='{$reservation_row['reservation_id']}'>{$reservation_row['first_name']} {$reservation_row['last_name']} - {$reservation_row['check_in_date']} to {$reservation_row['check_out_date']}</option>";
                }
                ?>
            </select>
            <input type="text" name="amount" placeholder="Amount" required>
            <input type="date" name="payment_date" placeholder="Payment Date" required>
            <select name="payment_method" required>
            <option value="">Mode of Payment</option>
                <option value="cash">Cash</option>
                <option value="credit_card">Credit Card</option>
                <option value="debit_card">Debit Card</option>
                <option value="online">Online</option>
            </select>
            <select name="status" required>
            <option value="">Status</option>
            <option value="pending">Pending</option>
            <option value="paid">Paid</option>            </select>
            <button type="submit" name="add_payment">Add Payment</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Reservation</th>
                    <th>Amount</th>
                    <th>Payment Date</th>
                    <th>Payment Method</th>
                    <th>Status</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['payment_id']; ?></td>
                        <td><?php echo $row['first_name'] . ' ' . $row['last_name']; ?> (<?php echo $row['check_in_date'] . ' to ' . $row['check_out_date']; ?>)</td>
                        <td><?php echo $row['amount']; ?></td>
                        <td><?php echo $row['payment_date']; ?></td>
                        <td><?php echo $row['payment_method']; ?></td>
                        <td><?php echo $row['status']; ?></td>
                        <td>
                            <a href="payments.php?delete_id=<?php echo $row['payment_id']; ?>">Delete</a>
                            <a href="edit_payments.php?id=<?php echo $row['payment_id']; ?>">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
