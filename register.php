<?php

include 'header.php';
include 'db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $username = $conn->real_escape_string($_POST['username']);
    $email = $conn->real_escape_string($_POST['email']);
    $password = md5($_POST['password']); // 🔐 Use password_hash() in real projects

    // Check if email already exists
    $check = $conn->query("SELECT id FROM users WHERE email='$email'");
    if ($check->num_rows > 0) {
        $error = "Email already registered!";
    } else {
        $sql = "INSERT INTO users (username, email, password) 
                VALUES ('$username', '$email', '$password')";
        if ($conn->query($sql)) {
            $_SESSION['user_id'] = $conn->insert_id;
            $_SESSION['username'] = $username;
            $_SESSION['email'] = $email;
            $_SESSION['role'] = "user";
            header("Location: index.php");
            exit;
        } else {
            $error = "Registration failed!";
        }
    }
}
?>

<div class="container py-12">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-lg p-4">
        <h3 class="text-center mb-4">Register</h3>
        <?php if (!empty($error)) echo "<p class='text-danger text-center'>$error</p>"; ?>
        <form method="POST">
          <div class="mb-3">
            <label class="form-label">Username</label>
            <input type="text" name="username" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Email</label>
            <input type="email" name="email" class="form-control" required>
          </div>
          <div class="mb-3">
            <label class="form-label">Password</label>
            <input type="password" name="password" class="form-control" required>
          </div>
          <button type="submit" class="btn btn-success w-100">Register</button>
        </form>
        <p class="mt-3 text-center">Already have an account? <a href="login.php">Login</a></p>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
