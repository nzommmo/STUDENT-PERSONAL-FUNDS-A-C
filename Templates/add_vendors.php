<?php
require_once 'config.php'; // Include the database configuration file

// Check if the form is submitted
if (isset($_POST['register'])) {
    $vendorName = $_POST['vendorname'];
    $vendorLocation = $_POST['vendorlocation'];

    // Insert the vendor into the Vendors table
    $sql_vendor = "INSERT INTO Vendors (VendorName, VendorLocation) VALUES ('$vendorName', '$vendorLocation')";
    if ($conn->query($sql_vendor) === TRUE) {
        echo "Vendor added successfully";
    } else {
        echo "Error adding vendor: " . $conn->error;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Add Vendor</title>
</head>
<body>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-6">
            <!-- Vendor Registration Form -->
            <div class="form-container">
                <h2>Add Vendor</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="vendorname">Vendor Name</label>
                        <input type="text" class="form-control" id="vendorname" name="vendorname" placeholder="Enter Vendor Name" required>
                    </div>
                    <div class="form-group">
                        <label for="vendorlocation">Vendor Location</label>
                        <input type="text" class="form-control" id="vendorlocation" name="vendorlocation" placeholder="Enter Vendor Location" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="register">Add Vendor</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
