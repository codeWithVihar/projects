<?php
include 'header.php';
include 'db.php';

$success = '';
$error = '';

// Get logged-in user info (if any)
$user_name = '';
$user_email = '';
if (isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $user_query = mysqli_query($conn, "SELECT name, email FROM users WHERE id='$user_id' LIMIT 1");
    if ($row = mysqli_fetch_assoc($user_query)) {
        $user_name = $row['name'];
        $user_email = $row['email'];
    }
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $message = mysqli_real_escape_string($conn, $_POST['message']);

    if (!empty($name) && !empty($email) && !empty($message)) {
        $sql = "INSERT INTO contacts (name, email, message) VALUES ('$name', '$email', '$message')";
        if (mysqli_query($conn, $sql)) {
            $success = "Thank you! Your message has been sent successfully.";
        } else {
            $error = "Something went wrong. Please try again later.";
        }
    } else {
        $error = "All fields are required.";
    }
}
?>

<!-- Contact Section -->
<section class="py-5 bg-gray-50">
  <div class="container">
    <h1 class="text-4xl font-bold text-center mb-3 text-orange-600">Contact Car Service Center</h1>
    <p class="text-center text-gray-700 mb-5">
      Have a question about our car services or want to book a slot? We’d love to hear from you.
    </p>

    <?php if ($success) echo "<div class='alert alert-success text-center'>$success</div>"; ?>
    <?php if ($error) echo "<div class='alert alert-danger text-center'>$error</div>"; ?>

    <div class="row justify-content-center">
      <div class="col-md-8">
        <form method="POST" class="shadow-lg p-4 rounded-3 bg-white">
          <div class="mb-3">
            <label class="form-label fw-bold">Your Name</label>
            <input type="text" name="name" class="form-control shadow-sm" 
              required value="<?php echo htmlspecialchars($user_name); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Your Email</label>
            <input type="email" name="email" class="form-control shadow-sm" 
              required value="<?php echo htmlspecialchars($user_email); ?>">
          </div>
          <div class="mb-3">
            <label class="form-label fw-bold">Message</label>
            <textarea name="message" class="form-control shadow-sm" rows="5" 
              placeholder="Write your message here..." required></textarea>
          </div>
          <button type="submit" 
            class="btn btn-success w-100 py-2 shadow hover:shadow-lg transition">
            Send Message
          </button>
        </form>
      </div>
    </div>
  </div>
</section>

<!-- Optional: Contact Info / Map -->
<section class="py-5 bg-white">
  <div class="container text-center">
    <h2 class="text-2xl font-bold mb-3 text-orange-600">Visit Our Service Center</h2>
    <p class="text-gray-600 mb-4">123 Main Street, Your City, India</p>
    <p class="text-gray-600">Phone: +91 98765 43210 | Email: support@carservicecenter.com</p>
  </div>
</section>

<?php include 'footer.php'; ?>
