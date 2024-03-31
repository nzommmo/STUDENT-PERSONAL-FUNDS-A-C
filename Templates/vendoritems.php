<?php
// Include database connection
include_once "config.php";

// Check if vendor ID is provided in the URL
if(isset($_GET['id'])) {
    $vendorId = $_GET['id'];

    // Fetch vendor details
    $sql_vendor = "SELECT VendorName, VendorLocation FROM Vendors WHERE VendorID = ?";
    $stmt_vendor = $conn->prepare($sql_vendor);
    $stmt_vendor->bind_param("i", $vendorId);
    $stmt_vendor->execute();
    $result_vendor = $stmt_vendor->get_result();

    if ($result_vendor->num_rows > 0) {
        $row_vendor = $result_vendor->fetch_assoc();
        $vendorName = $row_vendor['VendorName'];
        $vendorLocation = $row_vendor['VendorLocation'];

        // Fetch vendor items
        $sql_items = "SELECT * FROM VendorItems WHERE vendor_id = ?";
        $stmt_items = $conn->prepare($sql_items);
        $stmt_items->bind_param("i", $vendorId);
        $stmt_items->execute();
        $result_items = $stmt_items->get_result();
    } else {
        echo "Vendor not found";
        exit(); // Stop further execution
    }

    // Close statements
    $stmt_vendor->close();
    $stmt_items->close();
} else {
    echo "Vendor ID not provided";
    exit(); // Stop further execution
}
session_start();

// Initialize cart items variable
$cartItems = array();

// Check if cart session variable is set
if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
    $cartItems = $_SESSION['cart'];
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $vendorName; ?> Items</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container mt-5">
        <!-- Cart items section -->
        <div class="row mb-4">
            <div class="col">
                <h3>Items in Cart</h3>
                <ul>
                    <?php
                    // Display items in cart
                    foreach ($cartItems as $cartItem) {
                        echo "<li>{$cartItem['item_name']} - Ksh {$cartItem['item_price']}</li>";
                    }
                    ?>
                </ul>
            </div>
        </div>
    <div class="container mt-5">
        <h1><?php echo $vendorName; ?> Items</h1>
        <h3>Location: <?php echo $vendorLocation; ?></h3>
        <div class="row">
            <?php
            if ($result_items->num_rows > 0) {
                while ($row_item = $result_items->fetch_assoc()) {
                    ?>
                    <div class="col-md-4 mb-3">
                        <div class="card">
                            <div class="card-body">
                                <h5 class="card-title"><?php echo $row_item['item_name']; ?></h5>
                                <p class="card-text">Description: <?php echo $row_item['item_description']; ?></p>
                                <p class="card-text">Price: Ksh <?php echo $row_item['item_price']; ?></p>
                                <!-- Add to Cart form -->
                                <form action="cart.php" method="post">
                                    <input type="hidden" name="item_id" value="<?php echo $row_item['item_id']; ?>">
                                    <input type="hidden" name="item_name" value="<?php echo $row_item['item_name']; ?>">
                                    <input type="hidden" name="item_price" value="<?php echo $row_item['item_price']; ?>">
                                    <input type="hidden" name="vendor_id" value="<?php echo $vendorId; ?>"> <!-- Add vendor_id -->
                                    <button type="submit" class="btn btn-primary">Add to Cart</button>
                                </form>

                            </div>
                        </div>
                    </div>
                    <?php
                }
            } else {
                echo "No items found for this vendor.";
            }
            ?>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
