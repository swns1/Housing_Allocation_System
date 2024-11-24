<?php
session_start();
include('connect.php');

class Users {
    public $email;
    public $username;
    public $password;
    public $conn;
}
  class Properties {
      public $conn;
      public $id;
    public $propertyType;
    public $priceRange;
    public $location;
    public $area;
    public $capacity;
    public $description;

    public function __construct($conn) {
        $this->conn = $conn;
    }

    public function setProperties($data) {
        $this->id = $data['id'] ?? null;
        $this->propertyType = $data['property_type'] ?? $data['propertyType'];
        $this->priceRange = $data['price_range'] ?? $data['priceRange'];
        $this->location = $data['location'];
        $this->area = $data['area'];
        $this->capacity = $data['capacity'];
        $this->description = $data['description'];
    }

    public function addProperty() {
        $query = "INSERT INTO properties (property_type, price_range, location, area, capacity, description) 
                VALUES ('$this->propertyType', '$this->priceRange', '$this->location', '$this->area', '$this->capacity', '$this->description')";
        return mysqli_query($this->conn, $query);
    }

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

    public function deleteProperty($id) {
        return mysqli_query($this->conn, "DELETE FROM properties WHERE id=$id");
    }

    public function getPropertyById($id) {
        return mysqli_query($this->conn, "SELECT * FROM properties WHERE id = $id");
    }

    public function getAllProperties() {
        return mysqli_query($this->conn, "SELECT * FROM properties");
    }
}

$propertyManager = new Properties($conn);

if(isset($_GET['id'])) {
    $property = $propertyManager->getPropertyById($_GET['id']);
    echo json_encode(mysqli_fetch_assoc($property));
    exit();
}

if(isset($_POST['add_property'])) {
    $propertyManager->addProperty();
    header("Location: adminhome.php");
    exit();
}

if(isset($_POST['edit_property'])) {
    $propertyManager->editProperty();
    header("Location: adminhome.php");
    exit();
}

if(isset($_POST['delete_property'])) {
    $propertyManager->deleteProperty($_POST['property_id']);
    header("Location: adminhome.php");
    exit();
}?>
<!DOCTYPE html>
<html lang="en">
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

    <!-- Property List -->
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
        $(document).ready(function() {
            $('#propertyTable').DataTable();
        });

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
        <?php if(isset($_POST['add_property'])) { ?>
            Swal.fire({
                title: 'Success!',
                text: 'Property added successfully',
                icon: 'success'
            });
        <?php } ?>

        <?php if(isset($_POST['edit_property'])) { ?>
            Swal.fire({
                title: 'Success!',
                text: 'Property updated successfully',
                icon: 'success'
            });
        <?php } ?>
    </script>
</body>
</html>

<style>
    #addPropertyForm {
    display: flex;
    flex-direction: column;
    max-width: 500px;
    gap: 10px;
    }

    #addPropertyForm select,
    #addPropertyForm input,
    #addPropertyForm textarea {
        width: 100%;
        padding: 8px;
    }

    .swal2-input {
        margin: 10px auto !important;
        width: 80% !important;
    }
    
    textarea.swal2-input {
        height: 100px !important;
    }
</style>


