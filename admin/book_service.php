<?php
// admin/book_service.php
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';

// Get users, services, events
$users = $pdo->query("SELECT id, full_name FROM users ORDER BY full_name")->fetchAll();
$services = $pdo->query("SELECT id, service_name, price FROM services WHERE status = 'active' ORDER BY service_name")->fetchAll();
$events = $pdo->query("SELECT id, event_name FROM events ORDER BY event_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = (int)$_POST['user_id'];
    $service_id = (int)$_POST['service_id'];
    $event_id = !empty($_POST['event_id']) ? (int)$_POST['event_id'] : null;
    $booking_date = $_POST['booking_date'];
    $notes = trim($_POST['notes']);
    $status = $_POST['status'];
    $guests = isset($_POST['guests']) ? (int)$_POST['guests'] : 0;
    
    if (empty($user_id) || empty($service_id) || empty($booking_date)) {
        $error = 'Please fill all required fields';
    } else {
        // Service ka naam nikaal lo product_name ke liye
        $stmt2 = $pdo->prepare("SELECT service_name, price FROM services WHERE id = ?");
        $stmt2->execute([$service_id]);
        $service_data = $stmt2->fetch();
        $product_name = $service_data['service_name'] ?? 'Service Booking';
        $product_price = 'PKR ' . number_format($service_data['price'] ?? 0);
        
        // User ka info nikaal lo full_name, email, phone ke liye
        $stmt3 = $pdo->prepare("SELECT full_name, email, phone FROM users WHERE id = ?");
        $stmt3->execute([$user_id]);
        $user_data = $stmt3->fetch();
        $full_name = $user_data['full_name'] ?? '';
        $email = $user_data['email'] ?? '';
        $phone = $user_data['phone'] ?? '';
        
        $stmt = $pdo->prepare("INSERT INTO bookings 
            (user_id, service_id, event_id, product_id, product_name, product_price, 
             full_name, email, phone, booking_date, event_date, guests, notes, status) 
            VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");
        
        $result = $stmt->execute([
            $user_id, 
            $service_id, 
            $event_id, 
            $service_id,           // product_id as service_id (kyunki service_id hi product hai)
            $product_name, 
            $product_price,
            $full_name,
            $email,
            $phone,
            $booking_date,
            $booking_date,         // event_date same
            $guests,
            $notes,
            $status
        ]);
        
        if ($result) {
            $success = 'Booking added successfully!';
            header("refresh:2;url=index.php#bookings");
        } else {
            $error = 'Failed to add booking';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Booking - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f5f2;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            padding: 20px;
        }
        .container {
            background: white;
            padding: 40px;
            border-radius: 16px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            width: 100%;
            max-width: 550px;
        }
        h1 { font-size: 24px; color: #1a1a2e; margin-bottom: 5px; }
        h1 span { color: #8B4513; }
        .subtitle { color: #6b7280; font-size: 14px; margin-bottom: 25px; }
        .form-group { margin-bottom: 18px; }
        label { display: block; font-weight: 500; font-size: 14px; margin-bottom: 5px; color: #2d2d2d; }
        input, select, textarea {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: 'Inter', sans-serif;
        }
        input:focus, select:focus, textarea:focus {
            outline: none;
            border-color: #8B4513;
            box-shadow: 0 0 0 3px rgba(139,69,19,0.1);
        }
        textarea { resize: vertical; min-height: 70px; }
        .btn {
            width: 100%;
            padding: 14px;
            background: #8B4513;
            color: white;
            border: none;
            border-radius: 10px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
        }
        .btn:hover {
            background: #6b3410;
            transform: translateY(-2px);
            box-shadow: 0 4px 15px rgba(139,69,19,0.3);
        }
        .error { background: #fee2e2; color: #dc2626; padding: 12px; border-radius: 10px; margin-bottom: 20px; text-align: center; }
        .success { background: #d1fae5; color: #065f46; padding: 12px; border-radius: 10px; margin-bottom: 20px; text-align: center; }
        .back-link { text-align: center; margin-top: 18px; }
        .back-link a { color: #8B4513; text-decoration: none; font-weight: 500; }
        .back-link a:hover { text-decoration: underline; }
        .required { color: #dc2626; }
    </style>
</head>
<body>
    <div class="container">
        <h1>📋 Add <span>Booking</span></h1>
        <p class="subtitle">Create a new service booking</p>
        
        <?php if ($error): ?>
            <div class="error"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>User <span class="required">*</span></label>
                <select name="user_id" required>
                    <option value="">Select User</option>
                    <?php foreach ($users as $user): ?>
                        <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Service <span class="required">*</span></label>
                <select name="service_id" required>
                    <option value="">Select Service</option>
                    <?php foreach ($services as $service): ?>
                        <option value="<?php echo $service['id']; ?>"><?php echo htmlspecialchars($service['service_name']); ?> (PKR <?php echo number_format($service['price']); ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Event (Optional)</label>
                <select name="event_id">
                    <option value="">None</option>
                    <?php foreach ($events as $event): ?>
                        <option value="<?php echo $event['id']; ?>"><?php echo htmlspecialchars($event['event_name']); ?></option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Booking Date <span class="required">*</span></label>
                <input type="date" name="booking_date" required>
            </div>
            <div class="form-group">
                <label>Number of Guests</label>
                <input type="number" name="guests" min="1" placeholder="e.g., 200">
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="pending">Pending</option>
                    <option value="confirmed">Confirmed</option>
                    <option value="completed">Completed</option>
                    <option value="cancelled">Cancelled</option>
                </select>
            </div>
            <div class="form-group">
                <label>Notes</label>
                <textarea name="notes" placeholder="Additional notes"></textarea>
            </div>
            <button type="submit" class="btn"><i class="fas fa-plus"></i> Add Booking</button>
        </form>
        
        <div class="back-link">
            <a href="index.php#bookings"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
</body>
</html>