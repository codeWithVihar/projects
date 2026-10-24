<?php
include 'header.php';
include 'db.php';

$result = mysqli_query($conn, "SELECT * FROM services");
?>

<div class="container py-5">
  <h1 class="text-center text-4xl font-bold mb-5 text-orange-500">Our Services</h1>
  <div class="row g-4">
    <?php while ($row = mysqli_fetch_assoc($result)) { ?>
      <div class="col-md-4">
        <div class="card shadow-sm service-card h-100 border-0">
          <img src="assets/images/<?php echo htmlspecialchars($row['image']); ?>" 
               class="card-img-top" 
               alt="<?php echo htmlspecialchars($row['name']); ?>" 
               style="height:220px; object-fit:cover;">
          <div class="card-body text-center d-flex flex-column">
            <h5 class="card-title font-semibold"><?php echo htmlspecialchars($row['name']); ?></h5>
            <p class="card-text text-gray-600 mb-3"><?php echo htmlspecialchars($row['description']); ?></p>
            <p class="fw-bold mb-3">₹<?php echo htmlspecialchars($row['price']); ?></p>
            <a href="book_service.php?service_id=<?php echo $row['id']; ?>" 
               class="btn btn-primary mt-auto px-4 py-2 shadow hover:shadow-lg">
              Book Now
            </a>
          </div>
        </div>
      </div>
    <?php } ?>
  </div>
</div>

<style>
.service-card {
  border-radius: 1rem;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.service-card:hover {
  transform: translateY(-5px);
  box-shadow: 0 10px 25px rgba(0,0,0,0.15);
}
.btn-primary {
  border-radius: 50px;
  transition: transform 0.3s ease, box-shadow 0.3s ease;
}
.btn-primary:hover {
  transform: translateY(-2px);
  box-shadow: 0 6px 15px rgba(0,0,0,0.2);
}
</style>

<?php include 'footer.php'; ?>
