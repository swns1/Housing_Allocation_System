<?php
session_start();
include('connect.php');
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
</head>
<body>
    <h2>Admin Dashboard</h2>
    
    <!-- Add Property Form -->
    <form method="post" action="adminhome.php">
        <h3>Add New Property</h3>
        <input type="text" name="property_name" placeholder="Property Name" required>
        <select name="property_type" required>
            <option value="apartment">Apartment</option>
            <option value="house">House</option>
            <option value="studio">Studio</option>
        </select>
        <input type="text" name="location" placeholder="Location" required>
        <input type="number" name="price" placeholder="Price" required>
        <select name="status" required>
            <option value="available">Available</option>
            <option value="occupied">Occupied</option>
            <option value="maintenance">Under Maintenance</option>
        </select>
        <button type="submit" name="add_property">Add Property</button>
    </form>

    <!-- Property List -->
    <div class="property-list">
        <h3>Manage Properties</h3>
        <?php
            $properties = mysqli_query($conn, "SELECT * FROM properties");
            while($property = mysqli_fetch_array($properties)) {
                echo "<div class='property-item'>";
                echo "<h4>{$property['property_name']}</h4>";
                echo "<p>Type: {$property['property_type']}</p>";
                echo "<p>Location: {$property['location']}</p>";
                echo "<p>Price: ₱" . $property['price'] . "</p>";
                echo "<p>Status: {$property['status']}</p>";
            
                echo "<form method='post' action='adminhome.php'>";
                echo "<input type='hidden' name='property_id' value='{$property['id']}'>";
                echo "<input type='text' name='property_name' value='{$property['property_name']}'>";
                echo "<select name='property_type'>";
                echo "<option value='apartment' ".($property['property_type']=='apartment'?'selected':'').">Apartment</option>";
                echo "<option value='house' ".($property['property_type']=='house'?'selected':'').">House</option>";
                echo "<option value='studio' ".($property['property_type']=='studio'?'selected':'').">Studio</option>";
                echo "</select>";
                echo "<input type='text' name='location' value='{$property['location']}'>";
                echo "<input type='number' name='price' value='{$property['price']}'>";
                echo "<select name='status'>";
                echo "<option value='available' ".($property['status']=='available'?'selected':'').">Available</option>";
                echo "<option value='occupied' ".($property['status']=='occupied'?'selected':'').">Occupied</option>";
                echo "<option value='maintenance' ".($property['status']=='maintenance'?'selected':'').">Under Maintenance</option>";
                echo "</select>";
                echo "<button type='submit' name='edit_property'>Update</button>";
                echo "</form>";
            
                echo "<form method='post' action='adminhome.php'>";
                echo "<input type='hidden' name='property_id' value='{$property['id']}'>";
                echo "<button type='submit' name='delete_property'>Delete</button>";
                echo "</form>";
                echo "</div>";
            }
        ?>
    </div></body>
</html>
  <?php
  if(isset($_POST['add_property'])) {
      $name = mysqli_real_escape_string($conn, $_POST['property_name']);
      $type = mysqli_real_escape_string($conn, $_POST['property_type']);
      $location = mysqli_real_escape_string($conn, $_POST['location']);
      $price = mysqli_real_escape_string($conn, $_POST['price']);
      $status = mysqli_real_escape_string($conn, $_POST['status']);
    
      mysqli_query($conn, "INSERT INTO properties (property_name, property_type, location, price, status) 
                          VALUES ('$name', '$type', '$location', '$price', '$status')");
      header("Location: adminhome.php");
      exit();
  }

  if(isset($_POST['edit_property'])) {
      $id = $_POST['property_id'];
      $name = mysqli_real_escape_string($conn, $_POST['property_name']);
      $type = mysqli_real_escape_string($conn, $_POST['property_type']);
      $location = mysqli_real_escape_string($conn, $_POST['location']);
      $price = mysqli_real_escape_string($conn, $_POST['price']);
      $status = mysqli_real_escape_string($conn, $_POST['status']);
    
      mysqli_query($conn, "UPDATE properties 
                          SET property_name='$name', property_type='$type', 
                              location='$location', price='$price', status='$status' 
                          WHERE id=$id");
      header("Location: adminhome.php");
      exit();
  }

  if(isset($_POST['delete_property'])) {
      $id = $_POST['property_id'];
      mysqli_query($conn, "DELETE FROM properties WHERE id=$id");
      header("Location: adminhome.php");
      exit();
  }  ?>