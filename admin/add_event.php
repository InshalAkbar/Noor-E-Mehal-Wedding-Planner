<?php
// admin/add_event.php
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$error = '';
$success = '';

// Get users for dropdown
$users = $pdo->query("SELECT id, full_name, email FROM users ORDER BY full_name")->fetchAll();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $user_id = (int)$_POST['user_id'];
    $event_name = trim($_POST['event_name']);
    $event_date = $_POST['event_date'];
    $event_type = trim($_POST['event_type']);
    $venue = trim($_POST['venue']);
    $guest_count = (int)$_POST['guest_count'];
    $budget = (float)$_POST['budget'];
    $status = $_POST['status'];
    
    if (empty($user_id) || empty($event_name) || empty($event_date)) {
        $error = 'Please fill all required fields';
    } else {
        $stmt = $pdo->prepare("INSERT INTO events (user_id, event_name, event_date, event_type, venue, guest_count, budget, status) VALUES (?, ?, ?, ?, ?, ?, ?, ?)");
        if ($stmt->execute([$user_id, $event_name, $event_date, $event_type, $venue, $guest_count, $budget, $status])) {
            $success = 'Event added successfully!';
            header("refresh:2;url=index.php#events");
        } else {
            $error = 'Failed to add event';
        }
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Add Event - Admin</title>
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
        input, select {
            width: 100%;
            padding: 12px 15px;
            border: 1px solid #e5e7eb;
            border-radius: 10px;
            font-size: 14px;
            transition: border-color 0.3s;
            font-family: 'Inter', sans-serif;
        }
        input:focus, select:focus {
            outline: none;
            border-color: #8B4513;
            box-shadow: 0 0 0 3px rgba(139,69,19,0.1);
        }
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
        <h1>📅 Add <span>Event</span></h1>
        <p class="subtitle">Create a new wedding event</p>
        
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
                        <option value="<?php echo $user['id']; ?>"><?php echo htmlspecialchars($user['full_name']); ?> (<?php echo htmlspecialchars($user['email']); ?>)</option>
                    <?php endforeach; ?>
                </select>
            </div>
            <div class="form-group">
                <label>Event Name <span class="required">*</span></label>
                <input type="text" name="event_name" required placeholder="e.g., Wedding Ceremony">
            </div>
            <div class="form-group">
                <label>Event Date <span class="required">*</span></label>
                <input type="date" name="event_date" required>
            </div>
            <div class="form-group">
                <label>Event Type</label>
                <select name="event_type">
                    <option value="Wedding">Wedding</option>
                    <option value="Engagement">Engagement</option>
                    <option value="Mehndi">Mehndi</option>
                    <option value="Walima">Walima</option>
                    <option value="Other">Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Venue</label>
                <input type="text" name="venue" placeholder="Event venue">
            </div>
            <div class="form-group">
                <label>Guest Count</label>
                <input type="number" name="guest_count" min="1" placeholder="Number of guests">
            </div>
            <div class="form-group">
                <label>Budget (PKR)</label>
                <input type="number" name="budget" min="0" step="1000" placeholder="Total budget">
            </div>
            <div class="form-group">
    <label>Approval Status</label>
    <select name="approval_status">
        <option value="pending">Pending</option>
        <option value="approved">Approved</option>
        <option value="rejected">Rejected</option>
    </select>
</div>
            <button type="submit" class="btn"><i class="fas fa-plus"></i> Add Event</button>
        </form>
        
        <div class="back-link">
            <a href="index.php#events"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
</body>
</html>