<?php

include 'header.php';
include 'db/db.php';

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=cart.php");
    exit;
}

// Handle remove item
if (isset($_GET['remove'])) {
    $remove_id = intval($_GET['remove']);
    unset($_SESSION['cart'][$remove_id]);
    header("Location: cart.php");
    exit;
}

$cart_items = $_SESSION['cart'] ?? [];
?>

<div class="container py-5">
  <h2 class="text-center mb-4">Your Cart</h2>

  <?php if (!empty($cart_items)): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>Artwork</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Price (₹)</th>
            <th>Total (₹)</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $grand_total = 0;
          foreach ($cart_items as $artwork_id => $qty):
            $sql = "SELECT * FROM artworks WHERE id=$artwork_id";
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
            <td><?php echo number_format($art['price'],2); ?></td>
            <td><?php echo number_format($total,2); ?></td>
            <td><a href="cart.php?remove=<?php echo $artwork_id; ?>" class="btn btn-sm btn-danger">Remove</a></td>
          </tr>
          <?php
            endif;
          endforeach;
          ?>
          <tr>
            <td colspan="4" class="text-end fw-bold">Grand Total</td>
            <td colspan="2" class="fw-bold text-success">₹<?php echo number_format($grand_total,2); ?></td>
          </tr>
        </tbody>
      </table>
      <div class="text-end">
        <a href="checkout.php" class="btn btn-success btn-lg">Proceed to Checkout</a>
      </div>
    </div>
  <?php else: ?>
    <p class="text-center mt-5">Your cart is empty. <a href="gallery.php">Browse Artworks</a></p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
