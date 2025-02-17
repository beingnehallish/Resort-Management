<?php
session_start();
include('db.php');

if (!isset($_SESSION['username'])) {
    header("Location: service.php");
    exit();
}

// Get service ID from URL
if (isset($_GET['id'])) {
    $service_id = $_GET['id'];

    // Fetch service details
    $query = "SELECT * FROM service WHERE service_id = $service_id";
    $result = mysqli_query($conn, $query);
    $service = mysqli_fetch_assoc($result);

    if (!$service) {
        echo "Service not found!";
        exit();
    }
} else {
    header("Location: service.php");
    exit();
}

// Update service details
if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['update_service'])) {
    $service_name = $_POST['service_name'];
    $description = $_POST['description'];
    $price = $_POST['price'];

    $update_query = "UPDATE service SET service_name = '$service_name', description = '$description', price = '$price' WHERE service_id = $service_id";
    mysqli_query($conn, $update_query);

    header("Location: service.php");
    exit();
}
?>

<!DOCTYPE html>
<html>
<head>
    <title>Edit Service</title>
    <link rel="stylesheet" type="text/css" href="style.css">
</head>
<body>
    <div class="container">
        <h1>Edit Service</h1>
        <form method="post">
            <label for="service_name">Service Name:</label>
            <input type="text" name="service_name" value="<?php echo $service['service_name']; ?>" required>

            <label for="description">Description:</label>
            <textarea name="description" required><?php echo $service['description']; ?></textarea>

            <label for="price">Price:</label>
            <input type="text" name="price" value="<?php echo $service['price']; ?>" required>

            <button type="submit" name="update_service">Update Service</button>
        </form>
        <a href="service.php" class="back-to-service">Back to Service</a> <!-- Back to Service link -->
    </div>
</body>
</html>
