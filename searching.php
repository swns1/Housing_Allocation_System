<?php  

class DatabaseHandler {
    private $host = "localhost";
    private $username = "root";
    private $password = "";
    private $database = "php_project";
    private $conn;

    public function __construct() {
        $this->conn = new mysqli($this->host, $this->username, $this->password, $this->database);


        if ($this->conn->connect_error) {
            die("Connection failed: " . $this->conn->connect_error);
        }
    }

    public function getProperties($search = "", $filter = "") {
        $query = "SELECT id, property_type, price_range, location, area, capacity, description, photos FROM properties";

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

    public function __destruct() {
        $this->conn->close();
    }
}

$dbHandler = new DatabaseHandler();

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
    <nav class="navbar">
        <h1 class="logo">Neighborly</h1>
        <div class="menu">
            <ul>
                <li><a href="homepage.php">HOME</a></li>
                <li><a href="#">MY PROFILE</a></li>
                <li><a href="searching.php">HOUSING OFFERS</a></li>
                <li><a href="#about">ABOUT</a></li>
            </ul>
        </div>
        <button class="btn">LOGOUT</button>
    </nav>

    <h2 style="text-align: center; margin: 2rem 0;">Search Housing Options</h2>

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
            <button type="submit" class="btn">Search</button>
        </form>
    </div>

    <div class="properties-grid">
    <?php
    if ($properties->num_rows > 0) {
        while ($row = $properties->fetch_assoc()) {
           
            $photoPath = !empty($row['photos']) ? 'php_pics/' . htmlspecialchars($row['photos']) : '/placeholder.svg';
            
            echo '<div class="property-card">';
            echo '<img src="' . $photoPath . '" alt="Property" class="property-image">';
            echo '<div class="property-details">';
            echo '<div class="property-type">' . htmlspecialchars($row['property_type']) . '</div>';
            echo '<div class="property-location">' . htmlspecialchars($row['location']) . '</div>';
            echo '<div class="property-specs">';
            echo '<span>Area: ' . htmlspecialchars($row['area']) . ' sqm</span>';
            echo '<span>Capacity: ' . htmlspecialchars($row['capacity']) . '</span>';
            echo '</div>';
            echo '<div class="property-price">₱' . htmlspecialchars($row['price_range']) . '</div>';
            echo '<button class="buy-now" onclick="buyProperty(' . $row['id'] . ')">Buy Now</button>';
            echo '</div>';
            echo '</div>';
        }
    } else {
        echo '<p style="text-align: center; grid-column: 1 / -1;">No properties found</p>';
    }
    ?>
</div>

    <script>
        function buyProperty(propertyId) {
            alert("Property with ID " + propertyId + " has been selected for purchase!");
        }
    </script>
</body>
</html>
