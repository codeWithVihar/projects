<?php
session_start(); // Start session to check login
$currentPage = basename($_SERVER['PHP_SELF']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Online Art Gallery</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Optional: Custom CSS -->
  <style>
    .navbar-nav .nav-link.active {
      font-weight: bold;
      color: #FFD700 !important;
    }
  </style>
</head>
<body>

<nav class="navbar navbar-expand-lg navbar-dark bg-dark shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php">🎨 Art Gallery</a>
    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto">
        <li class="nav-item">
          <a class="nav-link <?php if($currentPage=='index.php') echo 'active'; ?>" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($currentPage=='gallery.php') echo 'active'; ?>" href="gallery.php">Gallery</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($currentPage=='artists.php') echo 'active'; ?>" href="artists.php">Artists</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($currentPage=='cart.php') echo 'active'; ?>" href="cart.php">Cart</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($currentPage=='my_orders.php') echo 'active'; ?>" href="my_orders.php">orders</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($currentPage=='about.php') echo 'active'; ?>" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link <?php if($currentPage=='contact.php') echo 'active'; ?>" href="contact.php">Contact</a>
        </li>


        <?php if(isset($_SESSION['user_id'])): ?>
          <li class="nav-item">
            <a class="nav-link" href="logout.php">Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item">
            <a class="nav-link <?php if($currentPage=='login.php') echo 'active'; ?>" href="login.php">Login</a>
          </li>
        <?php endif; ?>

      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
