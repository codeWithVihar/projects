<?php
session_start();
include '../db.php';
include 'admin_header.php';

// Ensure admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Handle status update
if (isset($_POST['update_status'])) {
    $booking_id = intval($_POST['booking_id']);
    $status = mysqli_real_escape_string($conn, $_POST['status']);
    mysqli_query($conn, "UPDATE bookings SET status='$status' WHERE id=$booking_id");
    $success = "Booking status updated successfully!";
}

// Fetch all bookings
$sql = "SELECT b.*, u.name AS user_name, s.name AS service_name 
        FROM bookings b
        JOIN users u ON b.user_id=u.id
        JOIN services s ON b.service_id=s.id
        ORDER BY b.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container py-5">
  <h1 class="mb-4 text-center text-3xl font-bold text-gray-800">
    Manage Car Service Bookings 🚗
  </h1>

  <?php if (!empty($success)) echo "<div class='alert alert-success text-center'>$success</div>"; ?>

  <div class="table-responsive shadow-lg rounded-2xl overflow-hidden">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-dark">
        <tr class="text-center">
          <th>User</th>
          <th>Car Service</th>
          <th>Booking Date</th>
          <th>Status</th>
          <th>Booked On</th>
          <th>Action</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td class="fw-semibold"><?php echo htmlspecialchars($row['user_name']); ?></td>
          <td><?php echo htmlspecialchars($row['service_name']); ?></td>
          <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
          <td>
            <?php 
              if ($row['status'] == 'Pending') echo "<span class='badge bg-warning text-dark px-3 py-2 rounded-pill'>Pending</span>";
              elseif ($row['status'] == 'Approved') echo "<span class='badge bg-success px-3 py-2 rounded-pill'>Approved</span>";
              elseif ($row['status'] == 'Rejected') echo "<span class='badge bg-danger px-3 py-2 rounded-pill'>Rejected</span>";
              else echo "<span class='badge bg-secondary px-3 py-2 rounded-pill'>".$row['status']."</span>";
            ?>
          </td>
          <td><?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
          <td>
            <form method="POST" class="d-flex gap-2 justify-content-center">
              <input type="hidden" name="booking_id" value="<?php echo $row['id']; ?>">
              <select name="status" class="form-select form-select-sm w-auto">
                <option value="Pending" <?php if($row['status']=='Pending') echo 'selected'; ?>>Pending</option>
                <option value="Approved" <?php if($row['status']=='Approved') echo 'selected'; ?>>Approved</option>
                <option value="Rejected" <?php if($row['status']=='Rejected') echo 'selected'; ?>>Rejected</option>
              </select>
              <button type="submit" name="update_status" class="btn btn-sm btn-primary px-3">Update</button>
            </form>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'admin_footer.php'; ?>
