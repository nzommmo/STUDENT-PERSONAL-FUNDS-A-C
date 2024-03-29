<?php

require_once 'config.php'; // Include the database configuration file

// Check if the form is submitted
if (isset($_POST['update'])) {
    $userid = $_POST['userid'];
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password

    // Update the student's information in the User table
    $sql_update = "UPDATE User SET firstname='$firstname', lastname='$lastname', email='$email', hashedpassword='$password' WHERE user_id='$userid'";
    if ($conn->query($sql_update) === TRUE) {
        echo "Student information updated successfully";
    } else {
        echo "Error updating student information: " . $conn->error;
    }
}

// Fetch the student's current information
$userid = $_GET['id']; // Assuming you are passing the user ID through the URL
$sql_select = "SELECT * FROM User WHERE user_id='$userid'";
$result = $conn->query($sql_select);
$student = $result->fetch_assoc();
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Update Student</title>
</head>
<body>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-6">
            <!-- Student Update Form -->
            <div class="form-container">
                <h2>Update Student</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="userid" value="<?php echo $student['user_id']; ?>">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter First Name" value="<?php echo $student['firstname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name" value="<?php echo $student['lastname']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" value="<?php echo $student['email']; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update">Update Student</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
