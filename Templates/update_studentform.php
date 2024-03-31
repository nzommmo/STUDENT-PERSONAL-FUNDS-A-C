<?php
require_once 'config.php'; // Include the database configuration file

// Check if the form is submitted
if (isset($_POST['update'])) {
    $user_id = $_POST['user_id'];
    $newfirstname = $_POST['firstname'];
    $newlastname = $_POST['lastname'];
    $newemail = $_POST['email'];
    $newpassword = password_hash($_POST['password'], PASSWORD_DEFAULT);
    $role = isset($_POST['role']) ? $_POST['role'] : 'student'; // Set default role as 'student'

    // Update the user in the User table using prepared statements
    $sql_update_user = "UPDATE User SET 
    firstname=?, 
    lastname=?, 
    email=?, 
    hashedpassword=?,
    role=?
    WHERE user_id=?";
    
    $stmt = $conn->prepare($sql_update_user);
    $stmt->bind_param("sssssi", $newfirstname, $newlastname, $newemail, $newpassword, $role, $user_id);

    if ($stmt->execute()) {
        echo "User updated successfully";
    } else {
        echo "Error updating User: " . $conn->error;
    }

    // Close the prepared statement
    $stmt->close();
}

// Fetch user details for display
if (isset($_GET['id'])) {
    $user_id = $_GET['id'];
    $sql_select_user = "SELECT * FROM User WHERE user_id=?";
    
    $stmt = $conn->prepare($sql_select_user);
    $stmt->bind_param("i", $user_id);
    $stmt->execute();
    
    $result = $stmt->get_result();

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        $firstName = $row['firstname'];
        $lastName = $row['lastname'];
        $email = $row['email'];
        // Password should not be retrieved for security reasons
        $role = $row['role'];
    } else {
        echo "User not found";
    }

    // Close the prepared statement
    $stmt->close();
}
?>

<!-- HTML Form -->
<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Update User</title>
</head>
<body>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-6">
            <!-- User Update Form -->
            <div class="form-container">
                <h2>Update User</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <input type="hidden" name="user_id" value="<?php echo $user_id; ?>">
                    <div class="form-group">
                        <label for="firstname">New First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" value="<?php echo $firstName; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">New Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" value="<?php echo $lastName; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="email">New Email</label>
                        <input type="email" class="form-control" id="email" name="email" value="<?php echo $email; ?>" required>
                    </div>
                    <div class="form-group">
                        <label for="password">New Password</label>
                        <input type="password" class="form-control" id="password" name="password" required>
                    </div>
                    <div class="form-group">
                        <label for="role">Role</label>
                        <select class="form-select" id="role" name="role">
                            <option value="admin" <?php if($role == 'admin') echo 'selected'; ?>>Admin</option>
                            <option value="student" <?php if($role == 'student') echo 'selected'; ?>>Student</option>
                        </select>
                    </div>
                    <button type="submit" class="btn btn-primary" name="update">Update User</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
