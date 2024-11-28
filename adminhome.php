<?php
// === INITIALIZATION===
session_start();
include('connect.php');

// === CLASSES===
// User Management Class
class Users {
    public $email;
    public $username;
    public $password;
    public $conn;
}

// Property Management Class
class Properties {
    public $conn;
    public $id;
    public $propertyType;
    public $priceRange;
    public $location;
    public $area;
    public $capacity;
    public $description;

    // Constructor for database connection
    public function __construct($conn) {
        $this->conn = $conn;
    }

    // === DATABASE OPERATIONS ===
    // Data setter method
    public function setProperties($data) {
        $this->propertyType = mysqli_real_escape_string($this->conn, $data['property_type']);
        $this->priceRange = mysqli_real_escape_string($this->conn, $data['price_range']);
        $this->location = mysqli_real_escape_string($this->conn, $data['location']);
        $this->area = mysqli_real_escape_string($this->conn, $data['area']);
        $this->capacity = mysqli_real_escape_string($this->conn, $data['capacity']);
        $this->description = mysqli_real_escape_string($this->conn, $data['description']);
    }

    // Create operation
    public function addProperty() {
        $query = "INSERT INTO properties (property_type, price_range, location, area, capacity, description) 
                VALUES ('$this->propertyType', '$this->priceRange', '$this->location', '$this->area', '$this->capacity', '$this->description')";
        return mysqli_query($this->conn, $query);
    }

    // Edit operation
    public function editProperty() {
        $query = "UPDATE properties SET 
                property_type='$this->propertyType', 
                price_range='$this->priceRange', 
                location='$this->location',
                area='$this->area', 
                capacity='$this->capacity', 
                description='$this->description'
                WHERE id=$this->id";
        return mysqli_query($this->conn, $query);
    }

    // Delete operation
    public function deleteProperty($id) {
        return mysqli_query($this->conn, "DELETE FROM properties WHERE id=$id");
    }

    // Read operations
    public function getPropertyById($id) {
        return mysqli_query($this->conn, "SELECT * FROM properties WHERE id = $id");
    }
    public function getAllProperties() {
        return mysqli_query($this->conn, "SELECT * FROM properties");
    }
}

// === REQUEST HANDLERS ===
// Initialize property manager
$propertyManager = new Properties($conn);

// GET request handler for property details
if(isset($_GET['id'])) {
    $property = $propertyManager->getPropertyById($_GET['id']);
    echo json_encode(mysqli_fetch_assoc($property));
    exit();
}

// POST request handlers
if(isset($_POST['add_property'])) {
    $propertyManager->setProperties($_POST);
    $propertyManager->addProperty();
    $_SESSION['success_message'] = "Property added successfully";
    header("Location: adminhome.php");
    exit();
}

if(isset($_POST['edit_property'])) {
    $propertyManager->setProperties($_POST);
    $propertyManager->id = $_POST['property_id'];
    $propertyManager->editProperty();
    $_SESSION['success_message'] = "Property updated successfully";
    header("Location: adminhome.php");
    exit();
}

if(isset($_POST['delete_property'])) {
    $propertyManager->deleteProperty($_POST['property_id']);
    header("Location: adminhome.php");
    exit();
}

