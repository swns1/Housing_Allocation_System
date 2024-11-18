<?php
session_start();
include('connect.php');

if(!isset($_SESSION['email'])) {
    header('Location: index.php');
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Home</title>
</head>
<body>
    <h1>Welcome 
    <?php
        $email = $_SESSION['email'];
        $query = mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email = '$email'");
        while($row = mysqli_fetch_array($query)){
            echo $row['username'];
        }
    ?>
    </h1>

    <div class="housing">
        <h2>Available Housing</h2>
        <?php
            $housing = mysqli_query($conn, "SELECT * FROM properties");
            while($house = mysqli_fetch_array($housing)) {
                echo "<div class='housing-card'>";
                echo "<h3>{$house['property_type']}</h3>";
                echo "<p>Location: {$house['location']}</p>";
                echo "<p>Price Range: {$house['price_range']}</p>";
                echo "<p>Area: {$house['area']} sqm</p>";
                echo "<p>Capacity: {$house['capacity']}</p>";
                echo "<p>Description: {$house['description']}</p>";
                echo "</div>";
            }
        ?>
    </div>
</body>
</html>