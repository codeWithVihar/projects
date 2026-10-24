<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: login.php?redirect=gallery.php");
    exit;
}

if (isset($_GET['id'])) {
    $artwork_id = intval($_GET['id']);
    $quantity = isset($_GET['quantity']) ? intval($_GET['quantity']) : 1;
    if ($quantity < 1) $quantity = 1;

    // Initialize cart if not exists
    if (!isset($_SESSION['cart'])) {
        $_SESSION['cart'] = [];
    }

    // Add or update cart
    if (isset($_SESSION['cart'][$artwork_id])) {
        $_SESSION['cart'][$artwork_id] += $quantity;
    } else {
        $_SESSION['cart'][$artwork_id] = $quantity;
    }

    header("Location: cart.php");
    exit;
} else {
    header("Location: gallery.php");
    exit;
}
