<?php
session_start();
if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Welcome, Admin.</h1>
        <nav>
            <ul>
            <li><a href="logout.php" class="btn1">Logout</a></li><br>
                <li><a href="rooms.php" class="btn">Manage Rooms</a></li><br>
                <li><a href="guests.php" class="btn">Manage Guests</a></li><br>
                <li><a href="reservations.php" class="btn">Manage Reservations</a></li><br>
                <li><a href="staff.php" class="btn">Manage Staff</a></li><br>
                <li><a href="service.php" class="btn">Manage Service</a></li><br>
                <li><a href="payments.php" class="btn">Manage Payments</a></li><br>
                
            </ul>
        </nav>
    </div>
</body>
</html>
