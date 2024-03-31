<?php
session_start();

// Include database connection
include_once "config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    // Redirect to login page if user is not logged in
    header("Location: login.php");
    exit();
}

// Check if the cart session variable is set and not empty
if (!isset($_SESSION['cart']) || empty($_SESSION['cart'])) {
    // Redirect back to the cart page if the cart is empty
    echo '<div class="alert alert-danger" role="alert">No items in the cart!</div>';
    exit();
}

// Get the user's ID
$user_id = $_SESSION['user_id'];

// Fetch the user's balance from the database
$sql_balance = "SELECT balance FROM accounts WHERE user_id = ?";
$stmt_balance = $conn->prepare($sql_balance);
$stmt_balance->bind_param("i", $user_id);
$stmt_balance->execute();
$result_balance = $stmt_balance->get_result();

if ($result_balance->num_rows > 0) {
    $row_balance = $result_balance->fetch_assoc();
    $balance = $row_balance['balance'];
} else {
    // Redirect back to the cart page if the user's balance is not found
    header("Location: cart.php");
    exit();
}

// Calculate the total price of items in the cart
$total_price = 0;
foreach ($_SESSION['cart'] as $cartItem) {
    $total_price += $cartItem['item_price'];
}

// Check if the user has enough balance to make the purchase
if ($balance >= $total_price) {
    // Update the user's balance in the database
    $new_balance = $balance - $total_price;
    $sql_update_balance = "UPDATE accounts SET balance = ? WHERE user_id = ?";
    $stmt_update_balance = $conn->prepare($sql_update_balance);
    $stmt_update_balance->bind_param("ii", $new_balance, $user_id);
    $stmt_update_balance->execute();
    $stmt_update_balance->close();

    // Clear the cart session variable
    unset($_SESSION['cart']);

    // Redirect to a success page or display a success message
    $_SESSION['message'] = "Checkout successful!";
    header("Location: success_checkout.php");
    exit();
} else {
    // Redirect back to the cart page with an error message if the user doesn't have enough balance
    $_SESSION['error'] = "Insufficient balance!";
    header("Location: cart.php");
    exit();
}

// Close database connection
$stmt_balance->close();
$conn->close();
?>
