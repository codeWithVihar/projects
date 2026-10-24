<?php
include 'header.php';
include '../db/db.php';

// Handle order status update
if (isset($_POST['update_status'])) {
    $order_id = intval($_POST['order_id']);
    $status = $conn->real_escape_string($_POST['status']);
    $conn->query("UPDATE orders SET status='$status' WHERE id=$order_id");
    header("Location: manage_orders.php");
}

// Fetch orders with user and artwork details
$sql = "SELECT orders.*, users.username, users.email, artworks.title AS artwork_title, artworks.price AS artwork_price 
        FROM orders 
        JOIN users ON orders.user_id = users.id 
        JOIN artworks ON orders.artwork_id = artworks.id 
        ORDER BY orders.id DESC";
$orders = $conn->query($sql);
?>

<h2 class="mb-4">Manage Orders</h2>

<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>User</th>
        <th>Email</th>
        <th>Artwork</th>
        <th>Quantity</th>
        <th>Price (₹)</th>
        <th>Total (₹)</th>
        <th>Status</th>
        <th>Action</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; while($order = $orders->fetch_assoc()): ?>
        <tr>
          <td><?php echo $i++; ?></td>
          <td><?php echo htmlspecialchars($order['username']); ?></td>
          <td><?php echo htmlspecialchars($order['email']); ?></td>
          <td><?php echo htmlspecialchars($order['artwork_title']); ?></td>
          <td><?php echo $order['quantity']; ?></td>
          <td>₹<?php echo number_format($order['artwork_price'],2); ?></td>
          <td>₹<?php echo number_format($order['total_price'],2); ?></td>
          <td><?php echo ucfirst($order['status']); ?></td>
          <td>
            <form method="POST" class="d-flex">
              <input type="hidden" name="order_id" value="<?php echo $order['id']; ?>">
              <select name="status" class="form-select form-select-sm me-2">
                <option value="pending" <?php if($order['status']=='pending') echo 'selected'; ?>>Pending</option>
                <option value="completed" <?php if($order['status']=='completed') echo 'selected'; ?>>Completed</option>
                <option value="cancelled" <?php if($order['status']=='cancelled') echo 'selected'; ?>>Cancelled</option>
              </select>
              <button type="submit" name="update_status" class="btn btn-sm btn-dark">Update</button>
            </form>
          </td>
        </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>
