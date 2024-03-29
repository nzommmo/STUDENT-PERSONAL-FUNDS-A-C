<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Vendors</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
    <div class="row">
        <?php
        // Include database connection
        include_once "config.php";

        // Fetch vendors from database
        $sql = "SELECT * FROM Vendors";
        $result = $conn->query($sql);

        // Check if there are vendors
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Vendor data
                $vendorName = $row['VendorName'];
                $vendorLocation = $row['VendorLocation'];
        ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $vendorName; ?></h5>
                    <p class="card-text"><?php echo $vendorLocation; ?></p>
                    <a href="#" class="btn btn-primary">View Products</a>
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<div class='col'>No vendors found.</div>";
        }

        // Close database connection
        $conn->close();
        ?>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


</body>
</html>
