<?php
require_once 'config.php'; // Include the database configuration file

// Check if the form is submitted
if (isset($_POST['delete'])) {
    $userid = $_POST['userid'];

    // Start a transaction
    $conn->begin_transaction();

    // Attempt to delete the user's transaction history from the Transactions table
    $sql_delete_transactions = "DELETE FROM Transactions WHERE user_id='$userid'";
    if ($conn->query($sql_delete_transactions) === TRUE) {
        // Attempt to delete the user's account from the accounts table
        $sql_delete_account = "DELETE FROM accounts WHERE user_id='$userid'";
        if ($conn->query($sql_delete_account) === TRUE) {
            // If the account deletion is successful, delete the user's record from the User table
            $sql_delete_user = "DELETE FROM User WHERE user_id='$userid'";
            if ($conn->query($sql_delete_user) === TRUE) {
                // Commit the transaction if all deletions are successful
                $conn->commit();
                echo "User deleted successfully";
            } else {
                // Rollback the transaction if deleting user record fails
                $conn->rollback();
                echo "Error deleting user: " . $conn->error;
            }
        } else {
            // Rollback the transaction if deleting account fails
            $conn->rollback();
            echo "Error deleting user's account: " . $conn->error;
        }
    } else {
        // Rollback the transaction if deleting transactions fails
        $conn->rollback();
        echo "Error deleting user's transaction history: " . $conn->error;
    }
}

// Fetch all users
$sql_select_users = "SELECT * FROM User";
$result_users = $conn->query($sql_select_users);
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Manage Users</title>
</head>
<body>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-12">
            <h2>Manage Users</h2>
            <table class="table">
                <thead>
                <tr>
                    <th>User ID</th>
                    <th>First Name</th>
                    <th>Last Name</th>
                    <th>Email</th>
                    <th>Actions</th>
                </tr>
                </thead>
                <tbody>
                <?php
                if ($result_users->num_rows > 0) {
                    while ($row = $result_users->fetch_assoc()) {
                        echo "<tr>";
                        echo "<td>" . $row['user_id'] . "</td>";
                        echo "<td>" . $row['firstname'] . "</td>";
                        echo "<td>" . $row['lastname'] . "</td>";
                        echo "<td>" . $row['email'] . "</td>";
                        echo "<td>
                                <form method='POST' action='".htmlspecialchars($_SERVER["PHP_SELF"])."'>
                                    <input type='hidden' name='userid' value='".$row['user_id']."'>
                                    <button type='submit' class='btn btn-danger' name='delete'>Delete</button>
                                </form>
                              </td>";
                        echo "</tr>";
                    }
                } else {
                    echo "<tr><td colspan='5'>No users found</td></tr>";
                }
                ?>
                </tbody>
            </table>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
