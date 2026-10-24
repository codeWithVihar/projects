<?php
if (session_status() === PHP_SESSION_NONE) {
    session_start();
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Car Service Center</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- FontAwesome for icons -->
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css">

  <!-- Custom CSS -->
  <style>
    body {
      padding-top: 80px;
    }

    /* Navbar links */
    .navbar-nav .nav-link {
      font-weight: 500;
      padding-left: 1rem;
      padding-right: 1rem;
      color: #fff !important;
    }
    .navbar-nav .nav-link:hover {
      color: #ff7f50 !important; /* Orange hover for car theme */
    }

    /* Gradient buttons */
    .btn-login, .btn-logout, .btn-bookings {
      background: linear-gradient(45deg, #ff7f50, #ff4500);
      border: none;
      border-radius: 25px;
      color: #fff;
      font-weight: 500;
    }
    .btn-login:hover, .btn-logout:hover, .btn-bookings:hover {
      opacity: 0.9;
    }

    /* Navbar background */
    .custom-navbar {
      background-color: rgba(33,37,41,0.95);
    }

    .navbar-brand {
      font-size: 1.4rem;
      font-weight: 600;
    }
  </style>
</head>
<body>

<!-- Navbar -->
<nav class="navbar navbar-expand-lg navbar-dark custom-navbar fixed-top shadow-sm">
  <div class="container">
    <a class="navbar-brand" href="index.php"><i class="fas fa-car-side"></i> Car Service Center</a>

    <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarNav">
      <span class="navbar-toggler-icon"></span>
    </button>

    <div class="collapse navbar-collapse" id="navbarNav">
      <ul class="navbar-nav ms-auto align-items-lg-center">
        <li class="nav-item">
          <a class="nav-link" href="index.php">Home</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="services.php">Services</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="about.php">About</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="contact.php">Contact</a>
        </li>
        <li class="nav-item">
          <a class="nav-link" href="my_bookings.php">My Bookings</a>
        </li>

        <?php if (isset($_SESSION['user_id'])): ?>
          <li class="nav-item ms-lg-2">
            <a class="btn btn-logout px-4 py-2" href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
          </li>
        <?php else: ?>
          <li class="nav-item ms-lg-3">
            <a class="btn btn-login px-4 py-2" href="login.php"><i class="fas fa-sign-in-alt"></i> Login</a>
          </li>
        <?php endif; ?>
      </ul>
    </div>
  </div>
</nav>

<!-- Bootstrap JS -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
