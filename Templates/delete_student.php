<?php
require_once 'config.php'; // Include the database configuration file

// Disable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 0");

// Check if the form is submitted
if (isset($_POST['delete'])) {
    $user_id = $_POST['user_id'];

    // First, delete associated records from the accounts table
    $sql_delete_accounts = "DELETE FROM accounts WHERE user_id=?";
    $stmt_accounts = $conn->prepare($sql_delete_accounts);
    $stmt_accounts->bind_param("i", $user_id);

    if ($stmt_accounts->execute()) {
        // Then, delete associated records from the Transactions table
        $sql_delete_transactions = "DELETE FROM Transactions WHERE user_id=?";
        $stmt_transactions = $conn->prepare($sql_delete_transactions);
        $stmt_transactions->bind_param("i", $user_id);

        if ($stmt_transactions->execute()) {
            // Finally, delete the user from the User table
            $sql_delete_user = "DELETE FROM User WHERE user_id=?";
            $stmt_user = $conn->prepare($sql_delete_user);
            $stmt_user->bind_param("i", $user_id);

            if ($stmt_user->execute()) {
                echo "User deleted successfully";
            } else {
                echo "Error deleting user: " . $conn->error;
            }
        } else {
            echo "Error deleting associated transactions: " . $conn->error;
        }
    } else {
        echo "Error deleting associated accounts: " . $conn->error;
    }

    // Close the statements
    $stmt_accounts->close();
    $stmt_transactions->close();
    $stmt_user->close();
}

// Fetch user details for display
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql_select_User = "SELECT * FROM User WHERE user_id='$user_id'";
    $result = $conn->query($sql_select_User);
    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstname = $row['firstname'];
    } else {
        echo "User not found";
    }
}

// Enable foreign key checks
$conn->query("SET FOREIGN_KEY_CHECKS = 1");
?>
