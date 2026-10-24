<?php include 'header.php'; ?>
<?php include 'db/db.php'; ?>

<!-- Hero Section -->
<section class="bg-dark text-white py-5 text-center">
  <div class="container">
    <h1 class="display-4 fw-bold mb-3">Discover & Buy Original Artworks</h1>
    <p class="lead mb-4">Connecting artists and collectors worldwide</p>
    <a href="gallery.php" class="btn btn-light btn-lg rounded-pill">🎨 Explore Gallery</a>
  </div>
</section>

<!-- Featured Artworks -->
<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-5 fw-bold">Featured Artworks</h2>
    <div class="row g-4">
      <?php
      $sql = "SELECT * FROM artworks ORDER BY created_at DESC LIMIT 6";
      $result = $conn->query($sql);

      if ($result->num_rows > 0) {
          while ($row = $result->fetch_assoc()) {
              echo '
              <div class="col-md-4">
                <div class="card h-100 shadow-sm border-0">
                  <img src="assets/images/' . $row['image'] . '" class="card-img-top" alt="' . $row['title'] . '">
                  <div class="card-body text-center">
                    <h5 class="card-title fw-bold">' . $row['title'] . '</h5>
                    <p class="text-muted mb-2">by ' . $row['artist'] . '</p>
                    <p class="fs-5 fw-semibold text-success">₹' . number_format($row['price'], 2) . '</p>
                    <a href="artwork_details.php?id=' . $row['id'] . '" class="btn btn-outline-dark w-100 mb-2">View Details</a>
                    <a href="add_to_cart.php?id=' . $row['id'] . '" class="btn btn-success w-100">Buy Now</a>
                  </div>
                </div>
              </div>';
          }
      } else {
          echo "<p class='text-center'>No artworks available right now.</p>";
      }
      ?>
    </div>
  </div>
</section>

<!-- Categories -->
<section class="py-5 bg-light">
  <div class="container text-center">
    <h2 class="fw-bold mb-5">Browse by Categories</h2>
    <div class="row g-4">
      <div class="col-6 col-md-3">
        <div class="p-4 bg-white shadow-sm rounded">🖌️ Paintings</div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-4 bg-white shadow-sm rounded">🗿 Sculptures</div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-4 bg-white shadow-sm rounded">💻 Digital Art</div>
      </div>
      <div class="col-6 col-md-3">
        <div class="p-4 bg-white shadow-sm rounded">📸 Photography</div>
      </div>
    </div>
  </div>
</section>

<!-- Call to Action -->
<section class="py-5 text-center">
  <div class="container">
    <h2 class="display-6 fw-bold mb-3">Join Our Community</h2>
    <p class="lead mb-4">Become a part of our growing network of artists and art lovers.</p>
    <a href="register.php" class="btn btn-primary btn-lg rounded-pill">Sign Up Now</a>
  </div>
</section>

<?php include 'footer.php'; ?>
