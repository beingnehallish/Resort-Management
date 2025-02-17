<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Add new staff
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_staff'])) {
    $first_name = $_POST['first_name'];
    $last_name = $_POST['last_name'];
    $position = $_POST['position'];
    $email = $_POST['email'];
    $phone = $_POST['phone'];

    $query = "INSERT INTO staff (first_name, last_name, position, email, phone) VALUES ('$first_name', '$last_name', '$position', '$email', '$phone')";
    mysqli_query($conn, $query);
    header("Location: staff.php");
}

// Delete staff
if (isset($_GET['delete_id'])) {
    $staff_id = $_GET['delete_id'];
    $query = "DELETE FROM staff WHERE staff_id=$staff_id";
    mysqli_query($conn, $query);
    header("Location: staff.php");
}

// Fetch staff
$query = "SELECT * FROM staff";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Staff</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Staff</h1>
        <a href="dashboard.php" class="btn1">Back to Dashboard</a><br><br>
        <form method="post">
            <input type="text" name="first_name" placeholder="First Name" required>
            <input type="text" name="last_name" placeholder="Last Name" required>
            <input type="text" name="position" placeholder="Position" required>
            <input type="email" name="email" placeholder="Email" required>
            <input type="text" name="phone" placeholder="Phone" required>
            <input type="number" name="salary" placeholder="Salary" required>
            <button type="submit" name="add_staff">Add Staff</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Position</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Salary</th>
                    <th>Action</th>
                    
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['staff_id']; ?></td>
                        <td><?php echo $row['first_name']; ?></td>
                        <td><?php echo $row['last_name']; ?></td>
                        <td><?php echo $row['position']; ?></td>
                        <td><?php echo $row['email']; ?></td>
                        <td><?php echo $row['phone']; ?></td>
                        <td><?php echo $row['salary']; ?></td>
                        <td>
                            <a href="staff.php?delete_id=<?php echo $row['staff_id']; ?>">Delete</a>
                            <a href="edit_staff.php?id=<?php echo $row['staff_id']; ?>">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
