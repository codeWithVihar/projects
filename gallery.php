<?php include 'header.php'; ?>
<?php include 'db/db.php'; ?>

<div class="container py-5">
  <h2 class="text-center mb-4">Art Gallery</h2>

  <!-- Search & Filters -->
  <form method="GET" class="row mb-4">
    <div class="col-md-4">
      <input type="text" name="search" class="form-control" placeholder="Search by title or artist">
    </div>
    <div class="col-md-3">
      <select name="category" class="form-select">
        <option value="">All Categories</option>
        <option value="Paintings">Paintings</option>
        <option value="Sculptures">Sculptures</option>
        <option value="Digital Art">Digital Art</option>
        <option value="Photography">Photography</option>
      </select>
    </div>
    <div class="col-md-3">
      <select name="sort" class="form-select">
        <option value="">Sort By</option>
        <option value="newest">Newest</option>
        <option value="price_low">Price: Low to High</option>
        <option value="price_high">Price: High to Low</option>
      </select>
    </div>
    <div class="col-md-2">
      <button type="submit" class="btn btn-dark w-100">Apply</button>
    </div>
  </form>

  <!-- Artwork Grid -->
  <div class="row">
    <?php
    $where = "1=1";
    if (!empty($_GET['search'])) {
      $search = $conn->real_escape_string($_GET['search']);
      $where .= " AND (title LIKE '%$search%' OR artist LIKE '%$search%')";
    }
    if (!empty($_GET['category'])) {
      $category = $conn->real_escape_string($_GET['category']);
      $where .= " AND category = '$category'";
    }

    $order = "ORDER BY created_at DESC";
    if (!empty($_GET['sort'])) {
      if ($_GET['sort'] == "price_low") $order = "ORDER BY price ASC";
      elseif ($_GET['sort'] == "price_high") $order = "ORDER BY price DESC";
      elseif ($_GET['sort'] == "newest") $order = "ORDER BY created_at DESC";
    }

    $sql = "SELECT * FROM artworks WHERE $where $order";
    $result = $conn->query($sql);

    if ($result->num_rows > 0) {
      while ($row = $result->fetch_assoc()) {
        echo '
        <div class="col-md-3 mb-4">
          <div class="card shadow-sm">
            <img src="assets/images/' . $row['image'] . '" class="card-img-top" alt="' . $row['title'] . '">
            <div class="card-body text-center">
              <h5 class="card-title">' . $row['title'] . '</h5>
              <p class="text-muted mb-1">by ' . $row['artist'] . '</p>
              <p class="fw-bold text-success">₹' . number_format($row['price'], 2) . '</p>
              <a href="artwork_details.php?id=' . $row['id'] . '" class="btn btn-sm btn-primary w-100 mb-2">View</a>
              <a href="add_to_cart.php?id=' . $row['id'] . '" class="btn btn-sm btn-success w-100">Buy Now</a>
            </div>
          </div>
        </div>';
      }
    } else {
      echo "<p class='text-center'>No artworks found.</p>";
    }
    ?>
  </div>
</div>

<?php include 'footer.php'; ?>
