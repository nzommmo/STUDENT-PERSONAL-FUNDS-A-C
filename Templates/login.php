<?php
require_once 'config.php'; // Include the database configuration file

function generateAccountNumber() {
  $prefix = '0124';
  $randomNumber = $prefix;
  for ($i = strlen($prefix); $i < 16; $i++) {
      $randomNumber .= mt_rand(0, 9);
  }
  return $randomNumber;
}

// Register user
if (isset($_POST['register'])) {
    $firstname = $_POST['firstname'];
    $lastname = $_POST['lastname'];
    $password = password_hash($_POST['password'], PASSWORD_DEFAULT); // Hash password
    $email = $_POST['email'];
    $account_number = generateAccountNumber();

   // Insert user into the User table
   $sql_user = "INSERT INTO User (firstname, lastname, hashedpassword, email) VALUES ('$firstname', '$lastname', '$password', '$email')";
   if ($conn->query($sql_user) === TRUE) {
       // Insert user's account into the accounts table
       $sql_account = "INSERT INTO accounts (user_id, account_number, balance) VALUES ('$conn->insert_id', '$account_number', 0)";
       if ($conn->query($sql_account) === TRUE) {
           echo "User registered successfully";
       } else {
           echo "Error inserting account: " . $conn->error;
       }
   } else {
       echo "Error inserting user: " . $conn->error;
   }

}

// Login user
session_start(); // Start session if not already started

require_once 'config.php'; // Include the database configuration file

// Login user
if (isset($_POST['login'])) {
    $email = $_POST['email'];
    $password = $_POST['password'];

    $sql = "SELECT * FROM User WHERE email='$email'"; // Corrected table name to 'User'
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
        $row = $result->fetch_assoc();
        if (password_verify($password, $row['hashedpassword'])) {
            if ($row['role'] == 'admin') { // Check if user is admin
                $_SESSION['user_id'] = $row['user_id']; // Store user ID in session
                echo "Login successful";

                // Redirect to admin panel after successful login
                header("Location: adminpanel.php");
                exit(); // Exit to prevent further execution
            } elseif ($row['role'] == 'student') { // Check if user is student
                $_SESSION['user_id'] = $row['user_id']; // Store user ID in session
                echo "Login successful";

                // Redirect to student dashboard after successful login
                header("Location: student_dashboard.php");
                exit(); // Exit to prevent further execution
            }
        } else {
            echo "Invalid email or password";
        }
    } else {
        echo "Email not found";
    }
}
?>

<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Login</title>
  </head>
  <body>
  <div class="container">
    <div class="row mt-5">
      <div class="col-md-6">
        <!-- Login Form -->
        <div class="form-container">
          <h2>Login</h2>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
              <label for="loginEmail">Email address</label>
              <input type="email" class="form-control" id="loginEmail" name="email" aria-describedby="emailHelp" placeholder="Enter email" value="">
            </div>
            <div class="form-group">
              <label for="loginPassword">Password</label>
              <input type="password" class="form-control" id="loginPassword" name="password" placeholder="Password" value="">
            </div>
            <button type="submit" class="btn btn-primary" name="login">Login</button>
          </form>
          <h1>Not Yet Registered?</h1>
            <p>
 
  <button class="btn btn-primary" type="button" data-bs-toggle="collapse" data-bs-target="#collapseExample" aria-expanded="false" aria-controls="collapseExample">
    Signup
  </button>
</p>
<div class="collapse" id="collapseExample">
  <div class="card card-body">
            <!-- Signup Form -->
            <div class="form-container">
          <h2>Sign Up</h2>
          <form method="POST" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>">
            <div class="form-group">
              <label for="signupName">FirstName</label>
              <input type="text" class="form-control" id="signupName" name="firstname" placeholder="Enter First Name" value="">
            </div>   <div class="form-group">
              <label for="signupName">LastName</label>
              <input type="text" class="form-control" id="signupName" name="lastname" placeholder="Enter Last Name" value="">
            </div>
            <div class="form-group">
              <label for="signupEmail">Email address</label>
              <input type="email" class="form-control" id="signupEmail" name="email" aria-describedby="emailHelp" placeholder="Enter email" value="">
            </div>
            <div class="form-group">
              <label for="signupPassword">Password</label>
              <input type="password" class="form-control" id="signupPassword" name="password" placeholder="Password" value="">
            </div>
            <button type="submit"  class="btn btn-primary" name="register">Sign Up</button>
          </form>
        </div>
  </div>
</div>
        </div>
      </div>
      <div class="col-md-6">

      </div>
    </div>
  </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>
  </body>
</html>