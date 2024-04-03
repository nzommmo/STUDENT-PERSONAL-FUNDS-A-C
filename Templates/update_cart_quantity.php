<?php
session_start();

// Check if the form is submitted with the quantity and item key
if(isset($_POST['quantity']) && isset($_POST['key'])) {
    // Get the quantity and item key from the form submission
    $quantity = $_POST['quantity'];
    $key = $_POST['key'];

    // Validate the quantity (ensure it's a positive integer)
    if(is_numeric($quantity) && $quantity > 0) {
        // Update the quantity in the cart session
        $_SESSION['cart'][$key]['quantity'] = $quantity;
    } else {
        // Quantity is invalid, handle the error (you can add your own error handling logic here)
        echo "Invalid quantity!";
        exit();
    }
} else {
    // Quantity or item key not provided, handle the error (you can add your own error handling logic here)
    echo "Quantity or item key not provided!";
    exit();
}

// Redirect back to the cart page
header("Location: cart.php");
exit();
?>
