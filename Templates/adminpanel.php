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
            width: 250px;
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
            padding: 10px 15px;
            font-weight: bold;
            color: #212529;
            background-color: #e9ecef;
        }
        /* Page content */
        .content {
            margin-left: 250px;
            transition: margin-left 0.5s;
            padding: 20px;
        }
        #date{
          margin-top: -60px;
        }
    </style>
</head>
<body>

<!-- Menu icon -->
<span style="font-size:30px;cursor:pointer" onclick="openNav()">&#9776;</span>

<!-- Sidebar -->
<div id="mySidebar" class="sidebar">
    <!-- Divider with user's name and date -->
    <div class="divider"  id="date">
        <span><?php echo $username; ?></span><br>
        <span>Date: <?php echo date("Y-m-d"); ?></span>
    </div>
    <!-- Close button -->
    <a href="javascript:void(0)" class="closebtn" onclick="closeNav()">&times;</a>
    <!-- Sidebar links -->
    <a href="#" id="accountdetailsbtn">Home</a>
    <!-- Divider -->
    <div class="divider">Students</div>
    <a href="#" id="addstudentbtn">Add Student</a>
    <a href="#">Delete Student</a>
    <a href="#">Update Student</a>
    <!-- Divider -->
    <div class="divider">Vendors</div>
    <a href="#">Add Vendor</a>
    <a href="#">Delete Vendor</a>
    <a href="#">Update Vendor</a>
    <!-- Logout -->
    <a href="logout.php">Logout</a>
</div>

<!-- Page content -->
<!-- Account details -->
<div class="content" id="accountdetails">
    <div class="card" style="width: 18rem;">
        <div class="card-body">
            <h5 class="card-title">Account Details</h5>
            <h6 class="card-subtitle mb-2 text-muted"><?php echo $username , $lastname; ?></h6>
            <p class="card-text">Account Number:<span id="accno"><?php echo $account_number?></span></p>
            <p class="card-text">Account Balance:<span id="bal"><?php echo $balance?></span></p>
            <button id="hide">Hide</button>
            <button id="view">View</button>
        </div>
    </div>
</div>

<!-- transactions history -->
<div class="content" id="addstudents" style="margin-top: 20px;">
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <?php
            // Include the transactions table
            include_once "add_student.php";
            ?>
        </div>
    </div>
</div>


<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>


<script src="../Static/adminpanel.js"></script>

</body>
</html>
