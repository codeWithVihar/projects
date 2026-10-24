<?php 
include 'header.php'; 
include 'db.php';

// Fetch top 3 services for landing page
$services = mysqli_query($conn, "SELECT * FROM services ORDER BY id DESC LIMIT 3");
?>

<!-- Custom CSS -->
<style>
  /* Hero Section */
  .hero-title {
    color: black;
    text-shadow: 0 2px 8px rgba(0,0,0,0.3);
  }
  .hero-subtitle {
    color: gray;
    text-shadow: 0 1px 5px rgba(0,0,0,0.2);
  }

  /* Service Cards */
  .service-card {
    border-radius: 1rem;
    overflow: hidden;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .service-card:hover {
    transform: translateY(-5px);
    box-shadow: 0 10px 25px rgba(0,0,0,0.15);
  }
  .service-card img {
    height: 220px;
    object-fit: cover;
  }

  /* Buttons */
  .btn-primary, .btn-outline-primary, .btn-success {
    border-radius: 50px;
    transition: transform 0.3s ease, box-shadow 0.3s ease;
  }
  .btn-primary:hover, .btn-outline-primary:hover, .btn-success:hover {
    transform: translateY(-2px);
    box-shadow: 0 6px 15px rgba(0,0,0,0.2);
  }

  /* Section Titles */
  .section-title {
    font-weight: 700;
    margin-bottom: 2rem;
    color: #ff4500; /* Car-themed accent color */
  }
</style>

<!-- Hero Section -->
<section class="bg-gradient-to-r from-orange-500 to-red-600 text-white py-20 pt-32 text-center">
  <div class="container">
    <h1 class="text-5xl hero-title font-bold mb-4">Welcome to Our Car Service Center</h1>
    <p class="text-xl hero-subtitle mb-6">Reliable & Affordable Car Servicing – Book your service today!</p>
    <a href="services.php" class="btn btn-lg btn-primary px-6 py-3 shadow-lg hover:shadow-xl">
      View Services
    </a>
  </div>
</section>

<!-- Featured Services Section -->
<section class="py-16 bg-gray-50">
  <div class="container">
    <h2 class="text-4xl text-center section-title">Our Services</h2>
    <div class="row g-4">
      <?php if(mysqli_num_rows($services) > 0): ?>
        <?php while($service = mysqli_fetch_assoc($services)): ?>
          <div class="col-md-4">
            <div class="card service-card shadow-sm">
              <img src="assets/images/<?php echo htmlspecialchars($service['image']); ?>" class="card-img-top" alt="<?php echo htmlspecialchars($service['name']); ?>">
              <div class="card-body text-center">
                <h5 class="card-title font-semibold"><?php echo htmlspecialchars($service['name']); ?></h5>
                <p class="card-text text-gray-600"><?php echo htmlspecialchars($service['description']); ?></p>
                <p class="fw-bold mb-3">₹<?php echo htmlspecialchars($service['price']); ?></p>
                <a href="book_service.php?service_id=<?php echo $service['id']; ?>" class="btn btn-outline-primary mt-3 px-4 py-2">
                  Book Now
                </a>
              </div>
            </div>
          </div>
        <?php endwhile; ?>
      <?php else: ?>
        <div class="col-12">
          <p class="text-center text-gray-500">No services available at the moment.</p>
        </div>
      <?php endif; ?>
    </div>
    <div class="text-center mt-5">
      <a href="services.php" class="btn btn-primary px-6 py-3 shadow hover:shadow-lg">See All Services</a>
    </div>
  </div>
</section>

<!-- About Section -->
<section class="bg-gradient-to-r from-gray-100 to-gray-200 py-16 text-center">
  <div class="container">
    <h2 class="text-4xl section-title">Why Choose Us?</h2>
    <p class="text-lg text-gray-700 mb-6">We provide the best service for your car with affordable pricing and professional expertise.</p>
    <a href="about.php" class="btn btn-primary px-6 py-3 shadow hover:shadow-lg">More About Us</a>
  </div>
</section>

<!-- Contact CTA -->
<section class="py-16 bg-orange-50 text-center">
  <div class="container">
    <h2 class="text-4xl section-title">Need Service?</h2>
    <p class="text-lg text-gray-700 mb-6">Book your car service now and enjoy premium maintenance!</p>
    <a href="contact.php" class="btn btn-success px-6 py-3 shadow hover:shadow-lg">Contact Us</a>
  </div>
</section>

<?php include 'footer.php'; ?>
