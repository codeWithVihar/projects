<?php
session_start();
include 'db/db.php';

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_SESSION['user_id'])) {
    $user_id = $_SESSION['user_id'];
    $artwork_id = (int) $_POST['artwork_id'];
    $fullname = $conn->real_escape_string($_POST['fullname']);
    $email = $conn->real_escape_string($_POST['email']);
    $address = $conn->real_escape_string($_POST['address']);
    $payment_method = $conn->real_escape_string($_POST['payment_method']);

    $sql = "INSERT INTO orders (user_id, artwork_id, fullname, email, address, payment_method, status) 
            VALUES ('$user_id', '$artwork_id', '$fullname', '$email', '$address', '$payment_method', 'Pending')";
    
    if ($conn->query($sql) === TRUE) {
        echo "<div class='container py-12 text-center'>
                <h3>✅ Order Placed Successfully!</h3>
                <p>Your order will be processed soon.</p>
                <a href='gallery.php' class='btn btn-dark mt-3'>Back to Gallery</a>
              </div>";
    } else {
        echo "Error: " . $conn->error;
    }
}
?>
