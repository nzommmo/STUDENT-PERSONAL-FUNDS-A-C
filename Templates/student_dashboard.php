<?php
// Start the session
session_start();

// Include the database configuration file
include_once "config.php";

// Check if the user is logged in
if(isset($_SESSION['user_id'])) {
    // Prepare and execute SQL query to retrieve username
    $user_id = $_SESSION['user_id'];
    $sql = "SELECT firstname,lastname, account_number, balance FROM User JOIN accounts ON User.user_id = accounts.user_id WHERE User.user_id = ?";   
    $stmt = $conn->prepare($sql);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    $result = $stmt->get_result();

    // Check if user exists
    if ($result->num_rows > 0) {
        // Fetch user's name
        $row = $result->fetch_assoc();
        $username = $row["firstname"];
        $lastname = $row["lastname"];
        $account_number = $row["account_number"];
        $balance = $row["balance"];
    } else {
        $username = "User";
        $account_number = "N/A";
        $balance = "N/A";
    }

    // Close statement
    $stmt->close();
} else {
    // If user is not logged in, set a default username
    $username = "Guest";
    $account_number = "N/A";
    $balance = "N/A";
    
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Toggleable Sidebar</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Custom CSS -->
    <style>
        /* Sidebar */
        .sidebar {
            height: 100%;
            width: 0;
            position: fixed;
            top: 0;
            left: 0;
            background-color: #f8f9fa;
            overflow-x: hidden;
            transition: 0.5s;
            padding-top: 60px;
        }
        /* Sidebar links */
        .sidebar a {
            padding: 10px 15px;
            text-decoration: none;
            font-size: 20px;
            color: #212529;
            display: block;
            transition: 0.3s;
        }
        /* Close button */
        .closebtn {
            position: absolute;
            top: 0;
            right: 25px;
            font-size: 36px;
            margin-left: 50px;
        }
        /* Close button on hover */
        .closebtn:hover {
            color: #aaa;
            cursor: pointer;
        }
        /* Divider */
        .divider {
            margin-top: -60px;
            padding: 15px 15px 10px; /* Adjusted padding */
            background-color: #e9ecef;
            font-weight: bold;
            color: #212529;
            margin-bottom:20px ;
        }
        /* Page content */
        .content {
            margin-left: 250px;
            transition: margin-left 0.5s;
            padding: 20px;
        }
    </style>
</head>
<body>

<!-- Menu icon -->
<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>

<!-- Sidebar -->
<div id="mySidebar" class="sidebar">
    <!-- Divider with user's name and date -->
    <div class="divider">
        <span><?php echo $username; ?></span><br>
        <span>Date: <?php echo date("Y-m-d"); ?></span>
    </div>
    <!-- Close button -->
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <!-- Sidebar links -->
    <a href="#" id="accountdetailsbtn">Home</a>
    <a href="#" id="depositbtn">Deposit</a>
    <a href="#" id="withdrawbtn">Withdraw</a>
    <a href="#" id="transactbtn">Transact</a>
    <a href="#" id="historybtn">Transact History</a>    
    <a href="logout.php">Logout</a>    
        
    </a>
    
</div>

<!-- Page content -->
<!-- Account details -->
<div class="content" id="accountdetails">
<div class="card" style="width: 18rem;">
  <div class="card-body">
    <h5 class="card-title">Account Details </h5>
    <h6 class="card-subtitle mb-2 text-muted">        <span><?php echo $username , $lastname; ?></span><br>
 </h6>
    <p class="card-text">Account Number:<span id="accno"><?php echo $account_number?></span></p>
    <p class="card-text">Account Balance:<span id="bal"><?php echo $balance?></span></p>
    <button id="hide">Hide</button>
    <button id="view">View</button>

  </div>
</div>
</div>
<!-- Deposit -->
<div class="content" id="depositcard">
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <?php
            // Start the session
            session_start();

            // Check if there's a message set in the session
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-info" role="alert">' . $_SESSION['message'] . '</div>';
                // Clear the message after displaying it
                unset($_SESSION['message']);
            }
            ?>
            <form id="depositForm" action="deposit.php" method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" id="depositInput" name="amount" aria-describedby="depositHelp" placeholder="Enter amount to deposit">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>

<!-- Withdraw -->
<div class="content" id="withdrawcard">
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <?php
            // Start the session
            session_start();

            // Check if there's a message set in the session
            if (isset($_SESSION['message'])) {
                echo '<div class="alert alert-info" role="alert">' . $_SESSION['message'] . '</div>';
                // Clear the message after displaying it
                unset($_SESSION['message']);
            }
            ?>
            <form id="depositForm" action="withdraw.php" method="POST">
                <div class="mb-3">
                    <input type="text" class="form-control" id="depositInput" name="amount" aria-describedby="depositHelp" placeholder="Enter amount to withdraw">
                </div>
                <button type="submit" class="btn btn-primary">Submit</button>
            </form>
        </div>
    </div>
</div>
<!-- Transactions -->
<div class="content" id="transactions" style="margin-top: 0;">
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <?php
            // Include the transactions table
            include_once "transactions.php";
            ?>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<!-- JavaScript to open/close sidebar -->
<script>
    function openNav() {
        document.getElementById("mySidebar").style.width = "250px";
        document.getElementById("mySidebar").style.display = "block";
        document.getElementsByClassName("content")[0].style.marginLeft = "250px";
    }

    function closeNav() {
        document.getElementById("mySidebar").style.width = "0";
        document.getElementById("mySidebar").style.display = "none";
        document.getElementsByClassName("content")[0].style.marginLeft = "0";
    }
    function hideDetails() {
        document.getElementById('accno').style.display = 'none';
        document.getElementById('bal').style.display = 'none';

    }
    document.getElementById("hide").addEventListener("click", hideDetails);

    function showDetails() {
        document.getElementById('accno').style.display = 'contents';
        document.getElementById('bal').style.display = 'contents';
    }
    document.getElementById("view").addEventListener("click", showDetails);

</script>

</body>
<script src="../Static/student_dashboard.js"></script>
</html>
