<?php
session_start();
include 'db.php';
include 'header.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    echo "<div class='container py-5'><div class='alert alert-danger text-center'>Please <a href='login.php'>login</a> to book a service.</div></div>";
    include 'footer.php';
    exit;
}

$user_id = $_SESSION['user_id'];

// Get service details
if (!isset($_GET['service_id'])) {
    echo "<div class='container py-5'><div class='alert alert-danger text-center'>No service selected.</div></div>";
    include 'footer.php';
    exit;
}

$service_id = intval($_GET['service_id']);
$service = mysqli_fetch_assoc(mysqli_query($conn, "SELECT * FROM services WHERE id=$service_id"));

if (!$service) {
    echo "<div class='container py-5'><div class='alert alert-danger text-center'>Service not found.</div></div>";
    include 'footer.php';
    exit;
}

// Handle booking form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $booking_date = mysqli_real_escape_string($conn, $_POST['booking_date']);
    $sql = "INSERT INTO bookings (user_id, service_id, booking_date) VALUES ('$user_id', '$service_id', '$booking_date')";
    if (mysqli_query($conn, $sql)) {
        echo "<div class='container py-5'><div class='alert alert-success text-center'>Your car service has been booked successfully! <a href='my_bookings.php'>View your bookings</a></div></div>";
        include 'footer.php';
        exit;
    } else {
        $error = "Error booking service: " . mysqli_error($conn);
    }
}
?>

<div class="container py-5">
  <h1 class="text-center mb-4 text-orange-600">
    Book Car Service: <?php echo htmlspecialchars($service['name']); ?>
  </h1>

  <?php if (!empty($error)) echo "<div class='alert alert-danger text-center'>$error</div>"; ?>

  <div class="card shadow-lg col-md-6 mx-auto border-0 rounded-3">
    <div class="card-body">
      <div class="text-center mb-4">
        <img src="assets/images/<?php echo htmlspecialchars($service['image']); ?>" class="img-fluid rounded shadow" width="200" alt="Car Service">
      </div>
      <h4 class="card-title text-center text-orange-600 mb-3">
        <?php echo htmlspecialchars($service['name']); ?>
      </h4>
      <p class="card-text text-muted text-center">
        <?php echo htmlspecialchars($service['description']); ?>
      </p>
      <p class="fw-bold text-center">Price: ₹<?php echo htmlspecialchars($service['price']); ?></p>

      <form method="POST" class="mt-4">
        <div class="mb-3">
          <label class="form-label fw-bold">Select Service Date</label>
          <input type="date" name="booking_date" class="form-control shadow-sm" required>
        </div>
        <button type="submit" class="btn btn-success w-100 py-2 shadow-lg">
          Confirm Car Service Booking
        </button>
      </form>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
