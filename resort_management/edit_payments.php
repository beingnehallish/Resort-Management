<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: payments.php");
    exit();
}

// Get payment ID from URL
if (isset($_GET['id'])) {
    $payment_id = $_GET['id'];

    // Fetch payment details
    $query = "SELECT * FROM payments WHERE payment_id = $payment_id";
    $result = mysqli_query($conn, $query);
    $payment = mysqli_fetch_assoc($result);

    if (!$payment) {
        echo "Payment not found!";
        exit();
    }
} else {
    header("Location: payments.php");
    exit();
}

// Update payment details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_payment'])) {
    $reservation_id = $_POST['reservation_id'];
    $amount = $_POST['amount'];
    $payment_date = $_POST['payment_date'];
    $payment_method = $_POST['payment_method'];
    $status = $_POST['status'];

    $update_query = "UPDATE payments SET reservation_id = '$reservation_id', amount = '$amount', payment_date = '$payment_date',
                    payment_method = '$payment_method', status = '$status' WHERE payment_id = $payment_id";
    mysqli_query($conn, $update_query);

    header("Location: payments.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Payment</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Payment</h1>
        <form method="post">
            <label for="reservation_id">Reservation ID:</label>
            <input type="text" name="reservation_id" value="<?php echo $payment['reservation_id']; ?>" required>

            <label for="amount">Amount:</label>
            <input type="text" name="amount" value="<?php echo $payment['amount']; ?>" required>

            <label for="payment_date">Payment Date:</label>
            <input type="date" name="payment_date" value="<?php echo $payment['payment_date']; ?>" required>

            <label for="payment_method">Payment Method:</label>
            <select name="payment_method" required>
                <option value="credit_card" <?php echo ($payment['payment_method'] == 'credit_card') ? 'selected' : ''; ?>>Credit Card</option>
                <option value="debit_card" <?php echo ($payment['payment_method'] == 'debit_card') ? 'selected' : ''; ?>>Debit Card</option>
                <option value="cash" <?php echo ($payment['payment_method'] == 'cash') ? 'selected' : ''; ?>>Cash</option>
                <option value="online" <?php echo ($payment['payment_method'] == 'online') ? 'selected' : ''; ?>>Online</option>
            </select>
            <label for="status">Status:</label>
            <select name="status" required>
                <option value="paid" <?php echo ($payment['status'] == 'paid') ? 'selected' : ''; ?>>Paid</option>
                <option value="pending" <?php echo ($payment['status'] == 'pending') ? 'selected' : ''; ?>>Pending</option>
            </select>

            <button type="submit" name="update_payment">Update Payment</button>
        </form>
        <a href="payments.php" class="btn1">Back to Payments</a> <!-- Back to Payments link -->
    </div>
</body>
</html>
