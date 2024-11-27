<?php
session_start();
include('connect.php');

// Fetch pending purchases
$result = $conn->query("SELECT buyers.*, properties.property_type, properties.location FROM buyers JOIN properties ON buyers.property_id = properties.id WHERE buyers.status = 'pending'");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Panel</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
</head>
<body>
    <div class="container mt-5">
        <h1>Admin Panel - Pending Purchases</h1>
        <table class="table">
            <thead>
                <tr>
                    <th>Buyer Name</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Property Type</th>
                    <th>Location</th>
                    <th>Action</th>
                </tr>
            </thead>
            <tbody>
                <?php while ($row = $result->fetch_assoc()): ?>
                    <tr>
                        <td><?= htmlspecialchars($row['fullname']) ?></td>
                        <td><?= htmlspecialchars($row['email']) ?></td>
                        <td><?= htmlspecialchars($row['phone']) ?></td>
                        <td><?= htmlspecialchars($row['property_type']) ?></td>
                        <td><?= htmlspecialchars($row['location']) ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="buyer_id" value="<?= $row['id'] ?>">
                                <button type="submit" name="approve" class="btn btn-success">Approve</button>
                            </form>
                        </td>
                    </tr>
                <?php endwhile; ?>
            </tbody>
        </table>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        <?php if (isset($success_message)): ?>
        Swal.fire({
            title: 'Success!',
            text: '<?php echo $success_message; ?>',
            icon: 'success'
        }).then(() => {
            location.reload();
        });
        <?php endif; ?>
    </script>
</body>
</html>

