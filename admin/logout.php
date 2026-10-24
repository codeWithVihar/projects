<?php
session_start();

// Destroy all session data
session_unset();
session_destroy();

// Redirect to user landing page
header("Location: ../index.php"); // Adjust path if needed
exit;
?>
