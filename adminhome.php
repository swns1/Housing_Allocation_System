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
        <input type="number" name="floor_area" placeholder="Floor Area (sqm)" required>
        <input type="number" name="monthly_rent" placeholder="Monthly Rent" required>
        <input type="text" name="annual_range" placeholder="Annual Range" required>
        <input type="text" name="capacity" placeholder="Capacity" required>
        <select name="location_type" required>
            <option value="Urban">Urban</option>
            <option value="Rural">Rural</option>
        </select>
        <input type="text" name="utilities" placeholder="Utilities" required>
        <input type="text" name="amenities" placeholder="Amenities" required>
        <select name="status" required>
            <option value="Available">Available</option>
            <option value="Occupied">Occupied</option>
            <option value="Maintenance">Under Maintenance</option>
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
                echo "<form method='post' action='adminhome.php'>";
                echo "<input type='hidden' name='property_id' value='{$property['id']}'>";
                echo "<input type='text' name='property_name' value='{$property['property_name']}'>";
                echo "<input type='number' name='floor_area' value='{$property['floor_area']}'>";
                echo "<input type='number' name='monthly_rent' value='{$property['monthly_rent']}'>";
                echo "<input type='text' name='annual_range' value='{$property['annual_range']}'>";
                echo "<input type='text' name='capacity' value='{$property['capacity']}'>";
                echo "<select name='location_type'>";
                echo "<option value='Urban' ".($property['location_type']=='Urban'?'selected':'').">Urban</option>";
                echo "<option value='Rural' ".($property['location_type']=='Rural'?'selected':'').">Rural</option>";
                echo "</select>";
                echo "<input type='text' name='utilities' value='{$property['utilities']}'>";
                echo "<input type='text' name='amenities' value='{$property['amenities']}'>";
                echo "<select name='status'>";
                echo "<option value='Available' ".($property['status']=='Available'?'selected':'').">Available</option>";
                echo "<option value='Occupied' ".($property['status']=='Occupied'?'selected':'').">Occupied</option>";
                echo "<option value='Maintenance' ".($property['status']=='Maintenance'?'selected':'').">Maintenance</option>";
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
      $floor_area = mysqli_real_escape_string($conn, $_POST['floor_area']);
      $monthly_rent = mysqli_real_escape_string($conn, $_POST['monthly_rent']);
      $annual_range = mysqli_real_escape_string($conn, $_POST['annual_range']);
      $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);
      $location_type = mysqli_real_escape_string($conn, $_POST['location_type']);
      $utilities = mysqli_real_escape_string($conn, $_POST['utilities']);
      $amenities = mysqli_real_escape_string($conn, $_POST['amenities']);
      $status = mysqli_real_escape_string($conn, $_POST['status']);
    
      mysqli_query($conn, "INSERT INTO properties (property_name, floor_area, monthly_rent, annual_range, capacity, location_type, utilities, amenities, status) 
                          VALUES ('$name', '$floor_area', '$monthly_rent', '$annual_range', '$capacity', '$location_type', '$utilities', '$amenities', '$status')");
      header("Location: adminhome.php");
      exit();
  }

  if(isset($_POST['edit_property'])) {
      $id = $_POST['property_id'];
      $name = mysqli_real_escape_string($conn, $_POST['property_name']);
      $floor_area = mysqli_real_escape_string($conn, $_POST['floor_area']);
      $monthly_rent = mysqli_real_escape_string($conn, $_POST['monthly_rent']);
      $annual_range = mysqli_real_escape_string($conn, $_POST['annual_range']);
      $capacity = mysqli_real_escape_string($conn, $_POST['capacity']);
      $location_type = mysqli_real_escape_string($conn, $_POST['location_type']);
      $utilities = mysqli_real_escape_string($conn, $_POST['utilities']);
      $amenities = mysqli_real_escape_string($conn, $_POST['amenities']);
      $status = mysqli_real_escape_string($conn, $_POST['status']);
    
      mysqli_query($conn, "UPDATE properties 
                          SET property_name='$name', floor_area='$floor_area', monthly_rent='$monthly_rent',
                              annual_range='$annual_range', capacity='$capacity', location_type='$location_type',
                              utilities='$utilities', amenities='$amenities', status='$status'
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