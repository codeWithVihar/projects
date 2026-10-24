<?php
// admin_header.php
?>
<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="UTF-8">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Admin Panel - Car Service Center</title>

  <!-- Bootstrap CSS -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <!-- Tailwind CDN for optional utility classes -->
  <script src="https://cdn.tailwindcss.com"></script>

  <style>
    body {
      background-color: #f7f7f7;
      padding-top: 70px; /* space for fixed navbar */
    }
    .navbar-brand {
      font-weight: bold;
      font-size: 1.3rem;
      letter-spacing: 0.5px;
    }
    .nav-link {
      font-weight: 500;
      transition: all 0.3s ease;
    }
    .nav-link:hover {
      color: #0d6efd !important; /* Blue hover color */
    }
  </style>
</head>
<body>
  <!-- Navbar -->
  <nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top shadow">
    <div class="container">
      <a class="navbar-brand text-uppercase" href="index.php">
        Car Service Admin
      </a>
      <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#adminNav" aria-controls="adminNav" aria-expanded="false" aria-label="Toggle navigation">
        <span class="navbar-toggler-icon"></span>
      </button>

      <div class="collapse navbar-collapse" id="adminNav">
        <ul class="navbar-nav ms-auto gap-2">
          <li class="nav-item">
            <a class="nav-link px-3" href="index.php">
              <i class="bi bi-speedometer2"></i> Dashboard
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="manage_services.php">
              <i class="bi bi-tools"></i> Services
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="manage_bookings.php">
              <i class="bi bi-calendar-check"></i> Bookings
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="manage_users.php">
              <i class="bi bi-people"></i> Users
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3" href="messages.php">
              <i class="bi bi-envelope"></i> Messages
            </a>
          </li>
          <li class="nav-item">
            <a class="nav-link px-3 text-danger fw-bold" href="../logout.php">
              <i class="bi bi-box-arrow-right"></i> Logout
            </a>
          </li>
        </ul>
      </div>
    </div>
  </nav>

  <div class="container mt-4">
