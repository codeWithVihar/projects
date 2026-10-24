<?php

include 'header.php';
include 'db/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=checkout.php");
    exit;
}

$user_id = $_SESSION['user_id'];
$cart_items = $_SESSION['cart'] ?? [];

if (empty($cart_items)) {
    echo "<p class='text-center mt-5'>Your cart is empty. <a href='gallery.php'>Browse Artworks</a></p>";
    include 'footer.php';
    exit;
}

// Handle checkout submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $success = true;

    foreach ($cart_items as $artwork_id => $qty) {
        $artwork_id = intval($artwork_id);
        $qty = intval($qty);
        if ($qty < 1) $qty = 1;

        // Fetch artwork price
        $sql = "SELECT price FROM artworks WHERE id=$artwork_id";
        $res = $conn->query($sql);
        if ($res->num_rows > 0) {
            $price = $res->fetch_assoc()['price'];
            $total_price = $price * $qty;

            // Insert into orders
            $insert = $conn->query("INSERT INTO orders (user_id, artwork_id, quantity, total_price) 
                                    VALUES ($user_id, $artwork_id, $qty, $total_price)");
            if (!$insert) $success = false;
        }
    }

    if ($success) {
        // Clear cart after successful order
        unset($_SESSION['cart']);
        echo "<p class='text-center mt-5 text-success'>Your order has been placed successfully! <a href='my_orders.php'>View Orders</a></p>";
    } else {
        echo "<p class='text-center mt-5 text-danger'>Failed to place order. Please try again.</p>";
    }
}
?>

<div class="container py-5">
    <h2 class="text-center mb-4">Checkout</h2>

    <div class="table-responsive mb-4">
        <table class="table table-bordered table-hover">
            <thead class="table-dark">
                <tr>
                    <th>Artwork</th>
                    <th>Image</th>
                    <th>Quantity</th>
                    <th>Price (₹)</th>
                    <th>Total (₹)</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $grand_total = 0;
                foreach ($cart_items as $artwork_id => $qty):
                    $sql = "SELECT * FROM artworks WHERE id=" . intval($artwork_id);
                    $res = $conn->query($sql);
                    if ($res->num_rows > 0):
                        $art = $res->fetch_assoc();
                        $total = $art['price'] * $qty;
                        $grand_total += $total;
                ?>
                <tr>
                    <td><?php echo htmlspecialchars($art['title']); ?></td>
                    <td><img src="assets/images/<?php echo htmlspecialchars($art['image']); ?>" width="80"></td>
                    <td><?php echo $qty; ?></td>
                    <td><?php echo number_format($art['price'], 2); ?></td>
                    <td><?php echo number_format($total, 2); ?></td>
                </tr>
                <?php
                    endif;
                endforeach;
                ?>
                <tr>
                    <td colspan="4" class="text-end fw-bold">Grand Total</td>
                    <td class="fw-bold text-success">₹<?php echo number_format($grand_total, 2); ?></td>
                </tr>
            </tbody>
        </table>
    </div>

    <div class="text-center">
        <form method="POST">
            <button type="submit" class="btn btn-success btn-lg">Place Order</button>
        </form>
    </div>
</div>

<?php include 'footer.php'; ?>
