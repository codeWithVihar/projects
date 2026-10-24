<?php
session_start();
if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}
include '../db.php';
include 'admin_header.php';

// Fetch all services
$result = mysqli_query($conn, "SELECT * FROM services");
?>

<div class="container py-5">
  <h1 class="text-center text-3xl font-bold text-gray-800 mb-4">
    Manage Car Services 🚗
  </h1>

  <div class="text-end mb-4">
    <a href="add_service.php" class="btn btn-success px-4 py-2 shadow-sm">
      + Add New Car Service
    </a>
  </div>

  <div class="table-responsive shadow-lg rounded-2xl overflow-hidden">
    <table class="table table-hover align-middle mb-0">
      <thead class="table-dark">
        <tr class="text-center">
          <th>Service Name</th>
          <th>Description</th>
          <th>Price</th>
          <th>Image</th>
          <th>Actions</th>
        </tr>
      </thead>
      <tbody class="text-center">
        <?php while ($row = mysqli_fetch_assoc($result)) { ?>
        <tr>
          <td class="fw-semibold"><?php echo htmlspecialchars($row['name']); ?></td>
          <td class="text-truncate" style="max-width: 300px;">
            <?php echo htmlspecialchars($row['description']); ?>
          </td>
          <td class="text-success fw-bold">₹<?php echo htmlspecialchars($row['price']); ?></td>
          <td>
            <img src="../assets/images/<?php echo htmlspecialchars($row['image']); ?>" 
                 class="rounded shadow-sm" width="70" height="70" style="object-fit: cover;">
          </td>
          <td>
            <div class="d-flex gap-2 justify-content-center">
              <a href="edit_service.php?id=<?php echo $row['id']; ?>" 
                 class="btn btn-sm btn-primary px-3">Edit</a>
              <a href="delete_service.php?id=<?php echo $row['id']; ?>" 
                 class="btn btn-sm btn-danger px-3" 
                 onclick="return confirm('Are you sure you want to delete this service?')">
                 Delete
              </a>
            </div>
          </td>
        </tr>
        <?php } ?>
      </tbody>
    </table>
  </div>
</div>

<?php include 'admin_footer.php'; ?>
