<?php
error_reporting(E_ALL);

// Start the session
session_start();

// Include the database configuration file
include_once "config.php";

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Validate the amount
    if(isset($_POST['amount']) && is_numeric($_POST['amount'])) {
        $amount = $_POST['amount'];

        // Check if the user has an account
        $stmt = $conn->prepare("SELECT COUNT(*) FROM accounts WHERE user_id = ?");
        $stmt->bind_param("i", $user_id);
        $stmt->execute();
        $stmt->bind_result($account_count);
        $stmt->fetch();
        $stmt->close();

        if ($account_count == 0) {
            // Insert a new row for the user with initial balance
            $stmt = $conn->prepare("INSERT INTO accounts (user_id, balance) VALUES (?, ?)");
            $initial_balance = 0; // You can set an initial balance here if needed
            $stmt->bind_param("id", $user_id, $initial_balance);
            $stmt->execute();
            $stmt->close();
        }

        // Update the database with the withdrawn amount
        $sql = "UPDATE accounts SET balance = balance - ? WHERE user_id = ?";
        $stmt = $conn->prepare($sql);

        if ($stmt) {
            $stmt->bind_param("ii", $amount, $user_id);
        
            // Execute the prepared statement
            if ($stmt->execute()) {
                // Check if the withdrawal was successful
                if($stmt->affected_rows > 0) {
                    // Record the transaction in the transactions table
                    $transaction_type = "withdrawal";
                    $transaction_sql = "INSERT INTO Transactions (user_id, transaction_type, amount) VALUES (?, ?, ?)";
                    $transaction_stmt = $conn->prepare($transaction_sql);
                    $transaction_stmt->bind_param("iss", $user_id, $transaction_type, $amount);
                    if ($transaction_stmt->execute()) {
                        $_SESSION['message'] = "Withdraw successful!";
                    } else {
                        $_SESSION['message'] = "Failed to record transaction. Please try again.";
                    }
                    $transaction_stmt->close();
                } else {
                    $_SESSION['message'] = "Failed to withdraw. Please try again.";
                }
            } else {
                // Handle SQL execution error
                $_SESSION['message'] = "SQL Error: " . $stmt->error;
            }

            // Close statement
            $stmt->close();
        } else {
            $_SESSION['message'] = "Failed to prepare statement. Please try again.";
        }
    } else {
        $_SESSION['message'] = "Invalid amount.";
    }
} else {
    $_SESSION['message'] = "User not logged in.";
}

// Redirect back to the withdrawal page
header("Location: student_dashboard.php");
exit();
?>
