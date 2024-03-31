<!doctype html>
<html lang="en">
  <head>
    <!-- Required meta tags -->
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-1BmE4kWBq78iYhFldvKuhfTAU6auU8tT94WrHftjDbrCEXSU1oBoqyl2QvZ6jIW3" crossorigin="anonymous">

    <title>Update Student Records</title>
  </head>
  <body>


  <div class="content" id="updatevend" style="margin-top: 20px;">
    <div class="card" style="width: 100%;">
        <div class="card-body">
            <div class="container mt-5">
                <h2>List of Students</h2>
                <div class="table-responsive">
                    <table class="table table-bordered">
                        <thead>
                            <tr>
                                <th>User ID</th>
                                <th>First Name</th>
                                <th>Last Name</th>
                                <th>Action</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php
                            // Include database connection
                            include_once "config.php";

                            // Fetch students from the User table
                            $sql = "SELECT * FROM User";
                            $result = $conn->query($sql);

                            // Check if there are students
                            if ($result->num_rows > 0) {
                                while ($row = $result->fetch_assoc()) {
                                    // Student data
                                    $user_id = $row['user_id'];
                                    $firstname = $row['firstname'];
                                    $lastname = $row['lastname'];
                            ?>
                                    <tr>
                                        <td><?php echo $user_id; ?></td>
                                        <td><?php echo $firstname; ?></td>
                                        <td><?php echo $lastname; ?></td>
                                        <td>
                                            <!-- Update Button -->
                                            <a href="update_studentform.php?id=<?php echo $user_id; ?>" class="btn btn-primary">Update</a>
                                            <!-- View Products Button (Optional) -->
                                        </td>
                                    </tr>
                            <?php
                                }
                            } else {
                                echo "<tr><td colspan='4'>No Students found.</td></tr>";
                            }

                            // Close database connection
                            $conn->close();
                            ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-ka7Sk0Gln4gmtz2MlQnikT1wXgYsOg+OMhuP+IlRH9sENBO0LRn5q+8nbTov4+1p" crossorigin="anonymous"></script>

  </body>
</html>