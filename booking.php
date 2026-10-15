<?php
// booking.php
require_once 'config/db.php';

$product_id = isset($_GET['product']) ? (int)$_GET['product'] : 0;
$service_id = isset($_GET['service']) ? (int)$_GET['service'] : 0;

// Agar user login nahi hai toh login page pe bhejo
if (!isset($_SESSION['user_id'])) {
    $_SESSION['redirect_after_login'] = "booking.php?product=$product_id&service=$service_id";
    header('Location: login.php');
    exit();
}

// ✅ Product details - Product ID se name fetch karo
$product_name = '';
$product_price = '';

// Products data from detail.php
$products_data = [
    101 => ["name" => "Royal Wedding Package", "price" => "PKR 180,000"],
    102 => ["name" => "Luxury Wedding Planner", "price" => "PKR 250,000"],
    103 => ["name" => "Destination Wedding Planner", "price" => "PKR 450,000"],
    104 => ["name" => "Elite Couple Planning", "price" => "PKR 320,000"],
    105 => ["name" => "Royal Family Package", "price" => "PKR 580,000"],
    106 => ["name" => "Premium VIP Wedding", "price" => "PKR 900,000"],
    201 => ["name" => "Royal Stage Setup", "price" => "PKR 180,000"],
    202 => ["name" => "Luxury Floral Decoration", "price" => "PKR 95,000"],
    203 => ["name" => "Golden Entrance Decoration", "price" => "PKR 120,000"],
    204 => ["name" => "Crystal Theme Decoration", "price" => "PKR 250,000"],
    205 => ["name" => "Luxury Ceiling Decoration", "price" => "PKR 300,000"],
    206 => ["name" => "Complete Palace Decoration", "price" => "PKR 650,000"],
    301 => ["name" => "Wedding Photoshoot", "price" => "PKR 55,000"],
    302 => ["name" => "Drone Coverage", "price" => "PKR 35,000"],
    303 => ["name" => "Cinematic Film", "price" => "PKR 120,000"],
    304 => ["name" => "Pre Wedding Shoot", "price" => "PKR 70,000"],
    305 => ["name" => "Luxury Album", "price" => "PKR 25,000"],
    306 => ["name" => "Complete Premium Package", "price" => "PKR 250,000"],
    401 => ["name" => "Silver Buffet", "price" => "PKR 2,000/head"],
    402 => ["name" => "Gold Buffet", "price" => "PKR 3,500/head"],
    403 => ["name" => "Royal Buffet", "price" => "PKR 5,000/head"],
    404 => ["name" => "VIP Buffet", "price" => "PKR 7,000/head"],
    405 => ["name" => "Dessert Station", "price" => "PKR 1,500/head"],
    406 => ["name" => "Luxury Complete Catering", "price" => "PKR 12,000/head"],
    501 => ["name" => "Live Band", "price" => "PKR 80,000"],
    502 => ["name" => "DJ Night", "price" => "PKR 50,000"],
    503 => ["name" => "Qawwali Night", "price" => "PKR 60,000"],
    504 => ["name" => "Dhol Performance", "price" => "PKR 20,000"],
    505 => ["name" => "Fireworks Show", "price" => "PKR 150,000"],
    506 => ["name" => "Cold Pyro Effects", "price" => "PKR 45,000"],
    601 => ["name" => "Luxury Hall Booking", "price" => "PKR 200,000"],
    602 => ["name" => "Royal Ballroom", "price" => "PKR 400,000"],
    603 => ["name" => "Outdoor Garden", "price" => "PKR 150,000"],
    604 => ["name" => "Palace Theme Venue", "price" => "PKR 350,000"],
    605 => ["name" => "VIP Lounge", "price" => "PKR 100,000"],
    606 => ["name" => "Complete Venue Management", "price" => "PKR 500,000"]
];

if (isset($products_data[$product_id])) {
    $product_name = $products_data[$product_id]['name'];
    $product_price = $products_data[$product_id]['price'];
}

$service_name = '';
$service_names = [
    1 => "Wedding Planning",
    2 => "Décor & Styling",
    3 => "Photography & Films",
    4 => "Catering & Cuisine",
    5 => "Entertainment",
    6 => "Venue Management"
];
if (isset($service_names[$service_id])) {
    $service_name = $service_names[$service_id];
}

