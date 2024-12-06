<?php
session_start();
include('connect.php');

$userInfo = null;
if (isset($_SESSION['email'])) {
    $email = $_SESSION['email'];
    $userQuery = $conn->query("SELECT username, email FROM `users` WHERE email = '$email'");
    if ($userQuery && $userInfo = $userQuery->fetch_assoc()) {
        $userInfo['username'] = htmlspecialchars($userInfo['username']);
        $userInfo['email'] = htmlspecialchars($userInfo['email']);
    } else {
        $userInfo = null;
    }
}

$notifications = [];
if ($userInfo) {
    $notifQuery = $conn->query("SELECT * FROM notifications WHERE user_email = '{$userInfo['email']}' ORDER BY date_created DESC");
    while ($notifQuery && $row = $notifQuery->fetch_assoc()) {
        $notifications[] = $row;
    }
}


$purchasedProperties = [];
if ($userInfo) {
    $userId = $conn->query("SELECT id FROM `users` WHERE email = '$email'")->fetch_assoc()['id'];
    $propertyQuery = $conn->query("
    SELECT p.property_type, p.price_range, p.location, p.area, p.capacity, p.description, b.status
    FROM properties p
    JOIN buyers b ON p.id = b.property_id
    WHERE b.user_id = '$userId'");
    while ($propertyQuery && $row = $propertyQuery->fetch_assoc()) {
        $purchasedProperties[] = array_map('htmlspecialchars', $row);
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="./css/profile.css">
    <title>My Profile - Neighborly: Housing Allocation System</title>
</head>
<body>
    <!-- Navbar -->
    <nav class="navbar">
        <a href="homepage.php" class="logo">Neighborly</a>
        <div class="menu">
            <ul>
                <li><a href="homepage.php">HOME</a></li>
                <li><a href="#" class="active">MY PROFILE</a></li>
                <li><a href="searching.php">HOUSING OFFERS</a></li>
                <li><a href="notifications.php">NOTIFICATIONS</a></li>
                <li><a href="homepage.php#about">ABOUT</a></li>
            </ul>
        </div>
        <a href="logout.php" class="btn">LOGOUT</a>
    </nav>
      <section class="profile">
          <div class="profile-content">
              <h1>My Profile</h1>
              <div class="profile-info">
                  <div class="profile-image">
                      <img src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAAAEAAAABCAQAAAC1HAwCAAAAC0lEQVR42mN88B8AAsUB4ZtvXtIAAAAASUVORK5CYII=" alt="Profile Picture">
                  </div>
                  <div class="profile-details">
                      <h2>Personal Information</h2>
                      <?php if ($userInfo): ?>
                          <div class="info-group">
                              <label>Username:</label>
                              <p><?= $userInfo['username'] ?></p>
                          </div>
                          <div class="info-group">
                              <label>Email:</label>
                              <p><?= $userInfo['email'] ?></p>
                          </div>
                      <?php else: ?>
                          <p>User information not found. Please log in.</p>
                      <?php endif; ?>
                  </div>
              </div>

              <div class="property-section">
                  <h2>Purchased Properties</h2>
                  <?php if (!empty($purchasedProperties)): ?>
                      <?php foreach ($purchasedProperties as $property): ?>
                          <div class="property">
                              <p><strong>Type:</strong> <?= $property['property_type'] ?></p>
                              <p><strong>Price Range:</strong> <?= $property['price_range'] ?></p>
                              <p><strong>Location:</strong> <?= $property['location'] ?></p>
                              <p><strong>Area:</strong> <?= $property['area'] ?> sq ft</p>
                              <p><strong>Capacity:</strong> <?= $property['capacity'] ?></p>
                              <p><strong>Description:</strong> <?= $property['description'] ?></p>
                              <p><strong>Status:</strong> 
                                  <?php if ($property['status'] == 'pending'): ?>
                                      <span style="color: orange;">Pending</span>
                                  <?php elseif ($property['status'] == 'approved'): ?>
                                      <span style="color: green;">Approved</span>
                                  <?php elseif ($property['status'] == 'rejected'): ?>
                                      <span style="color: red;">Rejected</span>
                                  <?php endif; ?>
                              </p>
                          </div>
                      <?php endforeach; ?>
                  <?php else: ?>
                      <p>No purchased properties found.</p>
                  <?php endif; ?>
              </div>
          </div>
      </section>
    <footer class="footer">
        <div class="footer-bottom">
            <p>&copy; 2024 Neighborly. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>

<script>
function deleteNotification(id) {
    if (confirm('Delete this notification?')) {
        fetch('deleteNotification.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded',
            },
            body: 'id=' + id
        })
        .then(response => response.json())
        .then(data => {
            if (data.success) {
                location.reload();
            }
        });
    }
}
</script>