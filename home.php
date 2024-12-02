<?php
session_start();
include('connect.php');

$result = $conn->query("SELECT * FROM properties WHERE id NOT IN (SELECT property_id FROM buyers WHERE status = 'approved')");
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0-alpha3/dist/js/bootstrap.bundle.min.js"></script>
    <link rel="stylesheet" href="https://cdn.datatables.net/1.11.3/css/jquery.dataTables.min.css">
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script src="https://cdn.datatables.net/1.11.3/js/jquery.dataTables.min.js"></script>
    <link rel="stylesheet" href="./css/main.css">
    <title>Home</title>
</head>
<body>

<div class="navbar">
    <img src="./img/pngwing.com.png" alt="logo photo" height="55">
    <a href="#Home">Home</a>
    <a href="#aboutus">About</a>
    <a href="logout.php">Log out</a>
    <a href="#">
        <?php
            if (isset($_SESSION['email'])) {
                $email = $_SESSION['email'];
                $query = mysqli_query($conn, "SELECT users.* FROM `users` WHERE users.email = '$email'");
                while ($row = mysqli_fetch_array($query)) {
                    echo $row['username'];
                }
            }
        ?>
    </a>
</div>

<section id="home">
    <div class="px-4 py-5 my-5 text-center">
        <h1 class="display-5 fw-bold text-body-emphasis">House Allocating System</h1>
        <div class="col-lg-6 mx-auto">
            <p class="lead mb-4">
                Discover your perfect property with our comprehensive listings of homes, apartments, and commercial spaces. 
                Let us help you find a place that fits your needs and budget.
            </p>
        </div>
    </div>

    <div id="carouselExample" class="carousel slide" data-bs-ride="carousel">
        <div class="carousel-indicators">
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="0" class="active" aria-current="true" aria-label="Slide 1"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="1" aria-label="Slide 2"></button>
            <button type="button" data-bs-target="#carouselExample" data-bs-slide-to="2" aria-label="Slide 3"></button>
        </div>
        <div class="carousel-inner">
            <div class="carousel-item active">
            <img src="./img/dream.jpg" class="d-block w-100" alt="Dream Home" style="object-fit: cover; height: 500px;">
            <div class="container">
                <div class="carousel-caption text-start">
                <h1>Your Dream Home Awaits</h1>
                <p>Explore a variety of properties tailored to fit your lifestyle and budget.</p>
                </div>
            </div>
            </div>
            <div class="carousel-item">
            <img src="./img/neighbor.jpg" class="d-block w-100" alt="Neighborhood" style="object-fit: cover; height: 500px;">
            <div class="container">
                <div class="carousel-caption">
                <h1>Find Your Perfect Neighborhood</h1>
                <p>Discover communities that match your lifestyle with our expert guidance.</p>
                </div>
            </div>
            </div>
            <div class="carousel-item">
            <img src="./img/buildings.jpeg" class="d-block w-100" alt="Investment Property" style="object-fit: cover; height: 500px;">
            <div class="container">
                <div class="carousel-caption text-end">
                <h1>Invest in Your Future</h1>
                <p>Secure a better tomorrow with properties offering great returns.</p>
                </div>
            </div>
            </div>
        </div>
        <button class="carousel-control-prev" type="button" data-bs-target="#carouselExample" data-bs-slide="prev">
            <span class="carousel-control-prev-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Previous</span>
        </button>
        <button class="carousel-control-next" type="button" data-bs-target="#carouselExample" data-bs-slide="next">
            <span class="carousel-control-next-icon" aria-hidden="true"></span>
            <span class="visually-hidden">Next</span>
        </button>
    </div>

    <div class="containers">
        <h1>Available Properties</h1>
        <div class="property-grid">
            <?php while ($row = $result->fetch_assoc()): ?>
                <div class="property-card">
                <div class="property-image" aria-label="Generic property image"></div>
                    <div class="property-details">
                        <div class="property-type"><?= $row['property_type'] ?></div>
                        <div class="property-location"><?= $row['location'] ?></div>
                        <div class="property-info">
                            <span>Area: <?= $row['area'] ?> sqm</span>
                            <span>Capacity: <?= $row['capacity'] ?></span>
                        </div>
                        <div class="property-info">
                            <span>Price Range: <?= $row['price_range'] ?></span>
                        </div>
                        <button class="buy-btn" data-id="<?= $row['id'] ?>" data-toggle="modal" data-target="#buyModal">Buy Now</button>
                    </div>
                </div>
            <?php endwhile; ?>
        </div>
    </div>

<div class="modal fade" id="buyModal" tabindex="-1" aria-hidden="true">
    <div class="modal-dialog modal-lg">
        <form action="buyer.php" method="POST" class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Buyer Information</h5>
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
                <button type="submit" name="submitBuyer" class="btn btn-success">Buy</button>
            </div>
        </form>
    </div>
</div>

</section>

<section id="aboutus">
<div class="container">
    <div class="row my-5">
        <div class="col-lg-4">
            <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect></svg>
            <h2 class="fw-normal">Heading</h2>
            <p>Some representative placeholder content for the three columns of text below the carousel. This is the first column.</p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
            <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect></svg>
            <h2 class="fw-normal">Heading</h2>
            <p>Another exciting bit of representative placeholder content. This time, we've moved on to the second column.</p>
        </div><!-- /.col-lg-4 -->
        <div class="col-lg-4">
            <svg class="bd-placeholder-img rounded-circle" width="140" height="140" xmlns="http://www.w3.org/2000/svg" role="img" aria-label="Placeholder" preserveAspectRatio="xMidYMid slice" focusable="false"><title>Placeholder</title><rect width="100%" height="100%" fill="var(--bs-secondary-color)"></rect></svg>
            <h2 class="fw-normal">Heading</h2>
            <p>And lastly this, the third column of representative placeholder content.</p>
        </div><!-- /.col-lg-4 -->
    </div>
</div>
</section>

<section id="footer">
<div class="container">
  <footer class="py-3 my-4">
    <ul class="nav justify-content-center border-bottom pb-3 mb-3">
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Home</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Features</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">Pricing</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">FAQs</a></li>
      <li class="nav-item"><a href="#" class="nav-link px-2 text-body-secondary">About</a></li>
    </ul>
    <p class="text-center text-body-secondary">© 2024 Company, Inc</p>
  </footer>
</div>
</section>

<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
    document.addEventListener('DOMContentLoaded', function () {
        $('#propertiesTable').DataTable();

        document.querySelectorAll('.buy-btn').forEach(function(button) {
            button.addEventListener('click', function () {
                const propertyId = this.getAttribute('data-id');
                document.getElementById('propertyId').value = propertyId;

                var buyModal = new bootstrap.Modal(document.getElementById('buyModal'));
                buyModal.show();
            });
        });
    });
</script>
</body>
</html>

