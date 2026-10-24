<?php
session_start();
include '../db.php';
include 'admin_header.php';

// Ensure admin is logged in
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

// Handle delete user
if (isset($_GET['delete'])) {
    $user_id = intval($_GET['delete']);
    mysqli_query($conn, "DELETE FROM users WHERE id=$user_id AND role!='admin'");
    $success = "User deleted successfully!";
}

// Fetch all users (excluding admin)
$users = mysqli_query($conn, "SELECT * FROM users WHERE role!='admin' ORDER BY id DESC");
?>

<div class="container py-5">
  <h1 class="text-center text-3xl font-bold text-gray-800 mb-4">
    Manage Users 👥
  </h1>

  <?php if (!empty($success)) echo "<div class='alert alert-success text-center'>$success</div>"; ?>

  <?php if (mysqli_num_rows($users) == 0): ?>
    <div class="alert alert-info text-center shadow-sm rounded-2xl">No users found.</div>
  <?php else: ?>
    <div class="table-responsive shadow-lg rounded-2xl overflow-hidden">
      <table class="table table-hover align-middle mb-0">
        <thead class="table-dark">
          <tr class="text-center">
            <th>ID</th>
            <th>Name</th>
            <th>Email</th>
            <th>Phone</th>
            <th>Registered On</th>
            <th>Action</th>
          </tr>
        </thead>
        <tbody class="text-center">
          <?php while ($row = mysqli_fetch_assoc($users)) { ?>
          <tr>
            <td class="fw-semibold"><?php echo $row['id']; ?></td>
            <td><?php echo htmlspecialchars($row['name']); ?></td>
            <td><?php echo htmlspecialchars($row['email']); ?></td>
            <td><?php echo htmlspecialchars($row['phone']); ?></td>
            <td><?php echo date('d-m-Y H:i', strtotime($row['created_at'])); ?></td>
            <td>
              <div class="d-flex gap-2 justify-content-center">
                <a href="edit_user.php?id=<?php echo $row['id']; ?>" 
                   class="btn btn-sm btn-primary px-3">Edit</a>
                <a href="manage_users.php?delete=<?php echo $row['id']; ?>" 
                   class="btn btn-sm btn-danger px-3" 
                   onclick="return confirm('Are you sure you want to delete this user?');">
                   Delete
                </a>
              </div>
            </td>
          </tr>
          <?php } ?>
        </tbody>
      </table>
    </div>
  <?php endif; ?>
</div>

<?php include 'admin_footer.php'; ?>
