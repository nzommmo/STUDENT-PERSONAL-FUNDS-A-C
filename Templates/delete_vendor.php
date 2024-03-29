<?php
require_once 'config.php'; // Include the database configuration file

// Check if the form is submitted
if (isset($_POST['delete'])) {
    $vendorId = $_POST['vendor_id'];

    // Delete the vendor from the Vendors table
    $sql_delete_vendor = "DELETE FROM Vendors WHERE VendorID='$vendorId'";
    if ($conn->query($sql_delete_vendor) === TRUE) {
        echo "Vendor deleted successfully";
    } else {
        echo "Error deleting vendor: " . $conn->error;
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
    <title>Delete Vendor</title>
</head>
<body>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-6">
            <!-- Vendor Delete Form -->
            <div class="form-container">
                <h2>Delete Vendor</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="vendor_id" value="<?php echo $vendorId; ?>">
                    <p>Are you sure you want to delete the vendor "<?php echo $vendorName; ?>"?</p>
                    <button type="submit" class="btn btn-danger" name="delete">Delete Vendor</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
