<?php

include 'header.php';
include 'db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $conn->real_escape_string($_POST['email']);
    $password = md5($_POST['password']); // Consider using password_hash() for real apps

    $sql = "SELECT * FROM users WHERE email='$email' AND password='$password'";
    $result = $conn->query($sql);

    if ($result->num_rows == 1) {
        $user = $result->fetch_assoc();
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['username'] = $user['username'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['role'] = $user['role']; // 'user' or 'admin'

        // Role-based redirection
        if ($user['role'] == 'admin') {
            header("Location: admin/dashboard.php");
            exit;
        } else {
            // Redirect if returning from a page (like buy.php)
            if (!empty($_GET['redirect'])) {
                header("Location: " . $_GET['redirect']);
            } else {
                header("Location: index.php");
            }
            exit;
        }
    } else {
        $error = "Invalid email or password!";
    }
}
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg p-4">
        <h3 class="text-center mb-4">Login</h3>
        <?php if (!empty($error)) echo "<p class='text-danger text-center'>$error</p>"; ?>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-dark w-100">Login</button>
        </form>
        <p class="mt-3 text-center">Don’t have an account? <a href="register.php">Register</a></p>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
