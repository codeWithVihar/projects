<?php include 'header.php'; ?>
<h2 class="mb-4">Welcome, Admin 👋</h2>

<div class="row g-4"> <!-- Added gap between cards -->

  <div class="col-md-3">
    <div class="card text-center shadow-sm h-100">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">Manage Artworks</h5>
        <p class="card-text flex-grow-1">Add, edit, or delete artworks.</p>
        <a href="manage_artworks.php" class="btn btn-dark mt-auto">Go</a>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card text-center shadow-sm h-100">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">Manage Orders</h5>
        <p class="card-text flex-grow-1">View and update customer orders.</p>
        <a href="manage_orders.php" class="btn btn-dark mt-auto">Go</a>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card text-center shadow-sm h-100">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">Manage Users</h5>
        <p class="card-text flex-grow-1">View all registered users.</p>
        <a href="manage_users.php" class="btn btn-dark mt-auto">Go</a>
      </div>
    </div>
  </div>

  <div class="col-md-3">
    <div class="card text-center shadow-sm h-100">
      <div class="card-body d-flex flex-column">
        <h5 class="card-title">Manage Messages</h5>
        <p class="card-text flex-grow-1">View all messages.</p>
        <a href="manage_messages.php" class="btn btn-dark mt-auto">Go</a>
      </div>
    </div>
  </div>

</div>

<?php include 'footer.php'; ?>
