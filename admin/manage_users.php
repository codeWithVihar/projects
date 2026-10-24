<?php
include 'header.php';
include '../db/db.php';

// Handle delete user
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $conn->query("DELETE FROM users WHERE id=$id AND role='user'"); // prevent deleting admins
    header("Location: manage_users.php");
}

// Fetch all users (exclude admins)
$users = $conn->query("SELECT * FROM users WHERE role='user' ORDER BY id DESC");
?>

<h2 class="mb-4">Manage Users</h2>

<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Username</th>
        <th>Email</th>
        <th>Registered On</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $i = 1; while ($user = $users->fetch_assoc()): ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo htmlspecialchars($user['username']); ?></td>
        <td><?php echo htmlspecialchars($user['email']); ?></td>
        <td><?php echo date("d M Y", strtotime($user['created_at'])); ?></td>
        <td>
          <a href="?delete=<?php echo $user['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this user?')">Delete</a>
        </td>
      </tr>
      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>
