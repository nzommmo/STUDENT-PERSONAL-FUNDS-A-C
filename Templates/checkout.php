<?php
session_start();

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php"); // Redirect to login page if user is not logged in
    exit();
}

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    echo "Your cart is empty!";
    exit();
}

// Include database connection
include_once "config.php";

// Fetch buyer information (assuming user_id is stored in session)
$userId = $_SESSION['user_id'];
$sql_buyer = "SELECT * FROM User WHERE user_id = ?";
$stmt_buyer = $conn->prepare($sql_buyer);
$stmt_buyer->bind_param("i", $userId);
$stmt_buyer->execute();
$result_buyer = $stmt_buyer->get_result();
$buyer = $result_buyer->fetch_assoc();

// Fetch total price to be paid
$totalPrice = 0;
foreach ($_SESSION['cart'] as $cartItem) {
    $totalPrice += ($cartItem['item_price'] * $cartItem['quantity']);
}

// Fetch vendor information
$vendorId = $_SESSION['cart'][0]['vendor_id']; // Assuming all items in the cart are from the same vendor
$sql_vendor = "SELECT * FROM Vendors WHERE VendorID = ?";
$stmt_vendor = $conn->prepare($sql_vendor);
$stmt_vendor->bind_param("i", $vendorId);
$stmt_vendor->execute();
$result_vendor = $stmt_vendor->get_result();
$vendor = $result_vendor->fetch_assoc();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Checkout</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>

<div class="container">
    <h1>Checkout</h1>
    <h2>Vendor: <?php echo $vendor['VendorName']; ?></h2>
    <h3>Buyer Information:</h3>
    <p>Name: <?php echo $buyer['firstname']; ?></p>
    <p>Email: <?php echo $buyer['email']; ?></p>

    <h3>Items Bought:</h3>
    <table class="table">
        <thead>
        <tr>
            <th>Item Name</th>
            <th>Price</th>
            <th>Quantity</th>
            <th>Total</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($_SESSION['cart'] as $cartItem): ?>
            <tr>
                <td><?php echo $cartItem['item_name']; ?></td>
                <td><?php echo $cartItem['item_price']; ?></td>
                <td><?php echo $cartItem['quantity']; ?></td>
                <td><?php echo $cartItem['item_price'] * $cartItem['quantity']; ?></td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

    <h3>Total Price to be Paid: <?php echo $totalPrice; ?></h3>

    <!-- You can add a form for payment processing here -->
                <!-- Checkout button -->
                <a href="completeorder.php" class="btn btn-primary" id="">Complete Purchase</a>

</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
