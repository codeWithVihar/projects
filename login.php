<?php
include 'db.php';
session_start();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $email = mysqli_real_escape_string($conn, $_POST['email']);
    $password = $_POST['password'];

    $sql = "SELECT * FROM users WHERE email='$email' LIMIT 1";
    $result = mysqli_query($conn, $sql);

    if ($row = mysqli_fetch_assoc($result)) {
        if (password_verify($password, $row['password'])) {
            $_SESSION['user_id'] = $row['id'];
            $_SESSION['user_name'] = $row['name'];
            $_SESSION['user_role'] = $row['role'];

            header($row['role'] === 'admin' ? "Location: admin/index.php" : "Location: index.php");
            exit;
        } else {
            $error = "Invalid password.";
        }
    } else {
        $error = "No account found with that email.";
    }
}

include 'header.php';
?>

<div class="container py-5" style="min-height:80vh;">
  <div class="row justify-content-center">
    <div class="col-md-5">
      <div class="card shadow-lg border-0 rounded-3">
        <div class="card-body p-5">
          <h2 class="text-center mb-4 text-orange-600">Login to Your Account</h2>

          <?php if (!empty($error)): ?>
            <div class="alert alert-danger text-center"><?php echo $error; ?></div>
          <?php endif; ?>

          <form method="POST">
            <div class="mb-3">
              <label class="form-label">Email</label>
              <input type="email" name="email" class="form-control form-control-lg" placeholder="Enter your email" required>
            </div>
            <div class="mb-3">
              <label class="form-label">Password</label>
              <input type="password" name="password" class="form-control form-control-lg" placeholder="Enter your password" required>
            </div>
            <button type="submit" class="btn btn-gradient w-100 py-2 mb-3">Login</button>
          </form>

          <p class="text-center mb-0">
            Don't have an account? 
            <a href="register.php" class="text-orange-600 fw-bold">Register Here</a>
          </p>
        </div>
      </div>
    </div>
  </div>
</div>

<!-- Custom Gradient Button -->
<style>
.btn-gradient {
  background: linear-gradient(45deg, #ff6b00, #ff4500);
  border: none;
  color: #fff;
  font-weight: 600;
  border-radius: 50px;
  transition: transform 0.3s, box-shadow 0.3s;
}
.btn-gradient:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}
</style>

<?php include 'footer.php'; ?>
