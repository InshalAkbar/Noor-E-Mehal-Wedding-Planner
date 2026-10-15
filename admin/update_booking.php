<?php
// admin/update_booking.php
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $booking_id = (int)$_POST['booking_id'];
    $status = $_POST['status'];
    
    $allowed = ['pending', 'confirmed', 'completed', 'cancelled'];
    if (in_array($status, $allowed)) {
        $stmt = $pdo->prepare("UPDATE bookings SET status = ? WHERE id = ?");
        $stmt->execute([$status, $booking_id]);
    }
}

header('Location: index.php#bookings');
exit();
?>