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
        $query = "SELECT * FROM properties WHERE id NOT IN (SELECT property_id FROM buyers WHERE status = 'approved')";
    
        $conditions = [];
    
        if (!empty($search)) {
            $conditions[] = "(property_type LIKE '%$search%' OR location LIKE '%$search%' OR description LIKE '%$search%')";
        }
    
        if (!empty($filter)) {
            $conditions[] = "property_type = '$filter'";
        }
    
        if (!empty($conditions)) {
            $query .= " AND " . implode(" AND ", $conditions);
        }

        $result = $this->conn->query($query);
        return $result;
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
    <link rel="stylesheet" href="./css/searching-style.css">
    <title>Housing Offers</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
</head>
<body>
    <nav class="custom-navbar">
        <h1 class="custom-logo">Neighborly</h1>
        <div class="custom-menu">
            <ul>
                <li><a href="homepage.php">HOME</a></li>
                <li><a href="profile.php">MY PROFILE</a></li>
                <li><a href="searching.php">HOUSING OFFERS</a></li>
                <li><a href="notifications.php">NOTIFICATIONS</a></li>
                <li><a href="#about">ABOUT</a></li>
            </ul>
        </div>
        <a href="logout.php" class="custom-btn" style="text-decoration: none;">LOGOUT</a>
    </nav>

    <h2 style="text-align: center; margin: 2rem 0;">Search Housing Options</h2>

    <div class="custom-search-container">
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
            <button type="submit" class="custom-btn">Search</button>
        </form>
    </div>

    <div class="custom-properties-grid">
<?php
if ($properties->num_rows > 0) {
    while ($row = $properties->fetch_assoc()) {
        $photoPath = !empty($row['photos']) 
            ? 'img/' . htmlspecialchars($row['photos']) 
            : 'img/house' . htmlspecialchars($row['id'] % 10 + 1) . '.jpg';

        echo '<div class="custom-property-card">';
        echo '<div class="custom-property-image-container">';
        echo '<img src="' . $photoPath . '" alt="Property" class="custom-property-image" onerror="this.src=\'img/house.jpg\'">';
        echo '</div>';
        echo '<div class="custom-property-details">';
        echo '<div class="custom-property-type">' . htmlspecialchars($row['property_type']) . '</div>';
        echo '<div class="custom-property-location">' . htmlspecialchars($row['location']) . '</div>';
        echo '<div class="custom-property-specs">';
        echo '<span>Area: ' . htmlspecialchars($row['area']) . ' sqm</span>';
        echo '<span>Capacity: ' . htmlspecialchars($row['capacity']) . '</span>';
        echo '</div>';
        echo '<div class="custom-property-price">₱' . htmlspecialchars($row['price_range']) . '</div>';
        echo '<button class="custom-buy-now buy-btn" data-id="' . $row['id'] . '" data-toggle="modal" data-target="#buyModal">Buy Now</button>';
        echo '</div>';
        echo '</div>';
    }
} else {
    echo '<p class="text-center">No properties found</p>';
}
?>

    <!-- Modal Section -->
    <div class="modal fade" id="buyModal" tabindex="-1" aria-hidden="true">
        <div class="modal-dialog modal-lg">
            <form action="buyer.php" method="POST" class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title">Buyer Information</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <input type="hidden" name="property_id" id="propertyId">
                    <div class="form-group">
                        <label for="fullname">Full Name</label>
                        <input type="text" name="fullname" id="fullname" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="email" name="email" id="email" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="phone">Phone</label>
                        <input type="text" name="phone" id="phone" class="form-control" required>
                    </div>
                    <div class="form-group">
                        <label for="message">Message</label>
                        <textarea name="message" id="message" class="form-control" rows="4"></textarea>
                    </div>
                </div>
                <div class="modal-footer justify-content-between">
                    <button type="submit" name="submitBuyer" class="btn btn-primary">Buy</button>
                </div>
            </form>
        </div>
    </div>

    <script>
        document.addEventListener('DOMContentLoaded', function () {
            const buyButtons = document.querySelectorAll('.buy-btn');
            
            buyButtons.forEach(function(button) {
                button.addEventListener('click', function () {
                    const propertyId = this.getAttribute('data-id');
                    document.getElementById('propertyId').value = propertyId;
                    
                    const modal = new bootstrap.Modal(document.getElementById('buyModal'));
                    modal.show();
                });
            });
        });
    </script>
</body>
</html>
