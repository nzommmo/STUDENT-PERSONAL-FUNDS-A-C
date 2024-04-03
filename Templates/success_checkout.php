<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Success Message</title>
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        /* Custom CSS for styling the success message */
        .success-message {
            display: none;
            position: fixed;
            top: 20px;
            left: 50%;
            transform: translateX(-50%);
            z-index: 9999;
            padding: 10px 20px;
            background-color: #28a745;
            color: #fff;
            border-radius: 5px;
        }
    </style>
</head>
<body>

<div class="container mt-5">
    <!-- Success message will be displayed here -->
    <div class="success-message" id="successMessage">
        Thank you for your purchase! Redirecting you to the login page...
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Function to display the success message and redirect to login page
    function showSuccessMessage() {
        // Get the success message element
        var successMessage = document.getElementById('successMessage');
        // Display the success message
        successMessage.style.display = 'block';
        // Hide the success message after 3 seconds and redirect to login page
        setTimeout(function () {
            successMessage.style.display = 'none';
            window.location.href = 'login.php'; // Redirect to login page
        }, 3000); // 3000 milliseconds = 3 seconds
    }

    // Call the function to display the success message and redirect
    showSuccessMessage();
</script>

</body>
</html>
