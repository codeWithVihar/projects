<?php
session_start();
include 'db.php';
include 'header.php';

if (!isset($_SESSION['user_id'])) {
    echo "<div class='container py-5'><div class='alert alert-danger text-center'>Please <a href='login.php'>login</a> to view your bookings.</div></div>";
    include 'footer.php';
    exit;
}

$user_id = $_SESSION['user_id'];

$sql = "SELECT b.*, s.name AS service_name 
        FROM bookings b
        JOIN services s ON b.service_id = s.id
        WHERE b.user_id = $user_id
        ORDER BY b.created_at DESC";
$result = mysqli_query($conn, $sql);
?>

<div class="container py-5">
  <h1 class="text-center mb-5 text-orange-500">My Bookings</h1>

  <?php if (mysqli_num_rows($result) == 0): ?>
    <div class="alert alert-info text-center">
      You have not booked any services yet. <a href="services.php" class="fw-bold text-decoration-underline">Book a service now</a>.
    </div>
  <?php else: ?>
    <div class="table-responsive shadow rounded">
      <table class="table table-bordered table-hover align-middle text-center">
        <thead class="table-dark">
          <tr>
            <th>Service</th>
            <th>Booking Date</th>
            <th>Status</th>
            <th>Booked On</th>
          </tr>
        </thead>
        <tbody>
          <?php while ($row = mysqli_fetch_assoc($result)): ?>
          <tr>
            <td><?php echo htmlspecialchars($row['service_name']); ?></td>
            <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
            <td>
              <?php 
                switch ($row['status']) {
                    case 'Pending':
                        echo "<span class='badge bg-warning text-dark'>Pending</span>";
                        break;
                    case 'Approved':
                        echo "<span class='badge bg-success'>Approved</span>";
                        break;
                    case 'Rejected':
                        echo "<span class='badge bg-danger'>Rejected</span>";
                        break;
                    default:
                        echo "<span class='badge bg-secondary'>".$row['status']."</span>";
                }
              ?>
            </td>
            <td><?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
          </tr>
          <?php endwhile; ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<!-- Optional: Custom table hover effect -->
<style>
.table-hover tbody tr:hover {
  background-color: #fff3e0;
  transition: background-color 0.3s;
}
</style>

<?php include 'footer.php'; ?>
