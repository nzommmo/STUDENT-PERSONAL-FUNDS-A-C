<?php
require_once 'config.php'; // Include the database configuration file

// Function to generate account number
function generateAccountNumber() {
    $prefix = '0124';
    $randomNumber = $prefix;
    for ($i = strlen($prefix); $i < 16; $i++) {
        $randomNumber .= mt_rand(0, 9);
    }
    return $randomNumber;
}

// Check if the form is submitted
if (isset($_POST['register'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $email = $_POST['email'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $account_number = generateAccountNumber(); // Generate account number

    // Insert the student into the User table
    $sql_student = "INSERT INTO User (firstname, lastname, email, hashedpassword, role) VALUES ('$firstname', '$lastname', '$email', '$password', 'student')";
    if ($conn->query($sql_student) === TRUE) {
        // Insert student's account into the accounts table with the generated account number
        $sql_account = "INSERT INTO accounts (user_id, account_number, balance) VALUES ('$conn->insert_id', '$account_number', 0)";
        if ($conn->query($sql_account) === TRUE) {
            echo "Student added successfully";
        } else {
            echo "Error inserting account: " . $conn->error;
        }
    } else {
        echo "Error adding student: " . $conn->error;
    }
}
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">
    <title>Add Student</title>
</head>
<body>
<div class="container">
    <div class="row mt-5">
        <div class="col-md-6">
            <!-- Student Registration Form -->
            <div class="form-container">
                <h2>Add Student</h2>
                <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
                    <div class="form-group">
                        <label for="firstname">First Name</label>
                        <input type="text" class="form-control" id="firstname" name="firstname" placeholder="Enter First Name" required>
                    </div>
                    <div class="form-group">
                        <label for="lastname">Last Name</label>
                        <input type="text" class="form-control" id="lastname" name="lastname" placeholder="Enter Last Name" required>
                    </div>
                    <div class="form-group">
                        <label for="email">Email address</label>
                        <input type="email" class="form-control" id="email" name="email" aria-describedby="emailHelp" placeholder="Enter email" required>
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password" placeholder="Password" required>
                    </div>
                    <button type="submit" class="btn btn-primary" name="register">Add Student</button>
                </form>
            </div>
        </div>
    </div>
</div>
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
</body>
</html>
