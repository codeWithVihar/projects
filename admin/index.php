<?php
session_start();
include '../db.php';
include 'admin_header.php';

// Ensure admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Fetch counts for dashboard stats
$total_services = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM services"))['count'];
$total_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM bookings"))['count'];
$pending_bookings = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM bookings WHERE status='Pending'"))['count'];
$users_count = mysqli_fetch_assoc(mysqli_query($conn, "SELECT COUNT(*) AS count FROM users"))['count'];
?>

<div class="container mx-auto py-10">
  <h1 class="text-4xl font-bold text-center mb-10 text-blue-700">
    🚗 Car Service Center – Admin Dashboard
  </h1>

  <div class="flex justify-end mb-6">
    <a class="btn btn-danger px-4 py-2" href="logout.php">Logout</a>
  </div>

  <!-- Dashboard Stats -->
  <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-6 mb-10">
    <!-- Total Services -->
    <div class="bg-gradient-to-r from-blue-500 to-blue-700 text-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition transform hover:-translate-y-1">
      <h5 class="text-lg font-semibold mb-2">Total Car Services</h5>
      <p class="text-4xl font-bold mb-4"><?php echo $total_services; ?></p>
      <a href="manage_services.php" class="btn btn-light w-full">Manage Services</a>
    </div>

    <!-- Total Bookings -->
    <div class="bg-gradient-to-r from-green-500 to-green-700 text-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition transform hover:-translate-y-1">
      <h5 class="text-lg font-semibold mb-2">Total Bookings</h5>
      <p class="text-4xl font-bold mb-2"><?php echo $total_bookings; ?></p>
      <p><span class="badge bg-warning text-dark">Pending: <?php echo $pending_bookings; ?></span></p>
      <a href="manage_bookings.php" class="btn btn-light w-full mt-3">Manage Bookings</a>
    </div>

    <!-- Total Users -->
    <div class="bg-gradient-to-r from-purple-500 to-purple-700 text-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition transform hover:-translate-y-1">
      <h5 class="text-lg font-semibold mb-2">Registered Users</h5>
      <p class="text-4xl font-bold mb-4"><?php echo $users_count; ?></p>
      <a href="manage_users.php" class="btn btn-light w-full">View Users</a>
    </div>

    <!-- Add New Service -->
    <div class="bg-gradient-to-r from-orange-500 to-orange-700 text-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition transform hover:-translate-y-1">
      <h5 class="text-lg font-semibold mb-2">Add New Car Service</h5>
      <p class="text-sm opacity-80 mb-4">Quickly add a new car service to your system.</p>
      <a href="add_service.php" class="btn btn-light w-full">Add Service</a>
    </div>
  </div>

  <!-- Messages -->
  <div class="bg-white rounded-2xl shadow-lg p-6 hover:shadow-2xl transition mb-10">
    <h5 class="text-xl font-semibold mb-4">Messages</h5>
    <a href="messages.php" class="btn btn-info w-full">View Messages</a>
  </div>

  <!-- Recent Bookings -->
  <div class="bg-white rounded-2xl shadow-lg p-6">
    <h3 class="text-xl font-bold mb-4">Recent Car Service Bookings</h3>
    <?php
    $recent = mysqli_query($conn, "SELECT b.*, u.name AS user_name, s.name AS service_name 
                                   FROM bookings b
                                   JOIN users u ON b.user_id=u.id
                                   JOIN services s ON b.service_id=s.id
                                   ORDER BY b.created_at DESC LIMIT 5");
    if (mysqli_num_rows($recent) == 0): ?>
      <div class="alert alert-info text-center">No bookings yet.</div>
    <?php else: ?>
      <div class="table-responsive">
        <table class="table table-bordered table-hover table-striped">
          <thead class="table-dark">
            <tr class="text-center">
              <th>User</th>
              <th>Car Service</th>
              <th>Date</th>
              <th>Status</th>
              <th>Booked On</th>
            </tr>
          </thead>
          <tbody class="text-center">
            <?php while ($row = mysqli_fetch_assoc($recent)) { ?>
            <tr>
              <td><?php echo htmlspecialchars($row['user_name']); ?></td>
              <td><?php echo htmlspecialchars($row['service_name']); ?></td>
              <td><?php echo htmlspecialchars($row['booking_date']); ?></td>
              <td>
                <?php 
                  if ($row['status'] == 'Pending') echo "<span class='badge bg-warning text-dark'>Pending</span>";
                  elseif ($row['status'] == 'Approved') echo "<span class='badge bg-success'>Approved</span>";
                  elseif ($row['status'] == 'Rejected') echo "<span class='badge bg-danger'>Rejected</span>";
                  else echo "<span class='badge bg-secondary'>".$row['status']."</span>";
                ?>
              </td>
              <td><?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
            </tr>
            <?php } ?>
          </tbody>
        </table>
      </div>
    <?php endif; ?>
  </div>
</div>

<?php include 'admin_footer.php'; ?>
