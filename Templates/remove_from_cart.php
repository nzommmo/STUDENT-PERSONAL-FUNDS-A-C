<?php
session_start();

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['item_id'])) {
    // Get the item ID to be removed from the cart
    $item_id = $_POST['item_id'];

    // Check if the cart session variable is set and not empty
    if (isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
        // Loop through the cart items
        foreach ($_SESSION['cart'] as $key => $cartItem) {
            // If the item ID matches the ID of the item to be removed, unset it from the cart
            if ($cartItem['item_id'] == $item_id) {
                unset($_SESSION['cart'][$key]);
                break; // Exit the loop once the item is removed
            }
        }
    }
}

// Redirect back to the cart page after removing the item
header("Location: cart.php");
exit();
?>
