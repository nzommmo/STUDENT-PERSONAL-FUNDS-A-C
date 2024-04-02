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
    <h1>Success Message</h1>
    <!-- Success message will be displayed here -->
    <div class="success-message" id="successMessage">
        Your action was successful!
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

<script>
    // Function to display the success message
    function showSuccessMessage() {
        // Get the success message element
        var successMessage = document.getElementById('successMessage');
        // Display the success message
        successMessage.style.display = 'block';
        // Hide the success message after 3 seconds
        setTimeout(function () {
            successMessage.style.display = 'none';
        }, 3000); // 3000 milliseconds = 3 seconds
    }

    // Call the function to display the success message
    showSuccessMessage();
</script>

</body>
</html>