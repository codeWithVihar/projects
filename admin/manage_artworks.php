<?php
include 'header.php';
include '../db/db.php';

// Folder for images
$target_dir = "../assets/images/";
if (!file_exists($target_dir)) {
    mkdir($target_dir, 0777, true); // create folder if not exists
}

// ---------------------- ADD ARTWORK ----------------------
if (isset($_POST['add_artwork'])) {
    $title = $conn->real_escape_string($_POST['title']);
    $artist = $conn->real_escape_string($_POST['artist']);
    $category = $conn->real_escape_string($_POST['category']);
    $price = floatval($_POST['price']);
    $description = $conn->real_escape_string($_POST['description'] ?? '');

    $image_name = "";
    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = time() . '.' . $ext;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image_name)) {
            die("Failed to upload image. Check folder permissions.");
        }
    }

    $conn->query("INSERT INTO artworks (title, artist, category, price, image, description, created_at) 
                  VALUES ('$title', '$artist', '$category', $price, '$image_name', '$description', NOW())");
    header("Location: manage_artworks.php");
    exit;
}

// ---------------------- DELETE ARTWORK ----------------------
if (isset($_GET['delete'])) {
    $id = intval($_GET['delete']);
    $art = $conn->query("SELECT image FROM artworks WHERE id=$id")->fetch_assoc();
    if ($art['image'] != "" && file_exists($target_dir . $art['image'])) {
        unlink($target_dir . $art['image']);
    }
    $conn->query("DELETE FROM artworks WHERE id=$id");
    header("Location: manage_artworks.php");
    exit;
}

// ---------------------- EDIT ARTWORK ----------------------
if (isset($_POST['edit_artwork'])) {
    $id = intval($_POST['id']);
    $title = $conn->real_escape_string($_POST['title']);
    $artist = $conn->real_escape_string($_POST['artist']);
    $category = $conn->real_escape_string($_POST['category']);
    $price = floatval($_POST['price']);
    $description = $conn->real_escape_string($_POST['description'] ?? '');

    if (isset($_FILES['image']) && $_FILES['image']['error'] == 0) {
        $ext = pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION);
        $image_name = time() . '.' . $ext;
        if (!move_uploaded_file($_FILES['image']['tmp_name'], $target_dir . $image_name)) {
            die("Failed to upload new image.");
        }
        // Delete old image
        $old = $conn->query("SELECT image FROM artworks WHERE id=$id")->fetch_assoc();
        if ($old['image'] != "" && file_exists($target_dir . $old['image'])) {
            unlink($target_dir . $old['image']);
        }
        $conn->query("UPDATE artworks SET title='$title', artist='$artist', category='$category', price=$price, description='$description', image='$image_name' WHERE id=$id");
    } else {
        $conn->query("UPDATE artworks SET title='$title', artist='$artist', category='$category', price=$price, description='$description' WHERE id=$id");
    }

    header("Location: manage_artworks.php");
    exit;
}

// Fetch artworks
$artworks = $conn->query("SELECT * FROM artworks ORDER BY created_at DESC");
?>

<h2 class="mb-4">Manage Artworks</h2>

<!-- Add Artwork Form -->
<div class="card mb-4 shadow-sm">
  <div class="card-body">
    <h5 class="card-title">Add New Artwork</h5>
    <form method="POST" enctype="multipart/form-data" class="row g-3">
      <div class="col-md-3">
        <input type="text" name="title" class="form-control" placeholder="Title" required>
      </div>
      <div class="col-md-3">
        <input type="text" name="artist" class="form-control" placeholder="Artist" required>
      </div>
      <div class="col-md-2">
        <select name="category" class="form-control" required>
          <option value="">Select Category</option>
          <option value="Painting">Painting</option>
          <option value="Sculpture">Sculpture</option>
          <option value="Digital Art">Digital Art</option>
          <option value="Photography">Photography</option>
        </select>
      </div>
      <div class="col-md-2">
        <input type="number" step="0.01" name="price" class="form-control" placeholder="Price" required>
      </div>
      <div class="col-md-2">
        <input type="file" name="image" class="form-control" required>
      </div>
      <div class="col-12">
        <textarea name="description" class="form-control" placeholder="Description (optional)" rows="2"></textarea>
      </div>
      <div class="col-12 text-end">
        <button type="submit" name="add_artwork" class="btn btn-dark">Add Artwork</button>
      </div>
    </form>
  </div>
