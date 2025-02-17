<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: index.php");
    exit();
}

// Add new service
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['add_service'])) {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $query = "INSERT INTO service (service_name, description, price) VALUES ('$service_name', '$description', '$price')";
    mysqli_query($conn, $query);
    header("Location: service.php");
}

// Delete service
if (isset($_GET['delete_id'])) {
    $service_id = $_GET['delete_id'];
    $query = "DELETE FROM service WHERE service_id=$service_id";
    mysqli_query($conn, $query);
    header("Location: service.php");
}

// Fetch services
$query = "SELECT * FROM service";
$result = mysqli_query($conn, $query);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Service</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Service</h1>
        <a href="dashboard.php" class="btn1">Back to Dashboard</a><br><br>
        <form method="post">
            <input type="text" name="service_name" placeholder="Service Name" required>
            <textarea name="description" placeholder="Description" required></textarea>
            <input type="text" name="price" placeholder="Price" required>
            <button type="submit" name="add_service">Add Service</button>
        </form>
        <table>
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Service Name</th>
                    <th>Description</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = mysqli_fetch_assoc($result)) { ?>
                    <tr>
                        <td><?php echo $row['service_id']; ?></td>
                        <td><?php echo $row['service_name']; ?></td>
                        <td><?php echo $row['description']; ?></td>
                        <td><?php echo $row['price']; ?></td>
                        <td>
                            <a href="service.php?delete_id=<?php echo $row['service_id']; ?>">Delete</a>
                            <a href="edit_service.php?id=<?php echo $row['service_id']; ?>">Edit</a>
                        </td>
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</body>
</html>
