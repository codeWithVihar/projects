<?php
session_start();
include '../db.php';

if (!isset($_SESSION['user_id']) || $_SESSION['user_role'] !== 'admin') {
    header("Location: ../login.php");
    exit;
}

if (!isset($_GET['id'])) {
    header("Location: manage_services.php");
    exit;
}

$service_id = intval($_GET['id']);

// Delete service
mysqli_query($conn, "DELETE FROM services WHERE id=$service_id");
header("Location: manage_services.php");
exit;
