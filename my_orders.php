<?php

include 'header.php';
include 'db/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=my_orders.php");
    exit;
}

$user_id = $_SESSION['user_id'];

// Fetch user orders with artwork details
$sql = "SELECT orders.*, artworks.title, artworks.image 
        FROM orders 
        JOIN artworks ON orders.artwork_id = artworks.id 
        WHERE orders.user_id = $user_id
        ORDER BY orders.order_date DESC";

$result = $conn->query($sql);
?>

<div class="container py-5">
  <h2 class="text-center mb-4">My Orders</h2>

  <?php if ($result->num_rows > 0): ?>
    <div class="table-responsive">
      <table class="table table-bordered table-hover">
        <thead class="table-dark">
          <tr>
            <th>#</th>
            <th>Artwork</th>
            <th>Image</th>
            <th>Quantity</th>
            <th>Total Price (₹)</th>
            <th>Order Date</th>
            <th>Status</th>
          </tr>
        </thead>
        <tbody>
          <?php
          $count = 1;
          while ($order = $result->fetch_assoc()):
          ?>
          <tr>
            <td><?php echo $count++; ?></td>
            <td><?php echo htmlspecialchars($order['title']); ?></td>
            <td><img src="assets/images/<?php echo htmlspecialchars($order['image']); ?>" alt="<?php echo htmlspecialchars($order['title']); ?>" width="80"></td>
            <td><?php echo $order['quantity']; ?></td>
            <td><?php echo number_format($order['total_price'], 2); ?></td>
            <td><?php echo date('d-m-Y H:i', strtotime($order['order_date'])); ?></td>
            <td>
              <?php if($order['status'] == 'Pending'): ?>
                <span class="badge bg-warning text-dark">Pending</span>
              <?php else: ?>
                <span class="badge bg-success">Completed</span>
              <?php endif; ?>
            </td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php else: ?>
    <p class="text-center mt-5">You have no orders yet. <a href="gallery.php">Explore Artworks</a></p>
  <?php endif; ?>
</div>

<?php include 'footer.php'; ?>
