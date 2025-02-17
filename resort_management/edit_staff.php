<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: staff.php");
    exit();
}

// Get staff ID from URL
if (isset($_GET['id'])) {
    $staff_id = $_GET['id'];

    // Fetch staff details
    $query = "SELECT * FROM staff WHERE staff_id = $staff_id";
    $result = mysqli_query($conn, $query);
    $staff = mysqli_fetch_assoc($result);

    if (!$staff) {
        echo "Staff member not found!";
        exit();
    }
} else {
    header("Location: staff.php");
    exit();
}

// Update staff details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_staff'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];
    $position = $_POST['position'];
    $salary = $_POST['salary'];

    $update_query = "UPDATE staff SET first_name = '$first_name', last_name = '$last_name', email = '$email', phone = '$phone', position = '$position', salary = '$salary' WHERE staff_id = $staff_id";
    mysqli_query($conn, $update_query);

    header("Location: staff.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Staff Member</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Staff Member</h1>
        <form method="post">
            <label for="first_name">First Name:</label>
            <input type="text" name="first_name" value="<?php echo $staff['first_name']; ?>" required>

            <label for="last_name">Last Name:</label>
            <input type="text" name="last_name" value="<?php echo $staff['last_name']; ?>" required>

            <label for="email">Email:</label>
            <input type="email" name="email" value="<?php echo $staff['email']; ?>" required>

            <label for="phone">Phone:</label>
            <input type="text" name="phone" value="<?php echo $staff['phone']; ?>" required>

            <label for="position">Position:</label>
            <input type="text" name="position" value="<?php echo $staff['position']; ?>" required>

            <label for="salary">Salary:</label>
            <input type="text" name="salary" value="<?php echo $staff['salary']; ?>" required>

            <button type="submit" name="update_staff">Update Staff</button>
        </form>
        <a href="staff.php" class="btn1">Back to Staff</a> <!-- Back to Staff link -->
    </div>
</body>
</html>
