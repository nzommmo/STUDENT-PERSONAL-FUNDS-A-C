<?php
require_once 'config.php'; // Include the database configuration file

// Check if the form is submitted
if (isset($_POST['update'])) {
    $vendorId = $_POST['vendor_id'];
    $newVendorName = $_POST['new_vendor_name'];
    $newVendorLocation = $_POST['new_vendor_location'];

    // Update the vendor in the Vendors table
    $sql_update_vendor = "UPDATE Vendors SET VendorName='$newVendorName', VendorLocation='$newVendorLocation' WHERE VendorID='$vendorId'";
    if ($conn->query($sql_update_vendor) === TRUE) {
        echo "Vendor updated successfully";
    } else {
        echo "Error updating vendor: " . $conn->error;
    }
}

// Fetch vendor details for display
if (isset($_GET['id'])) {
    $vendorId = $_GET['id'];
    $sql_select_vendor = "SELECT * FROM Vendors WHERE VendorID='$vendorId'";
    $result = $conn->query($sql_select_vendor);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $vendorName = $row['VendorName'];
        $vendorLocation = $row['VendorLocation'];
    } else {
        echo "Vendor not found";
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Update Vendor</title>
</head>
<body>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-6">
            <!-- Vendor Update Form -->
            <div class="form-container">
                <h2>Update Vendor</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="vendor_id" value="<?php echo $vendorId; ?>">
                    <div class="form-group">
                        <label for="new_vendor_name">New Vendor Name</label>
                        <input type="text" class="form-control" id="new_vendor_name" name="new_vendor_name" value="<?php echo $vendorName; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="new_vendor_location">New Vendor Location</label>
                        <input type="text" class="form-control" id="new_vendor_location" name="new_vendor_location" value="<?php echo $vendorLocation; ?>" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update">Update Vendor</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
