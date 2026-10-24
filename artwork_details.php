<?php include 'header.php'; ?>
<?php include 'db/db.php'; ?>

<div class="container py-5">
  <?php
  if (isset($_GET['id'])) {
    $id = intval($_GET['id']);
    $sql = "SELECT * FROM artworks WHERE id = $id";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      $art = $result->fetch_assoc();
      ?>

      <!-- Artwork Details -->
      <div class="row mb-5">
        <div class="col-md-6">
          <img src="assets/images/<?php echo $art['image']; ?>" 
               class="img-fluid rounded shadow" 
               alt="<?php echo htmlspecialchars($art['title']); ?>">
        </div>
        <div class="col-md-6">
          <h2 class="mb-3"><?php echo htmlspecialchars($art['title']); ?></h2>
          <p class="text-muted">by <strong><?php echo htmlspecialchars($art['artist']); ?></strong></p>
          <p><span class="badge bg-secondary"><?php echo htmlspecialchars($art['category']); ?></span></p>
          <h4 class="text-success fw-bold mb-4">₹<?php echo number_format($art['price'], 2); ?></h4>
          
          <!-- Fix for null description -->
          <p class="mb-4">
            <?php 
              if (!empty($art['description'])) {
                echo nl2br(htmlspecialchars($art['description']));
              } else {
                echo "No description available.";
              }
            ?>
          </p>

          <a href="add_to_cart.php?id=<?php echo $art['id']; ?>" class="btn btn-success btn-lg">Buy Now</a>
        </div>
      </div>

      <!-- Related Artworks -->
      <h3 class="mb-4">Related Artworks</h3>
      <div class="row">
        <?php
        $cat = $conn->real_escape_string($art['category']);
        $related = "SELECT * FROM artworks WHERE category='$cat' AND id != $id LIMIT 4";
        $rel_result = $conn->query($related);

        if ($rel_result->num_rows > 0) {
          while ($rel = $rel_result->fetch_assoc()) {
            echo '
            <div class="col-md-3 mb-4">
              <div class="card shadow-sm">
                <img src="assets/images/' . htmlspecialchars($rel['image']) . '" class="card-img-top" alt="' . htmlspecialchars($rel['title']) . '">
                <div class="card-body text-center">
                  <h6 class="card-title">' . htmlspecialchars($rel['title']) . '</h6>
                  <p class="text-success fw-bold">₹' . number_format($rel['price'], 2) . '</p>
                  <a href="artwork_details.php?id=' . $rel['id'] . '" class="btn btn-sm btn-dark w-100">View</a>
                </div>
              </div>
            </div>';
          }
        } else {
          echo "<p>No related artworks found.</p>";
        }
        ?>
      </div>

      <?php
    } else {
      echo "<p class='text-center'>Artwork not found.</p>";
    }
  } else {
    echo "<p class='text-center'>Invalid request.</p>";
  }
  ?>
</div>

<?php include 'footer.php'; ?>
