<?php
// admin/show_user.php
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("SELECT * FROM users WHERE id = ?");
$stmt->execute([$id]);
$user = $stmt->fetch();

if (!$user) {
    header('Location: index.php#users');
    exit();
}

// Get user's events
$events = $pdo->prepare("SELECT * FROM events WHERE user_id = ? ORDER BY event_date DESC");
$events->execute([$id]);
$user_events = $events->fetchAll();

// Get user's bookings
$bookings = $pdo->prepare("
    SELECT b.*, s.service_name, s.price 
    FROM bookings b 
    JOIN services s ON b.service_id = s.id 
    WHERE b.user_id = ? 
    ORDER BY b.created_at DESC
");
$bookings->execute([$id]);
$user_bookings = $bookings->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Details - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f5f2;
            padding: 30px;
        }
        .container {
            max-width: 1000px;
            margin: 0 auto;
        }
        .card {
            background: white;
            border-radius: 16px;
            padding: 30px;
            box-shadow: 0 10px 40px rgba(0,0,0,0.08);
            margin-bottom: 25px;
        }
        .card h2 {
            font-size: 20px;
            color: #1a1a2e;
            margin-bottom: 20px;
        }
        .card h2 i { color: #8B4513; margin-right: 10px; }
        .user-header {
            display: flex;
            align-items: center;
            gap: 25px;
            flex-wrap: wrap;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 20px;
        }
        .user-avatar {
            width: 80px;
            height: 80px;
            background: linear-gradient(135deg, #8B4513, #c67b3d);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 32px;
            color: white;
            font-weight: 600;
        }
        .user-info h1 { font-size: 28px; color: #1a1a2e; }
        .user-info p { color: #6b7280; font-size: 15px; }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .info-item { padding: 10px 0; }
        .info-item .label { font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-item .value { font-size: 16px; font-weight: 500; color: #1a1a2e; margin-top: 2px; }
        .status {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .status-pending { background: #fef3c7; color: #92400e; }
        .status-confirmed { background: #d1fae5; color: #065f46; }
        .status-completed { background: #dbeafe; color: #1e40af; }
        .status-cancelled { background: #fee2e2; color: #991b1b; }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        thead { background: #faf8f6; border-bottom: 2px solid #f0f0f0; }
        th { padding: 12px 15px; text-align: left; font-weight: 600; color: #6b7280; font-size: 12px; text-transform: uppercase; }
        td { padding: 12px 15px; border-bottom: 1px solid #f5f5f5; }
        tr:hover td { background: #faf8f6; }
        .back-link { display: inline-block; margin-top: 10px; color: #8B4513; text-decoration: none; font-weight: 500; }
        .back-link:hover { text-decoration: underline; }
        .empty-state { text-align: center; padding: 30px; color: #6b7280; }
        .empty-state i { font-size: 36px; color: #ddd; margin-bottom: 10px; display: block; }
        @media (max-width: 600px) {
            body { padding: 15px; }
            .card { padding: 20px; }
            .user-header { flex-direction: column; text-align: center; }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php#users" class="back-link"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        
        <div class="card">
            <div class="user-header">
                <div class="user-avatar"><?php echo strtoupper(substr($user['full_name'], 0, 2)); ?></div>
                <div class="user-info">
                    <h1><?php echo htmlspecialchars($user['full_name']); ?></h1>
                    <p><i class="fas fa-envelope"></i> <?php echo htmlspecialchars($user['email']); ?></p>
                </div>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Phone</div>
                    <div class="value"><?php echo htmlspecialchars($user['phone']) ?: 'Not provided'; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Joined</div>
                    <div class="value"><?php echo date('d M Y, h:i A', strtotime($user['created_at'])); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">User ID</div>
                    <div class="value">#<?php echo $user['id']; ?></div>
                </div>
            </div>
            
            <div class="info-item" style="grid-column: 1 / -1;">
                <div class="label">Address</div>
                <div class="value"><?php echo htmlspecialchars($user['address']) ?: 'Not provided'; ?></div>
            </div>
        </div>
        
        <div class="card">
            <h2><i class="fas fa-calendar-alt"></i> Events (<?php echo count($user_events); ?>)</h2>
            <?php if (empty($user_events)): ?>
                <div class="empty-state"><i class="fas fa-calendar-times"></i> No events created</div>
            <?php else: ?>
                <table>
                    <thead><tr><th>Event</th><th>Date</th><th>Venue</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php foreach ($user_events as $event): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($event['event_name']); ?></strong></td>
                            <td><?php echo date('d M Y', strtotime($event['event_date'])); ?></td>
                            <td><?php echo htmlspecialchars($event['venue']); ?></td>
                            <td><span class="status status-<?php echo $event['status']; ?>"><?php echo ucfirst($event['status']); ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
        
        <div class="card">
            <h2><i class="fas fa-bookmark"></i> Bookings (<?php echo count($user_bookings); ?>)</h2>
            <?php if (empty($user_bookings)): ?>
                <div class="empty-state"><i class="fas fa-inbox"></i> No bookings</div>
            <?php else: ?>
                <table>
                    <thead><tr><th>Service</th><th>Date</th><th>Price</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php foreach ($user_bookings as $booking): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($booking['service_name']); ?></td>
                            <td><?php echo date('d M Y', strtotime($booking['booking_date'])); ?></td>
                            <td>PKR <?php echo number_format($booking['price']); ?></td>
                            <td><span class="status status-<?php echo $booking['status']; ?>"><?php echo ucfirst($booking['status']); ?></span></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
            <?php endif; ?>
        </div>
    </div>
</body>
</html>