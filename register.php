<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = mysqli_real_escape_string($conn, $_POST['name']);
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $phone = mysqli_real_escape_string($conn, $_POST['phone']);
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];

    if ($password !== $confirm_password) {
        $error = "Passwords do not match.";
    } else {
        $hashed_password = password_hash($password, PASSWORD_DEFAULT);

        $check = mysqli_query($conn, "SELECT id FROM users WHERE email='$email'");
        if (mysqli_num_rows($check) > 0) {
            $error = "Email already registered.";
        } else {
            $sql = "INSERT INTO users (name, email, phone, password, role) VALUES ('$name', '$email', '$phone', '$hashed_password', 'user')";
            if (mysqli_query($conn, $sql)) {
                $success = "Registration successful! You can now <a href='login.php' class='fw-bold text-decoration-underline'>login</a>.";
            } else {
                $error = "Error: " . mysqli_error($conn);
            }
        }
    }
}

include 'header.php';
?>

<div class="container py-5" style="min-height:80vh;">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm border-0">
        <div class="card-body p-4">
          <h2 class="text-center mb-4 text-orange-500">Register</h2>

          <?php if (!empty($error)) echo "<div class='alert alert-danger'>$error</div>"; ?>
          <?php if (!empty($success)) echo "<div class='alert alert-success'>$success</div>"; ?>

          <form method="POST" class="needs-validation" novalidate>
            <div class="mb-3">
              <label class="form-label">Full Name</label>
              <input type="text" name="name" class="form-control" placeholder="Enter your full name" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control" placeholder="Enter your email" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Phone</label>
              <input type="tel" name="phone" class="form-control" placeholder="Enter your phone number" pattern="[0-9]{10}" required>
              <div class="form-text">Enter 10-digit phone number.</div>
            </div>

            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control" placeholder="Enter your password" minlength="6" required>
            </div>

            <div class="mb-3">
              <label class="form-label">Confirm Password</label>
              <input type="password" name="confirm_password" class="form-control" placeholder="Confirm your password" minlength="6" required>
            </div>

            <button type="submit" class="btn btn-primary w-100 mb-3 shadow-lg hover:shadow-xl">Register</button>
          </form>

          <p class="text-center mb-0">
            Already have an account? 
            <a href="login.php" class="text-primary fw-bold">Login Here</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Optional: Client-side validation -->
<script>
(() => {
  'use strict';
  const forms = document.querySelectorAll('.needs-validation');
  Array.from(forms).forEach(form => {
    form.addEventListener('submit', event => {
      if (!form.checkValidity()) {
        event.preventDefault();
        event.stopPropagation();
      }
      form.classList.add('was-validated');
    }, false);
  });
})();
</script>

<?php include 'footer.php'; ?>
