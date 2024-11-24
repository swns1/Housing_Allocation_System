<?php 
// DatabaseHandler Class for managing database connection and queries
class DatabaseHandler {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "php_project";
    private $conn;

    // Constructor to initialize database connection
    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);

        // Check connection
        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    // Method to fetch properties based on search and filters
    public function getProperties($search = "", $filter = "") {
        $query = "SELECT id, property_type, price_range, location, area, capacity, description FROM properties";

        // Adding search and filter conditions dynamically
        $conditions = [];
        if (!empty($search)) {
            $conditions[] = "(property_type LIKE '%$search%' OR location LIKE '%$search%' OR description LIKE '%$search%')";
        }
        if (!empty($filter)) {
            $conditions[] = "property_type = '$filter'";
        }
        if (!empty($conditions)) {
            $query .= " WHERE " . implode(" AND ", $conditions);
        }

        $result = $this->conn->query($query);
        return $result;
    }

    // Destructor to close the database connection
    public function __destruct() {
        $this->conn->close();
    }
}

// Instantiate the DatabaseHandler class
$dbHandler = new DatabaseHandler();

// Fetch properties based on search and filter input
$search = isset($_GET['search']) ? $_GET['search'] : "";
$filter = isset($_GET['filter']) ? $_GET['filter'] : "";
$properties = $dbHandler->getProperties($search, $filter);
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="searching-style.css">
    <title>Housing Offers</title>
</head>
<body>
<div class = "cont">
<div class="navbar">
    <div class="icon">
        <h2 class="logo">Neighborly</h2>
    </div>

    <div class="menu">
        <ul>
            <li><a href="homepage.php">HOME</a></li>
            <li><a href="#">MY PROFILE</a></li>
            <li><a href="searching.php">HOUSING OFFERS</a></li>
            <li><a href="#">ABOUT</a></li>
        </ul>
    </div>

    <div class="logout">  
        <a href="#"> <button class="btn">LOGOUT</button></a>
    </div>
</div>
</div>


<h2 style="text-align: center; margin-bottom: 20px;">Properties Table</h2>

<!-- Search and Filter Form -->
<div class="search-container">
    <form method="GET" action="">
        <input type="text" name="search" placeholder="Search by type, location, or description" value="<?= htmlspecialchars($search) ?>">
        <select name="filter">
            <option value="">Filter by Property Type</option>
            <option value="Apartment" <?= $filter == "Apartment" ? "selected" : "" ?>>Apartment</option>
            <option value="Residential Lot" <?= $filter == "Residential Lot" ? "selected" : "" ?>>Residential Lot</option>
            <option value="Condo" <?= $filter == "Condo" ? "selected" : "" ?>>Condo</option>
            <option value="House and Lot" <?= $filter == "House and Lot" ? "selected" : "" ?>>House and Lot</option>
            <option value="Commercial" <?= $filter == "Commercial" ? "selected" : "" ?>>Commercial</option>
        </select>
        <button type="submit">Search</button>
    </form>
</div>

<!-- Properties Table -->
<table>
    <thead>
        <tr>
            <th>ID</th>
            <th>Property Type</th>
            <th>Price Range</th>
            <th>Location</th>
            <th>Area (sqm)</th>
            <th>Capacity</th>
            <th>Description</th>
            <th>Action</th>
        </tr>
    </thead>
    <tbody>

        <?php
        if ($properties->num_rows > 0) {
            // Output data of each row
            while ($row = $properties->fetch_assoc()) {
                echo "<tr>";
                echo "<td>" . $row['id'] . "</td>";
                echo "<td>" . $row['property_type'] . "</td>";
                echo "<td>" . $row['price_range'] . "</td>";
                echo "<td>" . $row['location'] . "</td>";
                echo "<td>" . $row['area'] . "</td>";
                echo "<td>" . $row['capacity'] . "</td>";
                echo "<td>" . $row['description'] . "</td>";
                echo "<td><button class='buy-button' onclick='buyProperty(" . $row['id'] . ")'>Buy</button></td>";
                echo "</tr>";
            }
        } else {
            echo "<tr><td colspan='8'>No properties found</td></tr>";
        }
        ?>
    </tbody>
</table>

<script>
    function buyProperty(propertyId) {
        alert("Property with ID " + propertyId + " has been selected for purchase!");
        // You can expand this function to redirect to a purchase page or send the property ID to the server.
    }
</script>

</body>
</html>