// === HTML STRUCTURE ===
?>
<!DOCTYPE html>
<html lang="en">
    <!-- === HEADER SECTION === -->
    <head>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width, initial-scale=1.0">
        <title>Admin Dashboard</title>
        <!-- DataTables CSS -->
        <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
        <!-- jQuery -->
        <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
        <!-- DataTables JS -->
        <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
        <!-- SweetAlert2 CSS -->
        <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
        <!-- SweetAlert2 JS -->
        <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    </head>

    <body>
        <h2>Admin Dashboard</h2>
        
        <!-- === FORM SECTION === -->
        <!-- Add Property Form -->
        <form method="post" action="adminhome.php" id="addPropertyForm">
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

        <!-- === DATA DISPLAY SECTION === -->
        <!-- Property List Table -->
        <div class="property-list">
            <h3>Manage Properties</h3>
            <table id="propertyTable" class="display">
                <thead>
                    <tr>
                        <th>Property Type</th>
                        <th>Price Range</th>
                        <th>Location</th>
                        <th>Area (sqm)</th>
                        <th>Capacity</th>
                        <th>Description</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php
                    $properties = mysqli_query($conn, "SELECT * FROM properties");
                    while($property = mysqli_fetch_array($properties)) {
                        echo "<tr>";
                        echo "<td>{$property['property_type']}</td>";
                        echo "<td>{$property['price_range']}</td>";
                        echo "<td>{$property['location']}</td>";
                        echo "<td>{$property['area']}</td>";
                        echo "<td>{$property['capacity']}</td>";
                        echo "<td>{$property['description']}</td>";
                        echo "<td>
                                <button onclick='editProperty({$property['id']})'>Edit</button>
                                <button onclick='deleteProperty({$property['id']})'>Delete</button>
                              </td>";
                        echo "</tr>";
                    }
                    ?>
                </tbody>
            </table>
        </div>

        <script>
            // DataTable initialization
            $(document).ready(function() {
                $('#propertyTable').DataTable();
            });

            // Property deletion handler
            function deleteProperty(id) {
                Swal.fire({
                    title: 'Are you sure?',
                    text: "You won't be able to revert this!",
                    icon: 'warning',
                    showCancelButton: true,
                    confirmButtonColor: '#3085d6',
                    cancelButtonColor: '#d33',
                    confirmButtonText: 'Yes, delete it!'
                }).then((result) => {
                    if (result.isConfirmed) {
                        let form = document.createElement('form');
                        form.method = 'POST';
                        form.action = 'adminhome.php';
                  
                        let input = document.createElement('input');
                        input.type = 'hidden';
                        input.name = 'property_id';
                        input.value = id;
                  
                        let button = document.createElement('input');
                        button.type = 'hidden';
                        button.name = 'delete_property';
                  
                        form.appendChild(input);
                        form.appendChild(button);
                        document.body.appendChild(form);
                        form.submit();
                    }
                });
            }

            // Property edit handler
            function editProperty(id) {
                fetch(`adminhome.php?id=${id}`)
                    .then(response => response.json())
                    .then(property => {
                        Swal.fire({
                            title: 'Edit Property',
                            html: `
                                <select id="property_type" class="swal2-input">
                                    <option value="Apartment" ${property.property_type === 'Apartment' ? 'selected' : ''}>Apartment</option>
                                    <option value="Residential Lot" ${property.property_type === 'Residential Lot' ? 'selected' : ''}>Residential Lot</option>
                                    <option value="Condo" ${property.property_type === 'Condo' ? 'selected' : ''}>Condo</option>
                                    <option value="House and Lot" ${property.property_type === 'House and Lot' ? 'selected' : ''}>House and Lot</option>
                                    <option value="Commercial" ${property.property_type === 'Commercial' ? 'selected' : ''}>Commercial</option>
                                </select>
                                <input type="text" id="price_range" class="swal2-input" placeholder="Price Range" value="${property.price_range}">
                                <input type="text" id="location" class="swal2-input" placeholder="Location" value="${property.location}">
                                <input type="number" id="area" class="swal2-input" placeholder="Area (sqm)" value="${property.area}">
                                <input type="text" id="capacity" class="swal2-input" placeholder="Capacity" value="${property.capacity}">
                                <textarea id="description" class="swal2-input" placeholder="Description">${property.description}</textarea>
                            `,
                            showCancelButton: true,
                            confirmButtonText: 'Update',
                            preConfirm: () => {
                                const formData = new FormData();
                                formData.append('property_id', id);
                                formData.append('property_type', document.getElementById('property_type').value);
                                formData.append('price_range', document.getElementById('price_range').value);
                                formData.append('location', document.getElementById('location').value);
                                formData.append('area', document.getElementById('area').value);
                                formData.append('capacity', document.getElementById('capacity').value);
                                formData.append('description', document.getElementById('description').value);
                                formData.append('edit_property', true);

                                return fetch('adminhome.php', {
                                    method: 'POST',
                                    body: formData
                                })
                                .then(response => {
                                    if (!response.ok) {
                                        throw new Error(response.statusText);
                                    }
                                    return response;
                                })
                                .catch(error => {
                                    Swal.showValidationMessage(`Request failed: ${error}`);
                                });
                            }
                        });
                    });
            }        
      
            <?php 
            if(isset($_SESSION['success_message'])) {
                echo "Swal.fire({
                    title: 'Success!',
                    text: '{$_SESSION['success_message']}',
                    icon: 'success'
                });";
                unset($_SESSION['success_message']);
            }
            ?>
        </script>

        <!-- === STYLING SECTION === -->
        <style>
    /* Main Layout */
    body {
        font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        max-width: 1200px;
        margin: 0 auto;
        padding: 20px;
        background-color: #f5f5f5;
    }

    h2 {
        color: #2c3e50;
        text-align: center;
        margin-bottom: 30px;
    }

    /* Form Styling */
    #addPropertyForm {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
        margin-bottom: 30px;
    }

    #addPropertyForm input,
    #addPropertyForm select,
    #addPropertyForm textarea {
        width: 100%;
        padding: 10px;
        margin: 8px 0;
        border: 1px solid #ddd;
        border-radius: 4px;
        box-sizing: border-box;
    }

    #addPropertyForm button {
        background-color: #3498db;
        color: white;
        padding: 12px 20px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
        width: 100%;
        font-size: 16px;
    }

    #addPropertyForm button:hover {
        background-color: #2980b9;
    }

    /* Table Styling */
    .property-list {
        background: white;
        padding: 20px;
        border-radius: 8px;
        box-shadow: 0 2px 4px rgba(0,0,0,0.1);
    }

    #propertyTable {
        width: 100%;
        border-collapse: collapse;
        margin-top: 20px;
    }

    #propertyTable th {
        background-color: #3498db;
        color: white;
        padding: 12px;
    }

    #propertyTable td {
        padding: 10px;
        border-bottom: 1px solid #ddd;
    }

    /* Button Styling */
    .property-list button {
        padding: 8px 15px;
        margin: 0 5px;
        border: none;
        border-radius: 4px;
        cursor: pointer;
    }

    .property-list button:nth-child(1) {
        background-color: #2ecc71;
        color: white;
    }

    .property-list button:nth-child(2) {
        background-color: #e74c3c;
        color: white;
    }

    .property-list button:hover {
        opacity: 0.9;
    }

    /* SweetAlert Customization */
    .swal2-popup {
        font-size: 14px;
    }

    .swal2-input, .swal2-textarea {
        margin: 10px auto !important;
        width: 90% !important;
    }
</style>
    </body>
</html>
