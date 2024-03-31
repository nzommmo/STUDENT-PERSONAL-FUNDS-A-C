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
    <div class="row">
        <div class="col">
            <table class="table">
                <thead>
                <tr>
                    <th>Item Name</th>
                    <th>Price</th>
                    <th>Action</th>
                </tr>
                </thead>
                <tbody>
                <?php
                session_start();

                // Check if cart session variable is set
                if(isset($_SESSION['cart']) && !empty($_SESSION['cart'])) {
                    // Loop through cart items
                    foreach ($_SESSION['cart'] as $cartItem) {
                        ?>
                        <tr>
                            <td><?php echo $cartItem['item_name']; ?></td>
                            <td>Ksh <?php echo $cartItem['item_price']; ?></td>
                            <td>
                                <form action="remove_from_cart.php" method="post">
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
                        <td colspan="3">Cart is empty</td>
                    </tr>
                    <?php
                }
                ?>
                </tbody>
            </table>
            <!-- Checkout button -->
            <a href="checkout.php" class="btn btn-primary" id="checkoutbtn">Checkout</a>
        </div>
    </div>
</div>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
