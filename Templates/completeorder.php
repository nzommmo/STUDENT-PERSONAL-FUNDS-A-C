<?php
session_start();

// Include database connection
include_once "config.php";

// Check if the user is logged in
if (!isset($_SESSION['user_id'])) {
    $_SESSION['cart_message'] = "You are not logged in. Please log in to proceed.";
    header("Location: login.php");
    exit();
}

// Check if the cart is empty
if (empty($_SESSION['cart'])) {
    $_SESSION['cart_message'] = "Your cart is empty!";
    $_SESSION['cart_message_sub'] = "You can either log out or go back to the main page.";
    header("Location: student_dashboard.php"); // Assuming the main page is named index.php
    exit();
}

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

// Fetch user balance from the accounts table
$sql_balance = "SELECT balance FROM accounts WHERE user_id = ?";
$stmt_balance = $conn->prepare($sql_balance);
$stmt_balance->bind_param("i", $userId);
$stmt_balance->execute();
$result_balance = $stmt_balance->get_result();
$userBalance = $result_balance->fetch_assoc()['balance'];

// Check if user balance is sufficient for the purchase
if ($userBalance < $totalPrice) {
    $_SESSION['cart_message'] = "Insufficient balance! Please top up your balance.";
    header("Location: cart.php");
    exit();
}

// Deduct total price from user balance
$newBalance = $userBalance - $totalPrice;

// Update user balance in the accounts table
$sql_update_balance = "UPDATE accounts SET balance = ? WHERE user_id = ?";
$stmt_update_balance = $conn->prepare($sql_update_balance);
$stmt_update_balance->bind_param("di", $newBalance, $userId);
$stmt_update_balance->execute();
$stmt_update_balance->close();

// Insert purchase record into transactions table
$transactionType = "purchase"; // Default transaction type
$sql_insert_transaction = "INSERT INTO Transactions (user_id, amount, transaction_type) VALUES (?, ?, ?)";
$stmt_insert_transaction = $conn->prepare($sql_insert_transaction);
$stmt_insert_transaction->bind_param("ids", $userId, $totalPrice, $transactionType);
$stmt_insert_transaction->execute();
$stmt_insert_transaction->close();

// Clear the cart by unsetting the cart session variable
unset($_SESSION['cart']);

// Set success message in session
$_SESSION['cart_message'] = "Purchase successful! Thank you for shopping with us.";

header("Location: cart.php");
exit();
?>
