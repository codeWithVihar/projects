<?php
session_start();
include 'header.php';
include 'db/db.php';

// Ensure user is logged in
if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=buy.php?id=" . intval($_GET['id']));
    exit;
}

if (!isset($_GET['id'])) {
    echo "<p class='text-center mt-5'>Invalid request.</p>";
    include 'footer.php';
    exit;
}

$artwork_id = intval($_GET['id']);
$user_id = $_SESSION['user_id'];

// Fetch artwork details
$sql = "SELECT * FROM artworks WHERE id=$artwork_id";
$result = $conn->query($sql);

if ($result->num_rows == 0) {
    echo "<p class='text-center mt-5'>Artwork not found.</p>";
    include 'footer.php';
    exit;
}

$art = $result->fetch_assoc();

// Handle order submission
if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $quantity = intval($_POST['quantity']);
    if ($quantity < 1) $quantity = 1;

    $total_price = $art['price'] * $quantity;

    $insert = $conn->query("INSERT INTO orders (user_id, artwork_id, quantity, total_price) 
                            VALUES ($user_id, $artwork_id, $quantity, $total_price)");

    if ($insert) {
        echo "<p class='text-center mt-5 text-success'>Order placed successfully! <a href='my_orders.php'>View Orders</a></p>";
    } else {
        echo "<p class='text-center mt-5 text-danger'>Failed to place order. Try again.</p>";
    }
}
?>

<div class="container py-5">
  <div class="row justify-content-center">
    <div class="col-md-6">
      <div class="card shadow-sm">
        <img src="assets/images/<?php echo htmlspecialchars($art['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($art['title']); ?>">
        <div class="card-body text-center">
          <h3 class="card-title mb-2"><?php echo htmlspecialchars($art['title']); ?></h3>
          <p class="text-muted mb-2">by <?php echo htmlspecialchars($art['artist']); ?></p>
          <p class="text-success fw-bold mb-3">₹<?php echo number_format($art['price'],2); ?></p>
          <form method="POST">
            <div class="mb-3">
              <label>Quantity</label>
              <input type="number" name="quantity" class="form-control" value="1" min="1">
            </div>
            <button type="submit" class="btn btn-success w-100">Buy Now</button>
          </form>
        </div>
      </div>
    </div>
  </div>
</div>

<?php include 'footer.php'; ?>
