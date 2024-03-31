<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Hello, world!</title>
  </head>
  <body>
<!-- Update Vendors  -->
<div class="content" id="updatevendors" style="margin-top: 20px;">
    <div class="card" style="width: 100%;">
        <div class="card-body">
        <div class="container mt-5">
    <div class="row">
        <?php
        // Include database connection
        include_once "config.php";

        // Fetch vendors from database
        $sql = "SELECT * FROM Vendors";
        $result = $conn->query($sql);

        // Check if there are vendors
        if ($result->num_rows > 0) {
            while ($row = $result->fetch_assoc()) {
                // Vendor data
                $vendorId = $row['VendorID'];
                $vendorName = $row['VendorName'];
                $vendorLocation = $row['VendorLocation'];
        ?>
        <div class="col-md-4 mb-3">
            <div class="card">
                <div class="card-body">
                    <h5 class="card-title"><?php echo $vendorName; ?></h5>
                    <p class="card-text"><?php echo $vendorLocation; ?></p>
                    <!-- Update Button -->
                    <a href="vendoritems.php?id=<?php echo $vendorId; ?>" class="btn btn-primary">View Products</a>
                    <!-- View Products Button (Optional) -->
                </div>
            </div>
        </div>
        <?php
            }
        } else {
            echo "<div class='col'>No vendors found.</div>";
        }

        // Close database connection
        $conn->close();
        ?>
    </div>
</div>

        </div>
    </div>
</div>








    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

 
  </body>
</html>



