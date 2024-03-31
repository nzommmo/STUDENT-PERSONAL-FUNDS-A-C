<?php

require_once 'config.php'; // Include the database configuration file

// Check if the form is submitted
if (isset($_POST['delete'])) {
    $user_id = $_POST['user_id'];

    // First, delete associated records from the Transactions table
    $sql_delete_transactions = "DELETE FROM Transactions WHERE user_id=?";
    $stmt_transactions = $conn->prepare($sql_delete_transactions);
    $stmt_transactions->bind_param("i", $user_id);

    if ($stmt_transactions->execute()) {
        // Then, delete the user from the User table
        $sql_delete_user = "DELETE FROM User WHERE user_id=?";
        $stmt_user = $conn->prepare($sql_delete_user);
        $stmt_user->bind_param("i", $user_id);

        if ($stmt_user->execute()) {
            echo "User deleted successfully";
        } else {
            echo "Error deleting user: " . $conn->error;
        }
    } else {
        echo "Error deleting associated Transactions : " . $conn->error;
    }

    // Close the statements
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
?>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
