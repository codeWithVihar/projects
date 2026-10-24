<?php
session_start();
include '../db.php';
include 'admin_header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: manage_services.php");
    exit;
}

$service_id = intval($_GET['id']);
$service = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM services WHERE id=$service_id"));

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);

    // Handle image upload if provided
    if (!empty($_FILES['image']['name'])) {
        $image = $_FILES['image']['name'];
        $tmp_name = $_FILES['image']['tmp_name'];
        move_uploaded_file($tmp_name, "../assets/images/".$image);
        $sql = "UPDATE services SET name='$name', description='$description', price='$price', image='$image' WHERE id=$service_id";
    } else {
        $sql = "UPDATE services SET name='$name', description='$description', price='$price' WHERE id=$service_id";
    }

    if (mysqli_query($conn, $sql)) {
        $success = "Car service updated successfully!";
        $service = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM services WHERE id=$service_id"));
    } else {
        $error = "Error: ".mysqli_error($conn);
    }
}
?>

<div class="container py-5">
  <div class="text-center mb-5">
    <h1 class="text-3xl fw-bold text-primary">Edit Car Service</h1>
    <p class="text-muted">Update details of your car service below</p>
  </div>

  <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

  <div class="card shadow-lg border-0 col-md-8 mx-auto rounded-4">
    <div class="card-body p-4">
      <form method="POST" enctype="multipart/form-data">
        <div class="mb-4">
          <label class="form-label fw-semibold">Car Service Name</label>
          <input type="text" name="name" class="form-control rounded-3 p-3" 
                 value="<?php echo htmlspecialchars($service['name']); ?>" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" class="form-control rounded-3 p-3" rows="4" required><?php echo htmlspecialchars($service['description']); ?></textarea>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Price (₹)</label>
          <input type="number" step="0.01" name="price" class="form-control rounded-3 p-3" 
                 value="<?php echo htmlspecialchars($service['price']); ?>" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Current Image</label><br>
          <img src="../assets/images/<?php echo $service['image']; ?>" 
               class="rounded shadow-sm mt-2" width="150">
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Change Image</label>
          <input type="file" name="image" class="form-control rounded-3 p-3">
        </div>

        <button type="submit" class="btn btn-success w-100 py-3 rounded-3 fw-bold">
          Update Car Service
        </button>
      </form>
    </div>
  </div>
</div>

<?php include 'admin_footer.php'; ?>
