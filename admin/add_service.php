<?php
session_start();
include '../db.php';
include 'admin_header.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $description = mysqli_real_escape_string($conn, $_POST['description']);
    $price = floatval($_POST['price']);

    // Handle image upload
    $image = $_FILES['image']['name'];
    $tmp_name = $_FILES['image']['tmp_name'];
    $target_dir = "../assets/images/";
    move_uploaded_file($tmp_name, $target_dir.$image);

    $sql = "INSERT INTO services (name, description, price, image) VALUES ('$name','$description','$price','$image')";
    if (mysqli_query($conn, $sql)) {
        $success = "Car service added successfully!";
    } else {
        $error = "Error: ".mysqli_error($conn);
    }
}
?>

<div class="container py-5">
  <div class="text-center mb-5">
    <h1 class="text-3xl fw-bold text-primary">Add New Car Service</h1>
    <p class="text-muted">Add details of the car service you provide</p>
  </div>

  <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
  <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

  <div class="card shadow-lg border-0 col-md-8 mx-auto rounded-4">
    <div class="card-body p-4">
      <form method="POST" enctype="multipart/form-data" class="space-y-4">
        <div class="mb-4">
          <label class="form-label fw-semibold">Car Service Name</label>
          <input type="text" name="name" class="form-control rounded-3 p-3" placeholder="e.g. Full Car Wash" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Description</label>
          <textarea name="description" class="form-control rounded-3 p-3" rows="4" placeholder="Describe the car service..." required></textarea>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Price (₹)</label>
          <input type="number" step="0.01" name="price" class="form-control rounded-3 p-3" placeholder="Enter price" required>
        </div>

        <div class="mb-4">
          <label class="form-label fw-semibold">Upload Service Image</label>
          <input type="file" name="image" class="form-control rounded-3 p-3" required>
        </div>

        <button type="submit" class="btn btn-success w-100 py-3 rounded-3 fw-bold">
          Add Car Service
        </button>
      </form>
    </div>
  </div>
</div>

<?php include 'admin_footer.php'; ?>
