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
    <select name="property_type" required>
        <option value="Apartment">Apartment</option>
        <option value="Residential Lot">Residential Lot</option>
        <option value="Condo">Condo</option>
        <option value="House and Lot">House and Lot</option>
        <option value="Commercial">Commercial</option>
    </select>
    <input type="text" name="price_range" placeholder="Price Range" required>
    <input type="text" name="location" placeholder="Location" required>
    <input type="number" name="area" placeholder="Area (sqm)" required>
    <input type="text" name="capacity" placeholder="Capacity" required>
    <textarea name="description" placeholder="Description" required></textarea>
    <button type="submit" name="add_property">Add Property</button>
</form>

    <!-- Property List -->
    <div class="property-list">
        <h3>Manage Properties</h3>
        <?php
            $properties = mysqli_query($conn, "SELECT * FROM properties");
            while($property = mysqli_fetch_array($properties)) {
                echo "<div class='property-item'>";
                echo "<form method='post' action='adminhome.php'>";
                echo "<input type='hidden' name='property_id' value='{$property['id']}'>";
                echo "<select name='property_type'>";
                $types = ['Apartment', 'Residential Lot', 'Condo', 'House and Lot', 'Commercial'];
                foreach($types as $type) {
                    echo "<option value='$type' ".($property['property_type']==$type?'selected':'').">$type</option>";
                }
                echo "</select>";
                echo "<input type='text' name='price_range' value='{$property['price_range']}'>";
                echo "<input type='text' name='location' value='{$property['location']}'>";
                echo "<input type='number' name='area' value='{$property['area']}'>";
                echo "<input type='text' name='capacity' value='{$property['capacity']}'>";
                echo "<textarea name='description'>{$property['description']}</textarea>";
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
    $type = mysqli_real_escape_string($conn, $_POST['property_type']);
    $price_range = mysqli_real_escape_string($conn, $_POST['price_range']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    mysqli_query($conn, "INSERT INTO properties (property_type, price_range, location, area, capacity, description) 
                        VALUES ('$type', '$price_range', '$location', '$area', '$capacity', '$description')");
    header("Location: adminhome.php");
    exit();
}

if(isset($_POST['edit_property'])) {
    $id = $_POST['property_id'];
    $type = mysqli_real_escape_string($conn, $_POST['property_type']);
    $price_range = mysqli_real_escape_string($conn, $_POST['price_range']);
    $location = mysqli_real_escape_string($conn, $_POST['location']);
    $area = mysqli_real_escape_string($conn, $_POST['area']);
    $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    
    mysqli_query($conn, "UPDATE properties 
                        SET property_type='$type', price_range='$price_range', location='$location',
                            area='$area', capacity='$capacity', description='$description'
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