// ✅ USER DATA - Sirf default values ke liye
$user_id = $_SESSION['user_id'];
$stmt = $pdo->prepare("SELECT full_name, email, phone FROM users WHERE id = ?");
$stmt->execute([$user_id]);
$user = $stmt->fetch();
$default_name = $user['full_name'] ?? '';
$default_email = $user['email'] ?? '';
$default_phone = $user['phone'] ?? '';

// ✅ Agar form submit hua hai toh old values show karo
$old_name = isset($_SESSION['booking_old_name']) ? $_SESSION['booking_old_name'] : $default_name;
$old_email = isset($_SESSION['booking_old_email']) ? $_SESSION['booking_old_email'] : $default_email;
$old_phone = isset($_SESSION['booking_old_phone']) ? $_SESSION['booking_old_phone'] : $default_phone;
$old_event_date = isset($_SESSION['booking_old_date']) ? $_SESSION['booking_old_date'] : '';
$old_guests = isset($_SESSION['booking_old_guests']) ? $_SESSION['booking_old_guests'] : '';
$old_notes = isset($_SESSION['booking_old_notes']) ? $_SESSION['booking_old_notes'] : '';

// Clear old session data
unset($_SESSION['booking_old_name']);
unset($_SESSION['booking_old_email']);
unset($_SESSION['booking_old_phone']);
unset($_SESSION['booking_old_date']);
unset($_SESSION['booking_old_guests']);
unset($_SESSION['booking_old_notes']);

// Error message
$error = isset($_SESSION['booking_error']) ? $_SESSION['booking_error'] : '';
unset($_SESSION['booking_error']);
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Book Now - Noor-E-Mahal</title>
    <link href="https://fonts.googleapis.com/css2?family=Playfair+Display:wght@400;600;700&family=Poppins:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root { --gold: #d4af37; --gold-light: #f0d77b; --black: #0a0a0a; --white: #ffffff; --gray: #999999; }
        body {
            font-family: 'Poppins', sans-serif;
            background: var(--black);
            color: var(--white);
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            padding: 20px;
        }
        body::before {
            content: "";
            position: fixed;
            inset: 0;
            background: rgba(0,0,0,0.85);
            z-index: -1;
        }
        .booking-container {
            background: rgba(20,20,20,0.8);
            backdrop-filter: blur(15px);
            border: 1px solid rgba(212,175,55,0.2);
            border-radius: 24px;
            padding: 50px 45px;
            max-width: 600px;
            width: 100%;
            box-shadow: 0 30px 80px rgba(0,0,0,0.6);
        }
        .booking-container .icon {
            text-align: center;
            font-size: 48px;
            color: var(--gold);
            margin-bottom: 15px;
        }
        .booking-container h1 {
            font-family: 'Playfair Display', serif;
            font-size: 32px;
            text-align: center;
            color: #fff;
            margin-bottom: 5px;
        }
        .booking-container h1 span { color: var(--gold); }
        .booking-container .subtitle {
            text-align: center;
            color: var(--gray);
            font-size: 14px;
            margin-bottom: 30px;
        }
        .booking-container .product-info {
            background: rgba(212,175,55,0.08);
            border: 1px solid rgba(212,175,55,0.15);
            border-radius: 12px;
            padding: 15px 20px;
            margin-bottom: 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 10px;
        }
        .product-info .p-name {
            color: #fff;
            font-weight: 500;
            font-size: 16px;
        }
        .product-info .p-price {
            color: var(--gold);
            font-weight: 700;
            font-size: 18px;
            font-family: 'Playfair Display', serif;
        }
        .error-msg {
            background: rgba(255,0,0,0.1);
            border: 1px solid rgba(255,0,0,0.2);
            color: #ff6b6b;
            padding: 12px 16px;
            border-radius: 10px;
            margin-bottom: 20px;
            font-size: 14px;
            text-align: center;
        }
        .form-group {
            margin-bottom: 18px;
        }
        .form-group label {
            display: block;
            font-size: 13px;
            font-weight: 500;
            color: #ccc;
            margin-bottom: 6px;
        }
        .form-group label .required {
            color: #ff6b6b;
        }
        .form-group input,
        .form-group textarea,
        .form-group select {
            width: 100%;
            padding: 12px 16px;
            background: rgba(255,255,255,0.05);
            border: 1px solid rgba(255,255,255,0.1);
            border-radius: 10px;
            color: #fff;
            font-size: 14px;
            font-family: 'Poppins', sans-serif;
            transition: all 0.3s;
        }
        .form-group input:focus,
        .form-group textarea:focus,
        .form-group select:focus {
            outline: none;
            border-color: var(--gold);
            box-shadow: 0 0 0 3px rgba(212,175,55,0.15);
        }
        .form-group textarea {
            min-height: 80px;
            resize: vertical;
        }
        .form-group select option {
            background: #1a1a1a;
            color: #fff;
        }
        .form-row {
            display: grid;
            grid-template-columns: 1fr 1fr;
            gap: 15px;
        }
        .btn-submit {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #d4af37, #f0d77b);
            color: #000;
            border: none;
            border-radius: 12px;
            font-size: 18px;
            font-weight: 700;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
        }
        .btn-submit:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(212,175,55,0.3);
        }
        .btn-submit i {
            margin-right: 10px;
        }
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: var(--gray);
            text-decoration: none;
            font-size: 14px;
            transition: 0.3s;
        }
        .back-link a:hover {
            color: var(--gold);
        }
        @media (max-width: 600px) {
            .booking-container { padding: 30px 20px; }
            .form-row { grid-template-columns: 1fr; }
        }
    </style>
