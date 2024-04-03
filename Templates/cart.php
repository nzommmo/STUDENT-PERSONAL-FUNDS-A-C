<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>View Cart</title>
    <!-- Bootstrap CSS -->
    <link rel="stylesheet" href="../Static/student_dashboard.css">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body id="cartpage">

<div class="container mt-5">
    <h1>Items in Cart</h1>

    <!-- Display success or error messages -->
    <?php
    session_start();
    if (isset($_SESSION['cart_message'])) {
        echo '<div class="alert alert-info" role="alert">' . $_SESSION['cart_message'] . '</div>';
        unset($_SESSION['cart_message']); // Clear the session message
    }
    
    ?>
   

    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                $totalItems = 0;
                $totalAmount = 0;

                // Check if cart session variable is set
                if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    // Loop through cart items
                    foreach ($_SESSION['cart'] as $key => $cartItem) {
                        $totalItems += $cartItem['quantity'];
                        $totalAmount += ($cartItem['item_price'] * $cartItem['quantity']);
                        ?>
                        <tr>
                            <td><?php echo $cartItem['item_name']; ?></td>
                            <td>Ksh <?php echo $cartItem['item_price']; ?></td>
                            <td>
                                <form action="update_cart_quantity.php" method="post">
                                    <input type="number" name="quantity" value="<?php echo $cartItem['quantity']; ?>" min="1">
                                    <input type="hidden" name="key" value="<?php echo $key; ?>">
                                    <button type="submit" class="btn btn-primary">Update</button>
                                </form>
                            </td>
                            <td>
                                <form action="remove_from_cart.php" method="post" style="display: inline;">
                                    <input type="hidden" name="item_id" value="<?php echo $cartItem['item_id']; ?>">
                                    <button type="submit" class="btn btn-danger">Remove</button>
                                </form>
                            </td>
                        </tr>
                        <?php
                    }
                } else {
                    // Cart is empty
                    ?>
                    <tr>
                        <td colspan="4">Cart is empty</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <!-- Total section -->
            <div class="row">
                <div class="col">
                    <p>Total Items: <?php echo $totalItems; ?></p>
                    <p>Total Amount: Ksh <?php echo $totalAmount; ?></p>
                </div>
            </div>
            <!-- Checkout button -->
            <a href="checkout.php" class="btn btn-primary" id="checkoutbtn">Checkout</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>

</body>
</html>
