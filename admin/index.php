<?php
// admin/index.php - With Approval Status + Inquiries (FIXED)
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

// Get statistics
$total_users = $pdo->query("SELECT COUNT(*) FROM users")->fetchColumn();
$total_events = $pdo->query("SELECT COUNT(*) FROM events")->fetchColumn();
$total_bookings = $pdo->query("SELECT COUNT(*) FROM bookings")->fetchColumn();
$total_services = $pdo->query("SELECT COUNT(*) FROM services WHERE status = 'active'")->fetchColumn();
$total_revenue = $pdo->query("SELECT COALESCE(SUM(s.price), 0) FROM bookings b JOIN services s ON b.service_id = s.id WHERE b.status = 'confirmed'")->fetchColumn();

// Get pending approvals count
$pending_approvals = $pdo->query("SELECT COUNT(*) FROM events WHERE approval_status = 'pending'")->fetchColumn();

// INQUIRIES STATS
$total_inquiries = $pdo->query("SELECT COUNT(*) FROM inquiries")->fetchColumn();
$pending_inquiries = $pdo->query("SELECT COUNT(*) FROM inquiries WHERE status = 'pending'")->fetchColumn();

// Recent bookings
$recent_bookings = $pdo->query("
    SELECT b.*, 
           u.full_name as user_full_name,
           s.service_name 
    FROM bookings b 
    LEFT JOIN users u ON b.user_id = u.id 
    LEFT JOIN services s ON b.service_id = s.id 
    ORDER BY b.created_at DESC LIMIT 10
")->fetchAll();

// Get all users
$users = $pdo->query("SELECT * FROM users ORDER BY created_at DESC")->fetchAll();

// Get all events with user names
$events = $pdo->query("
    SELECT e.*, u.full_name as user_name 
    FROM events e 
    JOIN users u ON e.user_id = u.id 
    ORDER BY e.created_at DESC
")->fetchAll();

// Get all services
$services = $pdo->query("SELECT * FROM services ORDER BY id")->fetchAll();

// All bookings with complete details
$all_bookings = $pdo->query("
    SELECT b.*, 
           u.full_name as user_full_name,
           s.service_name 
    FROM bookings b 
    LEFT JOIN users u ON b.user_id = u.id 
    LEFT JOIN services s ON b.service_id = s.id 
    ORDER BY b.created_at DESC
")->fetchAll();

// All inquiries
$all_inquiries = $pdo->query("
    SELECT * FROM inquiries 
    ORDER BY 
        FIELD(status, 'pending', 'read', 'replied'),
        created_at DESC
")->fetchAll();

// Handle approval status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_approval'])) {
    $event_id = (int)$_POST['event_id'];
    $approval_status = $_POST['approval_status'];
    $stmt = $pdo->prepare("UPDATE events SET approval_status = ? WHERE id = ?");
    $stmt->execute([$approval_status, $event_id]);
    header('Location: index.php#events');
    exit();
}

// Handle inquiry status update
if ($_SERVER['REQUEST_METHOD'] == 'POST' && isset($_POST['update_inquiry'])) {
    $inquiry_id = (int)$_POST['inquiry_id'];
    $inquiry_status = $_POST['inquiry_status'];
    $stmt = $pdo->prepare("UPDATE inquiries SET status = ? WHERE id = ?");
    $stmt->execute([$inquiry_status, $inquiry_id]);
    header('Location: index.php#inquiries');
    exit();
}

// Helper function - product name ke liye fallback
function getProductName($booking) {
    if (!empty($booking['product_name'])) {
        return htmlspecialchars($booking['product_name']);
    } elseif (!empty($booking['service_name'])) {
        return htmlspecialchars($booking['service_name']);
    } elseif (!empty($booking['product_id'])) {
        return 'Product #' . $booking['product_id'];
    }
    return 'N/A';
}

// Helper function - price format
function formatPrice($price) {
    if (empty($price)) return 'N/A';
    $clean = str_replace(['PKR', ',', ' '], '', $price);
    if (is_numeric($clean)) {
        return 'PKR ' . number_format(floatval($clean));
    }
    return $price;
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard - Noor e Mehal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800;900&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        :root {
            --gold: #d4af37;
            --gold-light: #f0d77b;
            --gold-dark: #a88920;
            --black: #0a0a0a;
            --black-light: #111111;
            --card: #151515;
            --white: #ffffff;
            --gray: #999999;
            --border: rgba(212, 175, 55, 0.22);
            --radius: 16px;
            --shadow: 0 15px 40px rgba(0,0,0,0.5);
        }
        body {
            font-family: 'Inter', sans-serif;
            background: var(--black);
            color: var(--white);
            display: flex;
            min-height: 100vh;
        }

        .sidebar {
            width: 280px;
            background: var(--black);
            min-height: 100vh;
            padding: 25px 20px;
            position: fixed;
            top: 0;
            left: 0;
            bottom: 0;
            overflow-y: auto;
            z-index: 100;
            border-right: 1px solid var(--border);
            transition: transform 0.3s ease;
        }
        .sidebar::-webkit-scrollbar { width: 4px; }
        .sidebar::-webkit-scrollbar-thumb { background: var(--gold); border-radius: 10px; }

        .sidebar-brand {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 10px 15px;
            margin-bottom: 35px;
            border-bottom: 1px solid var(--border);
            padding-bottom: 20px;
        }
        .sidebar-brand h2 {
            color: #fff;
            font-family: 'Cinzel', serif;
            font-size: 24px;
            font-weight: 700;
        }
        .sidebar-brand h2 span { color: var(--gold); }

        .sidebar-menu { list-style: none; margin-top: 10px; }
        .sidebar-menu li { margin-bottom: 4px; }
        .sidebar-menu li a {
            display: flex;
            align-items: center;
            gap: 14px;
            padding: 13px 18px;
            color: rgba(255,255,255,0.6);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s;
            font-size: 14px;
            font-weight: 500;
        }
        .sidebar-menu li a i {
            width: 22px;
            font-size: 16px;
            text-align: center;
            color: var(--gold);
        }
        .sidebar-menu li a:hover {
            background: rgba(212, 175, 55, 0.08);
            color: var(--gold-light);
        }
        .sidebar-menu li a.active {
            background: linear-gradient(135deg, var(--gold), var(--gold-dark));
            color: #000;
            box-shadow: 0 6px 20px rgba(212, 175, 55, 0.3);
        }
        .sidebar-menu li a.active i { color: #000; }
        .sidebar-menu li a .badge {
            margin-left: auto;
            background: rgba(255,255,255,0.08);
            padding: 2px 10px;
            border-radius: 20px;
            font-size: 11px;
            color: rgba(255,255,255,0.6);
        }
        .sidebar-menu li a .badge.pending-badge {
            background: #3a3018;
            color: #f1d77a;
        }
        .sidebar-menu li a .badge.inquiry-badge {
            background: #2a1a4a;
            color: #c084fc;
        }

        .sidebar-footer {
            position: absolute;
            bottom: 25px;
            left: 20px;
            right: 20px;
            padding-top: 20px;
            border-top: 1px solid var(--border);
        }
        .sidebar-footer a {
            display: flex;
            align-items: center;
            gap: 12px;
            padding: 12px 18px;
            color: rgba(255,255,255,0.45);
            text-decoration: none;
            border-radius: 12px;
            transition: all 0.3s;
            font-size: 14px;
        }
        .sidebar-footer a:hover {
            background: rgba(212, 175, 55, 0.08);
            color: var(--gold);
        }

        .main-content {
            margin-left: 280px;
            flex: 1;
            padding: 30px 35px;
            min-height: 100vh;
            background: var(--black);
        }

        .topbar {
            display: flex;
            justify-content: space-between;
            align-items: center;
            margin-bottom: 30px;
            background: var(--card);
            padding: 18px 28px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }
        .topbar-left h1 {
            font-family: 'Cinzel', serif;
            font-size: 28px;
            font-weight: 700;
            color: #fff;
        }
        .topbar-left h1 span { color: var(--gold); }
        .topbar-left p {
            font-size: 14px;
            color: var(--gray);
            margin-top: 4px;
        }
        .topbar-right {
            display: flex;
            align-items: center;
            gap: 20px;
        }
        .topbar-right .admin-info {
            display: flex;
            align-items: center;
            gap: 12px;
            background: var(--black-light);
            padding: 8px 18px 8px 14px;
            border-radius: 50px;
            border: 1px solid rgba(212, 175, 55, 0.15);
        }
        .topbar-right .admin-info .avatar {
            width: 36px;
            height: 36px;
            background: var(--gold);
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
            color: #000;
            font-weight: 600;
            font-size: 14px;
        }
        .topbar-right .admin-info span { font-size: 14px; font-weight: 500; color: #fff; }
        .topbar-right .logout-btn {
            background: transparent;
            color: var(--gold);
            padding: 10px 20px;
            border-radius: 50px;
            border: 1px solid var(--gold);
            text-decoration: none;
            font-size: 14px;
            font-weight: 500;
            transition: all 0.3s;
        }
        .topbar-right .logout-btn:hover {
            background: var(--gold);
            color: #000;
        }

        .stats-grid {
            display: grid;
            grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));
            gap: 20px;
            margin-bottom: 30px;
        }
        .stat-card {
            background: var(--card);
            padding: 24px 25px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            transition: all 0.3s ease;
            position: relative;
            overflow: hidden;
        }
        .stat-card::before {
            content: "";
            position: absolute;
            top: 0;
            left: 0;
            width: 100%;
            height: 3px;
            background: var(--gold);
            transform: scaleX(0);
            transform-origin: left;
            transition: 0.3s ease;
        }
        .stat-card:hover::before { transform: scaleX(1); }
        .stat-card:hover {
            transform: translateY(-5px);
            border-color: var(--gold);
        }
        .stat-card .stat-icon {
            width: 48px;
            height: 48px;
            border-radius: 12px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 20px;
            margin-bottom: 12px;
            background: rgba(212, 175, 55, 0.12);
            color: var(--gold);
        }
        .stat-card .stat-number {
            font-size: 32px;
            font-weight: 700;
            color: #fff;
        }
        .stat-card .stat-label {
            font-size: 14px;
            color: var(--gray);
            margin-top: 4px;
        }
        .stat-card .stat-change {
            font-size: 12px;
            font-weight: 500;
            margin-top: 8px;
            display: inline-block;
            padding: 3px 12px;
            border-radius: 20px;
        }
        .stat-card .stat-change.up { background: rgba(114, 214, 165, 0.12); color: #72d6a5; }
        .stat-card .stat-change.down { background: rgba(255, 133, 133, 0.12); color: #ff8585; }
        .stat-card .stat-change.pending { background: rgba(212, 175, 55, 0.12); color: var(--gold-light); }

        .section-tabs {
            display: flex;
            gap: 8px;
            margin-bottom: 25px;
            flex-wrap: wrap;
            background: var(--card);
            padding: 8px 12px;
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
        }
        .section-tabs .tab-btn {
            padding: 10px 24px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 500;
            cursor: pointer;
            transition: all 0.3s;
            background: transparent;
            color: var(--gray);
        }
        .section-tabs .tab-btn:hover {
            background: rgba(212, 175, 55, 0.08);
            color: var(--gold-light);
        }
        .section-tabs .tab-btn.active {
            background: var(--gold);
            color: #000;
            box-shadow: 0 5px 18px rgba(212, 175, 55, 0.3);
        }
        .section-tabs .tab-btn i { margin-right: 8px; }
        .section-tabs .tab-btn .tab-badge {
            background: rgba(0,0,0,0.18);
            color: #000;
            padding: 1px 10px;
            border-radius: 20px;
            font-size: 11px;
            margin-left: 6px;
        }

        .table-container {
            background: var(--card);
            border-radius: var(--radius);
            border: 1px solid var(--border);
            box-shadow: var(--shadow);
            padding: 20px 0 0 0;
            overflow: hidden;
            margin-bottom: 30px;
            display: none;
        }
        .table-container.active { display: block; }

        .table-header {
            padding: 0 25px 20px 25px;
            display: flex;
            justify-content: space-between;
            align-items: center;
            flex-wrap: wrap;
            gap: 15px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
        }
        .table-header h3 {
            font-size: 18px;
            font-weight: 600;
            color: #fff;
        }
        .table-header h3 i { color: var(--gold); margin-right: 10px; }
        .table-header .btn-add {
            background: var(--gold);
            color: #000;
            padding: 10px 22px;
            border: none;
            border-radius: 10px;
            font-size: 14px;
            font-weight: 600;
            cursor: pointer;
            text-decoration: none;
            transition: all 0.3s;
            display: inline-flex;
            align-items: center;
            gap: 8px;
        }
        .table-header .btn-add:hover {
            background: var(--gold-light);
            transform: translateY(-2px);
            box-shadow: 0 5px 18px rgba(212, 175, 55, 0.3);
        }

        .table-scroll { overflow-x: auto; padding: 0 5px 5px 5px; }
        table {
            width: 100%;
            border-collapse: collapse;
            font-size: 14px;
        }
        thead {
            background: var(--black-light);
            border-bottom: 2px solid rgba(212, 175, 55, 0.25);
        }
        th {
            padding: 14px 20px;
            text-align: left;
            font-weight: 600;
            color: var(--gold);
            font-size: 12px;
            text-transform: uppercase;
            letter-spacing: 0.5px;
        }
        td {
            padding: 14px 20px;
            border-bottom: 1px solid rgba(255,255,255,0.05);
            vertical-align: middle;
            color: #ddd;
        }
        tr:hover td { background: rgba(212, 175, 55, 0.04); }

        .status {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .status-pending { background: #3a3018; color: #f1d77a; }
        .status-confirmed { background: #17352b; color: #72d6a5; }
        .status-completed { background: rgba(212, 175, 55, 0.15); color: var(--gold-light); }
        .status-cancelled { background: #3a1d1d; color: #ff8585; }
        .status-active { background: #17352b; color: #72d6a5; }
        .status-inactive { background: #3a1d1d; color: #ff8585; }
        .status-read { background: #1a2a4a; color: #84b4fc; }
        .status-replied { background: #1a3a2a; color: #84fca8; }

        .approval-status {
            padding: 4px 14px;
            border-radius: 50px;
            font-size: 12px;
            font-weight: 600;
            display: inline-block;
        }
        .approval-pending { background: #3a3018; color: #f1d77a; }
        .approval-approved { background: #17352b; color: #72d6a5; }
        .approval-rejected { background: #3a1d1d; color: #ff8585; }

        .action-btns {
            display: flex;
            gap: 6px;
            flex-wrap: wrap;
        }
        .action-btns .btn-sm {
            padding: 5px 14px;
            border: none;
            border-radius: 8px;
            font-size: 12px;
            font-weight: 500;
            cursor: pointer;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 5px;
            transition: all 0.2s;
            background: rgba(212, 175, 55, 0.1);
            color: var(--gold-light);
            border: 1px solid rgba(212, 175, 55, 0.18);
        }
        .action-btns .btn-sm:hover {
            background: var(--gold);
            color: #000;
            transform: translateY(-2px);
        }

        .empty-state {
            text-align: center;
            padding: 60px 20px;
            color: var(--gray);
        }
        .empty-state i {
            font-size: 48px;
            color: rgba(212, 175, 55, 0.3);
            margin-bottom: 15px;
        }
        .empty-state h4 { font-size: 18px; color: #fff; margin-bottom: 5px; }

        .mobile-toggle {
            display: none;
            background: none;
            border: none;
            color: #fff;
            font-size: 24px;
            cursor: pointer;
        }

        @media (max-width: 992px) {
            .sidebar { transform: translateX(-100%); }
            .sidebar.open { transform: translateX(0); }
            .main-content { margin-left: 0; padding: 20px; }
            .mobile-toggle { display: block; }
            .topbar-left { display: flex; align-items: center; gap: 15px; }
            .stats-grid { grid-template-columns: repeat(2, 1fr); }
        }
        @media (max-width: 600px) {
            .main-content { padding: 15px; }
            .stats-grid { grid-template-columns: 1fr 1fr; gap: 12px; }
            .stat-card { padding: 18px; }
            .stat-card .stat-number { font-size: 24px; }
            .section-tabs .tab-btn { padding: 8px 14px; font-size: 12px; }
            .table-header { flex-direction: column; align-items: stretch; }
            .topbar { flex-direction: column; align-items: flex-start; gap: 15px; }
            .topbar-right { width: 100%; justify-content: space-between; }
        }
    </style>
</head>
<body>

<!-- ===== SIDEBAR ===== -->
<div class="sidebar" id="sidebar">
    <div class="sidebar-brand">
        <h2>Noor e <span>Mehal</span></h2>
    </div>
    
    <ul class="sidebar-menu">
        <li><a href="#" class="active" data-tab="dashboard"><i class="fas fa-chart-pie"></i> Dashboard</a></li>
        <li><a href="#" data-tab="users"><i class="fas fa-users"></i> Users <span class="badge"><?php echo $total_users; ?></span></a></li>
        <li><a href="#" data-tab="events"><i class="fas fa-calendar-alt"></i> Events <span class="badge <?php echo $pending_approvals > 0 ? 'pending-badge' : ''; ?>"><?php echo $total_events; ?></span></a></li>
        <li><a href="#" data-tab="bookings"><i class="fas fa-bookmark"></i> Bookings <span class="badge"><?php echo $total_bookings; ?></span></a></li>
        <li><a href="#" data-tab="services"><i class="fas fa-concierge-bell"></i> Services <span class="badge"><?php echo $total_services; ?></span></a></li>
        <li><a href="#" data-tab="inquiries"><i class="fas fa-envelope"></i> Inquiries <span class="badge <?php echo $pending_inquiries > 0 ? 'inquiry-badge' : ''; ?>"><?php echo $total_inquiries; ?></span></a></li>
    </ul>
    
    <div class="sidebar-footer">
        <a href="../index.php" target="_blank"><i class="fas fa-external-link-alt"></i> View Website</a>
        <a href="logout.php"><i class="fas fa-sign-out-alt"></i> Logout</a>
    </div>
</div>

<!-- ===== MAIN CONTENT ===== -->
<div class="main-content">
    <!-- Top Bar -->
    <div class="topbar">
        <div class="topbar-left">
            <button class="mobile-toggle" onclick="toggleSidebar()"><i class="fas fa-bars"></i></button>
            <h1>Admin <span>Dashboard</span></h1>
            <p>Welcome back, Admin! Here's what's happening today.</p>
        </div>
        <div class="topbar-right">
            <div class="admin-info">
                <div class="avatar">A</div>
                <span>Administrator</span>
            </div>
            <a href="logout.php" class="logout-btn"><i class="fas fa-sign-out-alt"></i> Logout</a>
        </div>
    </div>
    
    <!-- Stats -->
    <div class="stats-grid">
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-users"></i></div>
            <div class="stat-number"><?php echo $total_users; ?></div>
            <div class="stat-label">Total Users</div>
            <span class="stat-change up"><i class="fas fa-arrow-up"></i> Active</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-calendar-plus"></i></div>
            <div class="stat-number"><?php echo $total_events; ?></div>
            <div class="stat-label">Total Events</div>
            <span class="stat-change up"><i class="fas fa-arrow-up"></i> Created</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-clock"></i></div>
            <div class="stat-number"><?php echo $pending_approvals; ?></div>
            <div class="stat-label">Pending Approvals</div>
            <span class="stat-change pending"><i class="fas fa-hourglass-half"></i> Waiting</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-bookmark"></i></div>
            <div class="stat-number"><?php echo $total_bookings; ?></div>
            <div class="stat-label">Total Bookings</div>
            <span class="stat-change up"><i class="fas fa-arrow-up"></i> Active</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-concierge-bell"></i></div>
            <div class="stat-number"><?php echo $total_services; ?></div>
            <div class="stat-label">Active Services</div>
            <span class="stat-change up"><i class="fas fa-arrow-up"></i> Available</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-rupee-sign"></i></div>
            <div class="stat-number">PKR <?php echo number_format($total_revenue); ?></div>
            <div class="stat-label">Total Revenue</div>
            <span class="stat-change up"><i class="fas fa-arrow-up"></i> Confirmed</span>
        </div>
        <div class="stat-card">
            <div class="stat-icon"><i class="fas fa-envelope"></i></div>
            <div class="stat-number"><?php echo $total_inquiries; ?></div>
            <div class="stat-label">Total Inquiries</div>
            <span class="stat-change <?php echo $pending_inquiries > 0 ? 'pending' : 'up'; ?>">
                <?php if ($pending_inquiries > 0): ?>
                    <i class="fas fa-hourglass-half"></i> <?php echo $pending_inquiries; ?> Pending
                <?php else: ?>
                    <i class="fas fa-check"></i> All Read
                <?php endif; ?>
            </span>
        </div>
    </div>
    
    <!-- Section Tabs -->
    <div class="section-tabs" id="tabContainer">
        <button class="tab-btn active" data-section="dashboard"><i class="fas fa-chart-pie"></i> Overview</button>
        <button class="tab-btn" data-section="users"><i class="fas fa-users"></i> Users</button>
        <button class="tab-btn" data-section="events"><i class="fas fa-calendar"></i> Events <?php if($pending_approvals > 0): ?><span class="tab-badge"><?php echo $pending_approvals; ?> Pending</span><?php endif; ?></button>
        <button class="tab-btn" data-section="bookings"><i class="fas fa-bookmark"></i> Bookings</button>
        <button class="tab-btn" data-section="services"><i class="fas fa-concierge-bell"></i> Services</button>
        <button class="tab-btn" data-section="inquiries"><i class="fas fa-envelope"></i> Inquiries <?php if($pending_inquiries > 0): ?><span class="tab-badge"><?php echo $pending_inquiries; ?> New</span><?php endif; ?></button>
    </div>
    
    <!-- ===== DASHBOARD - Recent Bookings ===== -->
    <div class="table-container active" id="section-dashboard">
        <div class="table-header">
            <h3><i class="fas fa-clock"></i> Recent Bookings</h3>
            <a href="#" class="btn-add" onclick="switchTab('bookings'); return false;"><i class="fas fa-eye"></i> View All</a>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Service</th>
                        <th>Product</th>
                        <th>Event Date</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Action</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($recent_bookings)): ?>
                        <tr><td colspan="7"><div class="empty-state"><i class="fas fa-inbox"></i><h4>No bookings yet</h4></div></td></tr>
                    <?php else: ?>
                        <?php foreach ($recent_bookings as $booking): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($booking['full_name'] ?? $booking['user_full_name'] ?? 'N/A'); ?></strong></td>
                            <td><?php echo htmlspecialchars($booking['service_name'] ?? 'N/A'); ?></td>
                            <td><strong style="color:#d4af37;"><?php echo getProductName($booking); ?></strong></td>
                            <td><?php 
                                if (!empty($booking['event_date']) && $booking['event_date'] != '0000-00-00') {
                                    echo date('d M Y', strtotime($booking['event_date']));
                                } elseif (!empty($booking['booking_date'])) {
                                    echo date('d M Y', strtotime($booking['booking_date']));
                                } else {
                                    echo 'N/A';
                                }
                            ?></td>
                            <td><?php echo formatPrice($booking['product_price'] ?? ''); ?></td>
                            <td><span class="status status-<?php echo $booking['status'] ?? 'pending'; ?>"><?php echo ucfirst($booking['status'] ?? 'Pending'); ?></span></td>
                            <td>
                                <form method="POST" action="update_booking.php" style="display:inline;">
                                    <input type="hidden" name="booking_id" value="<?php echo $booking['id'] ?? 0; ?>">
                                    <select name="status" onchange="this.form.submit()" style="padding:6px 12px;border-radius:8px;border:1px solid rgba(212,175,55,0.3);font-size:13px;background:#1a1a1a;color:#fff;">
                                        <option value="pending" <?php echo ($booking['status'] ?? '') == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                        <option value="confirmed" <?php echo ($booking['status'] ?? '') == 'confirmed' ? 'selected' : ''; ?>>Confirm</option>
                                        <option value="completed" <?php echo ($booking['status'] ?? '') == 'completed' ? 'selected' : ''; ?>>Complete</option>
                                        <option value="cancelled" <?php echo ($booking['status'] ?? '') == 'cancelled' ? 'selected' : ''; ?>>Cancel</option>
                                    </select>
                                </form>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- ===== USERS ===== -->
    <div class="table-container" id="section-users">
        <div class="table-header">
            <h3><i class="fas fa-users"></i> All Users</h3>
            <a href="add_user.php" class="btn-add"><i class="fas fa-plus"></i> Add User</a>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Name</th>
                        <th>Email</th>
                        <th>Phone</th>
                        <th>Registered</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($users)): ?>
                        <tr><td colspan="6"><div class="empty-state"><i class="fas fa-user-slash"></i><h4>No users registered</h4></div></td></tr>
                    <?php else: ?>
                        <?php foreach ($users as $user): ?>
                        <tr>
                            <td>#<?php echo $user['id'] ?? ''; ?></td>
                            <td><strong><?php echo htmlspecialchars($user['full_name'] ?? 'N/A'); ?></strong></td>
                            <td><?php echo htmlspecialchars($user['email'] ?? 'N/A'); ?></td>
                            <td><?php echo htmlspecialchars($user['phone'] ?? 'N/A'); ?></td>
                            <td><?php echo isset($user['created_at']) ? date('d M Y', strtotime($user['created_at'])) : 'N/A'; ?></td>
                            <td>
                                <div class="action-btns">
                                    <a href="edit_user.php?id=<?php echo $user['id'] ?? 0; ?>" class="btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="delete_user.php?id=<?php echo $user['id'] ?? 0; ?>" class="btn-sm" onclick="return confirm('Delete this user?')"><i class="fas fa-trash"></i> Delete</a>
                                    <a href="show_user.php?id=<?php echo $user['id'] ?? 0; ?>" class="btn-sm"><i class="fas fa-eye"></i> View</a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- ===== EVENTS ===== -->
    <div class="table-container" id="section-events">
        <div class="table-header">
            <h3><i class="fas fa-calendar-alt"></i> All Events <?php if($pending_approvals > 0): ?><span style="background:#3a3018;color:#f1d77a;padding:2px 12px;border-radius:20px;font-size:12px;font-weight:600;margin-left:10px;"><?php echo $pending_approvals; ?> Pending Approval</span><?php endif; ?></h3>
            <a href="add_event.php" class="btn-add"><i class="fas fa-plus"></i> Add Event</a>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Event</th>
                        <th>Date</th>
                        <th>Venue</th>
                        <th>Budget</th>
                        <th>Status</th>
                        <th>Approval</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($events)): ?>
                        <tr><td colspan="8"><div class="empty-state"><i class="fas fa-calendar-times"></i><h4>No events created</h4></div></td></tr>
                    <?php else: ?>
                        <?php foreach ($events as $event): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($event['user_name'] ?? 'N/A'); ?></td>
                            <td><strong><?php echo htmlspecialchars($event['event_name'] ?? 'N/A'); ?></strong></td>
                            <td><?php echo isset($event['event_date']) ? date('d M Y', strtotime($event['event_date'])) : 'N/A'; ?></td>
                            <td><?php echo htmlspecialchars($event['venue'] ?? 'N/A'); ?></td>
                            <td>PKR <?php echo number_format($event['budget'] ?? 0); ?></td>
                            <td><span class="status status-<?php echo $event['status'] ?? 'pending'; ?>"><?php echo ucfirst($event['status'] ?? 'Pending'); ?></span></td>
                            <td>
                                <span class="approval-status approval-<?php echo $event['approval_status'] ?? 'pending'; ?>">
                                    <?php echo ucfirst($event['approval_status'] ?? 'Pending'); ?>
                                </span>
                            </td>
                            <td>
                                <div class="action-btns">
                                    <form method="POST" action="" style="display:inline-flex;gap:4px;flex-wrap:wrap;">
                                        <input type="hidden" name="event_id" value="<?php echo $event['id'] ?? 0; ?>">
                                        <input type="hidden" name="update_approval" value="1">
                                        
                                        <?php if (($event['approval_status'] ?? '') != 'approved'): ?>
                                            <button type="submit" name="approval_status" value="approved" class="btn-sm" onclick="return confirm('Approve this event?')">
                                                <i class="fas fa-check"></i> Approve
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if (($event['approval_status'] ?? '') != 'rejected'): ?>
                                            <button type="submit" name="approval_status" value="rejected" class="btn-sm" onclick="return confirm('Reject this event?')">
                                                <i class="fas fa-times"></i> Reject
                                            </button>
                                        <?php endif; ?>
                                        
                                        <?php if (($event['approval_status'] ?? '') != 'pending'): ?>
                                            <button type="submit" name="approval_status" value="pending" class="btn-sm" onclick="return confirm('Set back to pending?')">
                                                <i class="fas fa-undo"></i> Reset
                                            </button>
                                        <?php endif; ?>
                                    </form>
                                    
                                    <a href="edit_event.php?id=<?php echo $event['id'] ?? 0; ?>" class="btn-sm"><i class="fas fa-edit"></i></a>
                                    <a href="delete_event.php?id=<?php echo $event['id'] ?? 0; ?>" class="btn-sm" onclick="return confirm('Delete this event?')"><i class="fas fa-trash"></i></a>
                                    <a href="show_event.php?id=<?php echo $event['id'] ?? 0; ?>" class="btn-sm"><i class="fas fa-eye"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- ===== BOOKINGS ===== -->
    <div class="table-container" id="section-bookings">
        <div class="table-header">
            <h3><i class="fas fa-bookmark"></i> All Bookings</h3>
            <a href="book_service.php" class="btn-add"><i class="fas fa-plus"></i> Add Booking</a>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>User</th>
                        <th>Service</th>
                        <th>Product</th>
                        <th>Event Date</th>
                        <th>Guests</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($all_bookings)): ?>
                        <tr><td colspan="8"><div class="empty-state"><i class="fas fa-inbox"></i><h4>No bookings</h4></div></td></tr>
                    <?php else: ?>
                        <?php foreach ($all_bookings as $booking): ?>
                        <tr>
                            <td><strong><?php echo htmlspecialchars($booking['full_name'] ?? $booking['user_full_name'] ?? 'N/A'); ?></strong></td>
                            <td><?php echo htmlspecialchars($booking['service_name'] ?? 'N/A'); ?></td>
                            <td><strong style="color:#d4af37;"><?php echo getProductName($booking); ?></strong></td>
                            <td><?php 
                                if (!empty($booking['event_date']) && $booking['event_date'] != '0000-00-00') {
                                    echo date('d M Y', strtotime($booking['event_date']));
                                } elseif (!empty($booking['booking_date'])) {
                                    echo date('d M Y', strtotime($booking['booking_date']));
                                } else {
                                    echo 'N/A';
                                }
                            ?></td>
                            <td><?php echo isset($booking['guests']) && $booking['guests'] > 0 ? $booking['guests'] : '-'; ?></td>
                            <td><?php echo formatPrice($booking['product_price'] ?? ''); ?></td>
                            <td><span class="status status-<?php echo $booking['status'] ?? 'pending'; ?>"><?php echo ucfirst($booking['status'] ?? 'Pending'); ?></span></td>
                            <td>
                                <div class="action-btns">
                                    <form method="POST" action="update_booking.php" style="display:inline;">
                                        <input type="hidden" name="booking_id" value="<?php echo $booking['id'] ?? 0; ?>">
                                        <select name="status" onchange="this.form.submit()" style="padding:5px 10px;border-radius:8px;border:1px solid rgba(212,175,55,0.3);font-size:12px;background:#1a1a1a;color:#fff;">
                                            <option value="pending" <?php echo ($booking['status'] ?? '') == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="confirmed" <?php echo ($booking['status'] ?? '') == 'confirmed' ? 'selected' : ''; ?>>Confirm</option>
                                            <option value="completed" <?php echo ($booking['status'] ?? '') == 'completed' ? 'selected' : ''; ?>>Complete</option>
                                            <option value="cancelled" <?php echo ($booking['status'] ?? '') == 'cancelled' ? 'selected' : ''; ?>>Cancel</option>
                                        </select>
                                    </form>
                                    <a href="delete_book_services.php?id=<?php echo $booking['id'] ?? 0; ?>&type=booking" class="btn-sm" onclick="return confirm('Delete this booking?')"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- ===== SERVICES ===== -->
    <div class="table-container" id="section-services">
        <div class="table-header">
            <h3><i class="fas fa-concierge-bell"></i> All Services</h3>
            <a href="add_book_services.php" class="btn-add"><i class="fas fa-plus"></i> Add Service</a>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>Service Name</th>
                        <th>Category</th>
                        <th>Price</th>
                        <th>Status</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($services)): ?>
                        <tr><td colspan="6"><div class="empty-state"><i class="fas fa-concierge-bell"></i><h4>No services added</h4></div></td></tr>
                    <?php else: ?>
                        <?php foreach ($services as $service): ?>
                        <tr>
                            <td>#<?php echo $service['id'] ?? ''; ?></td>
                            <td><strong><?php echo htmlspecialchars($service['service_name'] ?? 'N/A'); ?></strong></td>
                            <td><?php echo htmlspecialchars($service['category'] ?? 'N/A'); ?></td>
                            <td>PKR <?php echo number_format($service['price'] ?? 0); ?></td>
                            <td><span class="status status-<?php echo $service['status'] ?? 'active'; ?>"><?php echo ucfirst($service['status'] ?? 'Active'); ?></span></td>
                            <td>
                                <div class="action-btns">
                                    <a href="add_book_services.php?id=<?php echo $service['id'] ?? 0; ?>" class="btn-sm"><i class="fas fa-edit"></i> Edit</a>
                                    <a href="delete_book_services.php?id=<?php echo $service['id'] ?? 0; ?>&type=service" class="btn-sm" onclick="return confirm('Delete this service?')"><i class="fas fa-trash"></i></a>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
    <!-- ===== INQUIRIES ===== -->
    <div class="table-container" id="section-inquiries">
        <div class="table-header">
            <h3><i class="fas fa-envelope"></i> All Inquiries <?php if($pending_inquiries > 0): ?><span style="background:#3a3018;color:#f1d77a;padding:2px 12px;border-radius:20px;font-size:12px;font-weight:600;margin-left:10px;"><?php echo $pending_inquiries; ?> New</span><?php endif; ?></h3>
        </div>
        <div class="table-scroll">
            <table>
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Name</th>
                        <th>Phone</th>
                        <th>Email</th>
                        <th>Event</th>
                        <th>Guests</th>
                        <th>Status</th>
                        <th>Date</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    <?php if (empty($all_inquiries)): ?>
                        <tr><td colspan="9"><div class="empty-state"><i class="fas fa-inbox"></i><h4>No inquiries yet</h4><p>When someone submits a wedding inquiry, it will appear here.</p></div></td></tr>
                    <?php else: ?>
                        <?php foreach ($all_inquiries as $inquiry): ?>
                        <tr>
                            <td>#<?php echo $inquiry['id']; ?></td>
                            <td><strong><?php echo htmlspecialchars($inquiry['full_name']); ?></strong></td>
                            <td><?php echo htmlspecialchars($inquiry['phone']); ?></td>
                            <td><?php echo htmlspecialchars($inquiry['email']); ?></td>
                            <td><?php echo htmlspecialchars($inquiry['wedding_event'] ?? '-'); ?></td>
                            <td><?php echo $inquiry['guests'] ?? '-'; ?></td>
                            <td>
                                <span class="status status-<?php echo $inquiry['status']; ?>">
                                    <?php echo ucfirst($inquiry['status']); ?>
                                </span>
                            </td>
                            <td><?php echo date('d M Y', strtotime($inquiry['created_at'])); ?></td>
                            <td>
                                <div class="action-btns">
                                    <a href="view_inquiry.php?id=<?php echo $inquiry['id']; ?>" class="btn-sm"><i class="fas fa-eye"></i> View</a>
                                    
                                    <form method="POST" action="" style="display:inline;">
                                        <input type="hidden" name="inquiry_id" value="<?php echo $inquiry['id']; ?>">
                                        <input type="hidden" name="update_inquiry" value="1">
                                        <select name="inquiry_status" onchange="this.form.submit()" style="padding:5px 10px;border-radius:8px;border:1px solid rgba(212,175,55,0.3);font-size:12px;background:#1a1a1a;color:#fff;">
                                            <option value="pending" <?php echo $inquiry['status'] == 'pending' ? 'selected' : ''; ?>>Pending</option>
                                            <option value="read" <?php echo $inquiry['status'] == 'read' ? 'selected' : ''; ?>>Read</option>
                                            <option value="replied" <?php echo $inquiry['status'] == 'replied' ? 'selected' : ''; ?>>Replied</option>
                                        </select>
                                    </form>
                                </div>
                            </td>
                        </tr>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    
</div>

<script>
    function toggleSidebar() {
        document.getElementById('sidebar').classList.toggle('open');
    }
    
    document.querySelectorAll('.tab-btn').forEach(btn => {
        btn.addEventListener('click', function() {
            const section = this.dataset.section;
            switchTab(section);
        });
    });
    
    function switchTab(section) {
        document.querySelectorAll('.tab-btn').forEach(b => b.classList.remove('active'));
        document.querySelector(`.tab-btn[data-section="${section}"]`)?.classList.add('active');
        
        document.querySelectorAll('.table-container').forEach(c => c.classList.remove('active'));
        const target = document.getElementById('section-' + section);
        if (target) target.classList.add('active');
        
        document.getElementById('sidebar').classList.remove('open');
    }
    
    document.querySelectorAll('.sidebar-menu a').forEach(link => {
        link.addEventListener('click', function(e) {
            e.preventDefault();
            const tab = this.dataset.tab;
            if (tab) {
                switchTab(tab);
                document.querySelectorAll('.sidebar-menu a').forEach(a => a.classList.remove('active'));
                this.classList.add('active');
            }
        });
    });
    
    document.addEventListener('click', function(e) {
        const sidebar = document.getElementById('sidebar');
        const toggle = document.querySelector('.mobile-toggle');
        if (window.innerWidth <= 992) {
            if (!sidebar.contains(e.target) && !toggle.contains(e.target)) {
                sidebar.classList.remove('open');
            }
        }
    });
</script>

</body>
</html>