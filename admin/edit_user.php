<?php
session_start();
include '../db.php';
include 'admin_header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: manage_users.php");
    exit;
}

$user_id = intval($_GET['id']);
$user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);

    mysqli_query($conn, "UPDATE users SET name='$name', email='$email', phone='$phone' WHERE id=$user_id");
    $success = "User updated successfully!";
    $user = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM users WHERE id=$user_id"));
}
?>

<div class="container py-5">
  <div class="text-center mb-5">
    <h1 class="text-3xl fw-bold text-primary">Edit User Details</h1>
    <p class="text-muted">Update the user’s information below</p>
  </div>

  <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

  <div class="card shadow-lg border-0 col-md-8 mx-auto rounded-4">
    <div class="card-body p-4">
      <form method="POST">
        <div class="mb-4">
          <label class="form-label fw-semibold">Full Name</label>
          <input type="text" name="name" class="form-control rounded-3 p-3" 
                 value="<?php echo htmlspecialchars($user['name']); ?>" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Email Address</label>
          <input type="email" name="email" class="form-control rounded-3 p-3" 
                 value="<?php echo htmlspecialchars($user['email']); ?>" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Phone Number</label>
          <input type="text" name="phone" class="form-control rounded-3 p-3" 
                 value="<?php echo htmlspecialchars($user['phone']); ?>" required>
        </div>

        <button type="submit" class="btn btn-success w-100 py-3 rounded-3 fw-bold">
          Update User
        </button>
      </form>
    </div>
  </div>
</div>

<?php include 'admin_footer.php'; ?>
