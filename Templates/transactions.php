<?php
// Start the session
if (session_status() !== PHP_SESSION_ACTIVE) {
    session_start();
}

// Include the database configuration file
include_once "config.php";

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
    // Get user ID from session
    $user_id = $_SESSION['user_id'];

    // Fetch transactions for the logged-in user
    $sql = "SELECT * FROM Transactions WHERE user_id = ?";
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if there are any transactions
    if ($result->num_rows > 0) {
        ?>
        <!DOCTYPE html>
        <html lang="en">
        <head>
            <meta charset="UTF-8">
            <meta name="viewport" content="width=device-width, initial-scale=1.0">
            <title>Transactions</title>
            <!-- Bootstrap CSS -->
            <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
        </head>
        <body>
            <div class="container mt-5">
                <h2>Transactions</h2>
                <div class="table-responsive">
                    <table class="table table-striped">
                        <thead>
                            <tr>
                                <th>Transaction ID</th>
                                <th>Transaction Type</th>
                                <th>Amount</th>
                                <th>Date</th>
                            </tr>
                        </thead>
                        <tbody>
                        <?php
                        // Output data of each row
                        while($row = $result->fetch_assoc()) {
                            echo "<tr>";
                            echo "<td>" . $row["transaction_id"] . "</td>";
                            echo "<td>" . $row["transaction_type"] . "</td>";
                            echo "<td>" . $row["amount"] . "</td>";
                            echo "<td>" . $row["transaction_date"] . "</td>";
                            echo "</tr>";
                        }
                        ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

        </body>
        </html>
        <?php
    } else {
        echo "No transactions found.";
    }

    // Close statement
    $stmt->close();
} else {
    // If user is not logged in, redirect to login page
    header("Location: login.php");
    exit();
}

// Close connection
$conn->close();
?>