</head>
<body>
    <div class="booking-container">
        <div class="icon"><i class="fas fa-calendar-check"></i></div>
        <h1>Book Your <span>Wedding</span></h1>
        <p class="subtitle">Fill in the details to book your dream wedding package</p>

        <?php if ($error): ?>
            <div class="error-msg"><i class="fas fa-exclamation-circle"></i> <?php echo htmlspecialchars($error); ?></div>
        <?php endif; ?>

        <div class="product-info">
            <span class="p-name"><i class="fas fa-gift" style="color:var(--gold);margin-right:8px;"></i> <?php echo htmlspecialchars($product_name ?: 'Selected Package'); ?></span>
            <span class="p-price"><?php echo htmlspecialchars($product_price ?: 'Contact for Price'); ?></span>
        </div>

        <form action="process_booking.php" method="POST">
            <input type="hidden" name="product_id" value="<?php echo $product_id; ?>">
            <input type="hidden" name="service_id" value="<?php echo $service_id; ?>">
            <input type="hidden" name="product_name" value="<?php echo htmlspecialchars($product_name); ?>">
            <input type="hidden" name="product_price" value="<?php echo htmlspecialchars($product_price); ?>">

            <div class="form-group">
                <label>Full Name <span class="required">*</span></label>
                <input type="text" name="full_name" value="<?php echo htmlspecialchars($old_name); ?>" placeholder="Enter your full name" required>
            </div>

            <div class="form-row">
                <div class="form-group">
                    <label>Email <span class="required">*</span></label>
                    <input type="email" name="email" value="<?php echo htmlspecialchars($old_email); ?>" placeholder="Enter your email" required>
                </div>
                <div class="form-group">
                    <label>Phone <span class="required">*</span></label>
                    <input type="tel" name="phone" value="<?php echo htmlspecialchars($old_phone); ?>" placeholder="Enter phone number" required>
                </div>
            </div>

            <div class="form-group">
                <label>Event Date <span class="required">*</span></label>
                <input type="date" name="event_date" value="<?php echo htmlspecialchars($old_event_date); ?>" required>
            </div>

            <div class="form-group">
                <label>Number of Guests</label>
                <input type="number" name="guests" value="<?php echo htmlspecialchars($old_guests); ?>" placeholder="Estimated number of guests" min="1">
            </div>

            <div class="form-group">
                <label>Special Requests / Notes</label>
                <textarea name="notes" placeholder="Any special requests or notes for your wedding..."><?php echo htmlspecialchars($old_notes); ?></textarea>
            </div>

            <button type="submit" class="btn-submit"><i class="fas fa-paper-plane"></i> Confirm Booking</button>
        </form>

        <div class="back-link">
            <a href="javascript:history.back()"><i class="fas fa-arrow-left"></i> Go Back</a>
        </div>
    </div>
</body>
</html>