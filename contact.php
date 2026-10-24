<?php 
include 'header.php'; 
include 'db/db.php';

$message_sent = false;

// If user is logged in, get their name and email
$user_name = $_SESSION['username'] ?? '';
$user_email = $_SESSION['email'] ?? '';

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $name = $conn->real_escape_string($_POST['name']);
    $email = $conn->real_escape_string($_POST['email']);
    $subject = $conn->real_escape_string($_POST['subject']);
    $message = $conn->real_escape_string($_POST['message']);

    $conn->query("INSERT INTO contact_messages (name, email, subject, message, created_at) 
                  VALUES ('$name', '$email', '$subject', '$message', NOW())");

    $message_sent = true;
}
?>

<div class="container py-5">
  <h2 class="mb-4 text-center">Contact Us</h2>

  <?php if($message_sent): ?>
    <div class="alert alert-success text-center">Your message has been sent successfully!</div>
  <?php endif; ?>

  <form method="POST" class="row g-3">
    <div class="col-md-6">
      <input type="text" name="name" class="form-control" placeholder="Your Name" 
             value="<?php echo htmlspecialchars($user_name); ?>" 
             <?php echo $user_name ? 'readonly' : ''; ?> required>
    </div>
    <div class="col-md-6">
      <input type="email" name="email" class="form-control" placeholder="Your Email" 
             value="<?php echo htmlspecialchars($user_email); ?>" 
             <?php echo $user_email ? 'readonly' : ''; ?> required>
    </div>
    <div class="col-12">
      <input type="text" name="subject" class="form-control" placeholder="Subject" required>
    </div>
    <div class="col-12">
      <textarea name="message" class="form-control" rows="5" placeholder="Your Message" required></textarea>
    </div>
    <div class="col-12 text-center">
      <button type="submit" class="btn btn-primary">Send Message</button>
    </div>
  </form>
</div>

<?php include 'footer.php'; ?>
