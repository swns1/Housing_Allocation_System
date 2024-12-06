<?php
session_start();
include('connect.php');

$userEmail = $_SESSION['email'];
$notifications = $conn->query("SELECT * FROM notifications WHERE user_email = '$userEmail' ORDER BY date_created DESC");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Notifications - Neighborly</title>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="./css/notifications.css">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <nav class="navbar">
        <a href="homepage.php" class="logo">Neighborly</a>
        <div class="menu">
            <ul>
                <li><a href="homepage.php">HOME</a></li>
                <li><a href="profile.php">MY PROFILE</a></li>
                <li><a href="searching.php">HOUSING OFFERS</a></li>
                <li><a href="#" class="active">NOTIFICATIONS</a></li>
                <li><a href="homepage.php#about">ABOUT</a></li>
            </ul>
        </div>
        <a href="logout.php" class="btn">LOGOUT</a>
    </nav>

    <div class="container">
        <h2>My Notifications</h2>
        <table id="notificationsTable" class="display">
            <thead>
                <tr>
                    <th>Message</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php while($notif = mysqli_fetch_array($notifications)): ?>
                    <tr>
                        <td><?= htmlspecialchars($notif['message']) ?></td>
                        <td><?= $notif['date_created'] ?></td>
                        <td>
                            <button onclick="deleteNotification(<?= $notif['id'] ?>)" class="delete-btn">Delete</button>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script>
        $(document).ready(function() {
            $('#notificationsTable').DataTable({
                order: [[1, 'desc']]
            });
        });

        function deleteNotification(id) {
            Swal.fire({
                title: 'Delete Notification?',
                text: "This action cannot be undone",
                icon: 'warning',
                showCancelButton: true,
                confirmButtonColor: '#d33',
                cancelButtonColor: '#3085d6',
                confirmButtonText: 'Delete'
            }).then((result) => {
                if (result.isConfirmed) {
                    fetch('delete_notification.php', {
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
            });
        }
    </script>
</body>
</html>
