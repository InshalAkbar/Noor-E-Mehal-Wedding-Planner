<?php
// admin/delete_book_services.php - Updated to handle both services and bookings
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$type = isset($_GET['type']) ? $_GET['type'] : 'service';

if ($id > 0) {
    if ($type == 'booking') {
        $stmt = $pdo->prepare("DELETE FROM bookings WHERE id = ?");
    } else {
        $stmt = $pdo->prepare("DELETE FROM services WHERE id = ?");
    }
    $stmt->execute([$id]);
}

header('Location: index.php#' . ($type == 'booking' ? 'bookings' : 'services'));
exit();
?>