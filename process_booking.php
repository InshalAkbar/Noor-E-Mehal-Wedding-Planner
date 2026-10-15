<?php
// process_booking.php
require_once 'config/db.php';

if ($_SERVER['REQUEST_METHOD'] != 'POST') {
    header('Location: index.php');
    exit();
}

// Check if user is logged in
if (!isset($_SESSION['user_id'])) {
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
$product_id = isset($_POST['product_id']) ? (int)$_POST['product_id'] : 0;
$service_id = isset($_POST['service_id']) ? (int)$_POST['service_id'] : 0;
$product_name = isset($_POST['product_name']) ? trim($_POST['product_name']) : '';
$product_price = isset($_POST['product_price']) ? trim($_POST['product_price']) : '';

// USER INPUT
$full_name = isset($_POST['full_name']) ? trim($_POST['full_name']) : '';
$email = isset($_POST['email']) ? trim($_POST['email']) : '';
$phone = isset($_POST['phone']) ? trim($_POST['phone']) : '';
$event_date = isset($_POST['event_date']) ? trim($_POST['event_date']) : '';
$guests = isset($_POST['guests']) ? (int)$_POST['guests'] : 0;
$notes = isset($_POST['notes']) ? trim($_POST['notes']) : '';

// Validation
if (empty($full_name) || empty($email) || empty($phone) || empty($event_date)) {
    $_SESSION['booking_error'] = 'Please fill in all required fields.';
    header("Location: booking.php?product=$product_id&service=$service_id");
    exit();
}

// booking_date column ke liye event_date use kar rahe hain
$booking_date = $event_date;

try {
    $stmt = $pdo->prepare("INSERT INTO bookings 
        (user_id, product_id, service_id, product_name, product_price, 
         full_name, email, phone, event_date, guests, notes, booking_date, status) 
        VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, 'pending')");
    
    $stmt->execute([
        $user_id,
        $product_id,
        $service_id,
        $product_name,
        $product_price,
        $full_name,
        $email,
        $phone,
        $event_date,
        $guests,
        $notes,
        $booking_date
    ]);
    
    $booking_id = $pdo->lastInsertId();
    
    $_SESSION['booking_success'] = true;
    $_SESSION['booking_id'] = $booking_id;
    $_SESSION['booking_product'] = $product_name;
    
    header("Location: booking_success.php");
    exit();
    
} catch (PDOException $e) {
    $_SESSION['booking_error'] = 'Error: ' . $e->getMessage();
    header("Location: booking.php?product=$product_id&service=$service_id");
    exit();
}
?>