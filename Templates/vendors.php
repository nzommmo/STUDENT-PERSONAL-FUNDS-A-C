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
        $vendorID = $row['VendorID'];
        $vendorName = $row['VendorName'];
        $vendorLocation = $row['VendorLocation'];
?>
        <!-- Vendor Card -->
        <div class="card mb-3">
            <div class="card-body">
                <h5 class="card-title"><?php echo $vendorName; ?></h5>
                <p class="card-text"><?php echo $vendorLocation; ?></p>
                <a href="#" class="btn btn-primary">View Products</a>
            </div>
        </div>
<?php
    }
} else {
    echo "No vendors found.";
}

// Close database connection
$conn->close();
?>
