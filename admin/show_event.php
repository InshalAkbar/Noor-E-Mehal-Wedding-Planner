<?php
// admin/show_event.php
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$stmt = $pdo->prepare("
    SELECT e.*, u.full_name, u.email, u.phone 
    FROM events e 
    JOIN users u ON e.user_id = u.id 
    WHERE e.id = ?
");
$stmt->execute([$id]);
$event = $stmt->fetch();

if (!$event) {
    header('Location: index.php#events');
    exit();
}

// Get bookings for this event
$bookings = $pdo->prepare("
    SELECT b.*, s.service_name, s.price 
    FROM bookings b 
    JOIN services s ON b.service_id = s.id 
    WHERE b.event_id = ? 
    ORDER BY b.created_at DESC
");
$bookings->execute([$id]);
$event_bookings = $bookings->fetchAll();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Event Details - Admin</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Inter', sans-serif;
            background: #f8f5f2;
            padding: 30px;
        }
        .container { max-width: 1000px; margin: 0 auto; }
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
        .event-header {
            display: flex;
            justify-content: space-between;
            align-items: flex-start;
            flex-wrap: wrap;
            gap: 20px;
            padding-bottom: 20px;
            border-bottom: 1px solid #f0f0f0;
            margin-bottom: 20px;
        }
        .event-header h1 { font-size: 28px; color: #1a1a2e; }
        .event-header h1 small { font-size: 16px; color: #6b7280; font-weight: 400; display: block; margin-top: 4px; }
        .info-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 15px;
        }
        .info-item { padding: 10px 0; }
        .info-item .label { font-size: 12px; color: #6b7280; text-transform: uppercase; letter-spacing: 0.5px; }
        .info-item .value { font-size: 16px; font-weight: 500; color: #1a1a2e; margin-top: 2px; }
        .status {
            padding: 6px 20px;
            border-radius: 50px;
            font-size: 14px;
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
            .event-header { flex-direction: column; }
        }
    </style>
</head>
<body>
    <div class="container">
        <a href="index.php#events" class="back-link"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        
        <div class="card">
            <div class="event-header">
                <div>
                    <h1><?php echo htmlspecialchars($event['event_name']); ?>
                        <small><i class="fas fa-user"></i> <?php echo htmlspecialchars($event['full_name']); ?> (<?php echo htmlspecialchars($event['email']); ?>)</small>
                    </h1>
                </div>
                <div>
                    <span class="status status-<?php echo $event['status']; ?>"><?php echo ucfirst($event['status']); ?></span>
                </div>
            </div>
            
            <div class="info-grid">
                <div class="info-item">
                    <div class="label">Event Date</div>
                    <div class="value"><?php echo date('l, d M Y', strtotime($event['event_date'])); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Event Type</div>
                    <div class="value"><?php echo htmlspecialchars($event['event_type']); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Venue</div>
                    <div class="value"><?php echo htmlspecialchars($event['venue']) ?: 'Not specified'; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Guests</div>
                    <div class="value"><?php echo $event['guest_count'] ?: 'Not specified'; ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Budget</div>
                    <div class="value">PKR <?php echo number_format($event['budget']); ?></div>
                </div>
                <div class="info-item">
                    <div class="label">Created</div>
                    <div class="value"><?php echo date('d M Y, h:i A', strtotime($event['created_at'])); ?></div>
                </div>
            </div>
        </div>
        
        <div class="card">
            <h2><i class="fas fa-bookmark"></i> Bookings for this Event (<?php echo count($event_bookings); ?>)</h2>
            <?php if (empty($event_bookings)): ?>
                <div class="empty-state"><i class="fas fa-inbox"></i> No bookings for this event</div>
            <?php else: ?>
                <table>
                    <thead><tr><th>Service</th><th>Booking Date</th><th>Price</th><th>Status</th></tr></thead>
                    <tbody>
                        <?php foreach ($event_bookings as $booking): ?>
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