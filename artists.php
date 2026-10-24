<?php
include 'header.php';
include 'db/db.php';

// Fetch all distinct artists from artworks table
$artists = $conn->query("SELECT artist, COUNT(*) AS artworks_count FROM artworks GROUP BY artist");
?>

<section class="py-5">
  <div class="container">
    <h2 class="text-center mb-5">Meet Our Artists</h2>
    <div class="row g-4">
      <?php if($artists->num_rows > 0): ?>
        <?php while($artist = $artists->fetch_assoc()): ?>
          <div class="col-md-3">
            <div class="card h-100 text-center shadow-sm">
              <div class="card-body d-flex flex-column">
                <img src="assets/images/default-artist.png" class="rounded-circle mb-3" style="width:100px;height:100px;object-fit:cover;" alt="Artist">
                <h5 class="card-title"><?php echo htmlspecialchars($artist['artist']); ?></h5>
                <p class="card-text flex-grow-1">Artworks: <?php echo $artist['artworks_count']; ?></p>
                <a href="gallery.php?artist=<?php echo urlencode($artist['artist']); ?>" class="btn btn-dark mt-auto">View Artworks</a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <p class="text-center">No artists found yet.</p>
      <?php endif; ?>
    </div>
  </div>
</section>

<?php include 'footer.php'; ?>