</div>

<!-- Artworks Table -->
<div class="table-responsive">
  <table class="table table-bordered table-hover">
    <thead class="table-dark">
      <tr>
        <th>#</th>
        <th>Title</th>
        <th>Artist</th>
        <th>Category</th>
        <th>Price (₹)</th>
        <th>Image</th>
        <th>Description</th>
        <th>Actions</th>
      </tr>
    </thead>
    <tbody>
      <?php $i=1; while($art = $artworks->fetch_assoc()): ?>
      <tr>
        <td><?php echo $i++; ?></td>
        <td><?php echo htmlspecialchars($art['title'] ?? ''); ?></td>
        <td><?php echo htmlspecialchars($art['artist'] ?? ''); ?></td>
        <td><?php echo htmlspecialchars($art['category'] ?? ''); ?></td>
        <td>₹<?php echo number_format($art['price'] ?? 0,2); ?></td>
        <td>
          <?php if($art['image'] && file_exists($target_dir . $art['image'])): ?>
            <img src="../assets/images/<?php echo $art['image']; ?>" width="80">
          <?php endif; ?>
        </td>
        <td><?php echo htmlspecialchars($art['description'] ?? ''); ?></td>
        <td>
          <button class="btn btn-sm btn-primary" data-bs-toggle="modal" data-bs-target="#editModal<?php echo $art['id']; ?>">Edit</button>
          <a href="?delete=<?php echo $art['id']; ?>" class="btn btn-sm btn-danger" onclick="return confirm('Delete this artwork?')">Delete</a>
        </td>
      </tr>

      <!-- Edit Modal -->
      <div class="modal fade" id="editModal<?php echo $art['id']; ?>" tabindex="-1">
        <div class="modal-dialog">
          <div class="modal-content">
            <form method="POST" enctype="multipart/form-data">
              <div class="modal-header">
                <h5 class="modal-title">Edit Artwork</h5>
                <button type="button" class="btn-close" data-bs-dismiss="modal"></button>
              </div>
              <div class="modal-body">
                <input type="hidden" name="id" value="<?php echo $art['id']; ?>">
                <div class="mb-3">
                  <label>Title</label>
                  <input type="text" name="title" class="form-control" value="<?php echo htmlspecialchars($art['title'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                  <label>Artist</label>
                  <input type="text" name="artist" class="form-control" value="<?php echo htmlspecialchars($art['artist'] ?? ''); ?>" required>
                </div>
                <div class="mb-3">
                  <label>Category</label>
                  <select name="category" class="form-control" required>
                    <option value="">Select Category</option>
                    <option value="Painting" <?php if(($art['category'] ?? '')=='Painting') echo 'selected'; ?>>Painting</option>
                    <option value="Sculpture" <?php if(($art['category'] ?? '')=='Sculpture') echo 'selected'; ?>>Sculpture</option>
                    <option value="Digital Art" <?php if(($art['category'] ?? '')=='Digital Art') echo 'selected'; ?>>Digital Art</option>
                    <option value="Photography" <?php if(($art['category'] ?? '')=='Photography') echo 'selected'; ?>>Photography</option>
                  </select>
                </div>
                <div class="mb-3">
                  <label>Price</label>
                  <input type="number" step="0.01" name="price" class="form-control" value="<?php echo $art['price'] ?? 0; ?>" required>
                </div>
                <div class="mb-3">
                  <label>Description</label>
                  <textarea name="description" class="form-control" rows="2"><?php echo htmlspecialchars($art['description'] ?? ''); ?></textarea>
                </div>
                <div class="mb-3">
                  <label>Image (optional)</label>
                  <input type="file" name="image" class="form-control">
                </div>
              </div>
              <div class="modal-footer">
                <button type="submit" name="edit_artwork" class="btn btn-dark">Save Changes</button>
              </div>
            </form>
          </div>
        </div>
      </div>

      <?php endwhile; ?>
    </tbody>
  </table>
</div>

<?php include 'footer.php'; ?>
