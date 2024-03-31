<?php

require_once 'config.php'; // Include the database configuration file

// Check if the form is submitted
if (isset($_POST['delete'])) {
    $vendorId = $_POST['vendor_id'];

    // First, delete associated records from the StockItems table
    $sql_delete_stock_items = "DELETE FROM StockItems WHERE VendorID=?";
    $stmt = $conn->prepare($sql_delete_stock_items);
    $stmt->bind_param("i", $vendorId);

    if ($stmt->execute()) {
        // Then, delete the vendor from the Vendors table
        $sql_delete_vendor = "DELETE FROM Vendors WHERE VendorID=?";
        $stmt = $conn->prepare($sql_delete_vendor);
        $stmt->bind_param("i", $vendorId);

        if ($stmt->execute()) {
            echo "Vendor Deleted successfully";
        } else {
            echo "Error Deleting vendor: " . $conn->error;
        }
    } else {
        echo "Error Deleting associated stock items: " . $conn->error;
    }

    // Close the statement
    $stmt->close();
}
// Fetch vendor details for display
if (isset($_GET['id'])) {
    $vendorId = $_GET['id'];
    $sql_select_vendor = "SELECT * FROM Vendors WHERE VendorID='$vendorId'";
    $result = $conn->query($sql_select_vendor);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $vendorName = $row['VendorName'];
    } else {
        echo "Vendor not found";
    }
}
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
