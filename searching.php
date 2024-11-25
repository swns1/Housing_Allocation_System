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
        $query = "SELECT id, property_type, price_range, location, area, capacity, description,photos FROM properties";

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
    <title>Housing Offers</title>
    <style>
        * {
            margin: 0;
            padding: 0;
            box-sizing: border-box;
            font-family: Arial, sans-serif;
        }

        .navbar {
            background-color: white;
            padding: 1rem 2rem;
            display: flex;
            justify-content: space-between;
            align-items: center;
            box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        }

        .logo {
            color: #4F46E5;
            font-size: 1.5rem;
            font-weight: bold;
        }

        .menu ul {
            display: flex;
            list-style: none;
            gap: 8rem;
        }

        .menu a {
            text-decoration: none;
            color: #374151;
        }

        .btn {
            background-color: #4F46E5;
            color: white;
            padding: 0.5rem 1rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
        }

        .search-container {
            max-width: 800px;
            margin: 2rem auto;
            padding: 0 1rem;
        }

        .search-container form {
            display: flex;
            gap: 1rem;
        }

        .search-container input,
        .search-container select {
            padding: 0.5rem;
            border: 1px solid #D1D5DB;
            border-radius: 0.375rem;
        }

        .search-container input {
            flex: 1;
        }

        .properties-grid {
            display: grid;
            grid-template-columns: repeat(auto-fill, minmax(300px, 1fr));
            gap: 2rem;
            padding: 2rem;
            max-width: 1200px;
            margin: 0 auto;
        }

        .property-card {
            border-radius: 0.5rem;
            overflow: hidden;
            box-shadow: 0 4px 6px rgba(0,0,0,0.1);
            background: white;
        }

        .property-image {
            width: 100%;
            height: 200px;
            object-fit: cover;
        }

        .property-details {
            padding: 1rem;
        }

        .property-type {
            color: #6B7280;
            font-size: 0.875rem;
            margin-bottom: 0.5rem;
        }

        .property-location {
            font-weight: bold;
            font-size: 1.125rem;
            margin-bottom: 1rem;
        }

        .property-specs {
            display: flex;
            justify-content: space-between;
            margin-bottom: 1rem;
            color: #6B7280;
            font-size: 0.875rem;
        }

        .property-price {
            font-weight: bold;
            margin-bottom: 1rem;
        }

        .buy-now {
            width: 100%;
            background-color: #10B981;
            color: white;
            padding: 0.75rem;
            border: none;
            border-radius: 0.375rem;
            cursor: pointer;
            font-weight: bold;
        }

        .buy-now:hover {
            background-color: #059669;
        }
    </style>
</head>
<body>
    <nav class="navbar">
        <h1 class="logo">Neighborly</h1>
        <div class="menu">
            <ul>
                <li><a href="homepage.php">HOME</a></li>
                <li><a href="#">MY PROFILE</a></li>
                <li><a href="searching.php">HOUSING OFFERS</a></li>
                <li><a href="#">ABOUT</a></li>
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
            // Properly handle the photo path
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