<?php
// admin/login.php
require_once '../config/db.php';

define('ADMIN_USERNAME', 'admin');
define('ADMIN_PASSWORD', 'admin123');

$error = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];
    
    if ($username === ADMIN_USERNAME && $password === ADMIN_PASSWORD) {
        $_SESSION['admin_logged_in'] = true;
        $_SESSION['admin_username'] = $username;
        header('Location: index.php');
        exit();
    } else {
        $error = 'Invalid admin credentials';
    }
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Login - Noor e Mehal</title>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Cinzel:wght@400;700;900&family=Playfair+Display:wght@400;700;900&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <style>
        /* =========================================
           BLACK + GOLD LOGIN THEME
        ========================================= */
        * { margin: 0; padding: 0; box-sizing: border-box; }
        
        :root {
            --gold: #d4af37;
            --gold-light: #f0d77b;
            --gold-dark: #a88920;
            --black: #0a0a0a;
            --black-light: #111111;
            --white: #ffffff;
            --gray: #999999;
            --border: rgba(212, 175, 55, 0.22);
        }
        
        body {
            font-family: 'Inter', sans-serif;
            min-height: 100vh;
            display: flex;
            justify-content: center;
            align-items: center;
            background: var(--black);
            position: relative;
            overflow: hidden;
        }
        
        /* ===== GOLD GLOW BACKGROUND ===== */
        body::before {
            content: '';
            position: absolute;
            width: 600px;
            height: 600px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.08) 0%, transparent 70%);
            top: -200px;
            right: -200px;
            border-radius: 50%;
        }
        body::after {
            content: '';
            position: absolute;
            width: 500px;
            height: 500px;
            background: radial-gradient(circle, rgba(212, 175, 55, 0.05) 0%, transparent 70%);
            bottom: -150px;
            left: -150px;
            border-radius: 50%;
        }
        
        /* ===== LOGIN CONTAINER ===== */
        .container {
            background: rgba(10, 10, 10, 0.85);
            backdrop-filter: blur(20px);
            border: 1px solid rgba(212, 175, 55, 0.2);
            padding: 50px 40px;
            border-radius: 24px;
            width: 100%;
            max-width: 440px;
            box-shadow: 0 25px 60px rgba(0,0,0,0.8), 0 0 40px rgba(212, 175, 55, 0.05);
            position: relative;
            z-index: 1;
        }
        
        /* ===== GOLD GLOW RING ===== */
        .container::before {
            content: '';
            position: absolute;
            inset: -2px;
            border-radius: 26px;
            background: linear-gradient(135deg, rgba(212, 175, 55, 0.3), transparent, rgba(212, 175, 55, 0.3));
            z-index: -1;
            opacity: 0.5;
        }
        
        /* ===== LOGO ===== */
        .logo {
            text-align: center;
            margin-bottom: 8px;
        }
        .logo h1 {
            font-family: 'Cinzel', serif;
            color: #fff;
            font-size: 34px;
            font-weight: 700;
            letter-spacing: 2px;
        }
        .logo h1 span { 
            color: var(--gold);
            text-shadow: 0 0 30px rgba(212, 175, 55, 0.3);
        }
        .logo p {
            color: rgba(255,255,255,0.5);
            font-size: 14px;
            margin-top: 5px;
            letter-spacing: 4px;
            text-transform: uppercase;
            font-weight: 300;
        }
        
        /* ===== GOLD LINE ===== */
        .gold-divider {
            width: 60px;
            height: 2px;
            background: linear-gradient(90deg, transparent, var(--gold), transparent);
            margin: 20px auto;
            border-radius: 10px;
        }
        
        .subtitle {
            text-align: center;
            color: rgba(255,255,255,0.4);
            font-size: 12px;
            margin-bottom: 30px;
            letter-spacing: 3px;
            text-transform: uppercase;
        }
        
        /* ===== FORM ===== */
        .form-group {
            margin-bottom: 20px;
        }
        .form-group label {
            display: block;
            color: rgba(255,255,255,0.6);
            font-size: 13px;
            font-weight: 500;
            margin-bottom: 8px;
            letter-spacing: 0.5px;
        }
        .form-group .input-wrapper {
            position: relative;
        }
        .form-group .input-wrapper i {
            position: absolute;
            left: 15px;
            top: 50%;
            transform: translateY(-50%);
            color: rgba(212, 175, 55, 0.4);
            font-size: 16px;
        }
        .form-group input {
            width: 100%;
            padding: 14px 15px 14px 45px;
            background: rgba(255,255,255,0.04);
            border: 1px solid rgba(212, 175, 55, 0.15);
            border-radius: 12px;
            color: #fff;
            font-size: 15px;
            transition: all 0.3s;
        }
        .form-group input:focus {
            outline: none;
            border-color: var(--gold);
            background: rgba(212, 175, 55, 0.05);
            box-shadow: 0 0 30px rgba(212, 175, 55, 0.05);
        }
        .form-group input::placeholder {
            color: rgba(255,255,255,0.2);
        }
        
        /* ===== BUTTON ===== */
        .btn {
            width: 100%;
            padding: 16px;
            background: linear-gradient(135deg, #d4af37, #a88920);
            color: #000;
            border: none;
            border-radius: 12px;
            font-size: 16px;
            font-weight: 600;
            cursor: pointer;
            transition: all 0.3s;
            margin-top: 10px;
            letter-spacing: 1px;
            display: flex;
            align-items: center;
            justify-content: center;
            gap: 10px;
        }
        .btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 15px 40px rgba(212, 175, 55, 0.4);
            background: linear-gradient(135deg, #f0d77b, #d4af37);
        }
        .btn i {
            font-size: 18px;
        }
        
        /* ===== ERROR ===== */
        .error {
            background: rgba(212, 175, 55, 0.08);
            border: 1px solid rgba(212, 175, 55, 0.2);
            color: #f0d77b;
            padding: 14px;
            border-radius: 12px;
            margin-bottom: 20px;
            text-align: center;
            font-size: 14px;
        }
        .error i {
            margin-right: 8px;
        }
        
        /* ===== DEMO BOX ===== */
        .demo-box {
            margin-top: 25px;
            padding: 20px;
            background: rgba(255,255,255,0.03);
            border-radius: 12px;
            border: 1px solid rgba(212, 175, 55, 0.08);
            text-align: center;
        }
        .demo-box p {
            color: rgba(255,255,255,0.3);
            font-size: 12px;
            letter-spacing: 2px;
            text-transform: uppercase;
        }
        .demo-box .creds {
            color: rgba(255,255,255,0.6);
            font-size: 14px;
            margin-top: 8px;
            font-weight: 500;
        }
        .demo-box .creds strong {
            color: var(--gold);
            font-weight: 600;
        }
        
        /* ===== BACK LINK ===== */
        .back-link {
            text-align: center;
            margin-top: 20px;
        }
        .back-link a {
            color: rgba(255,255,255,0.3);
            text-decoration: none;
            font-size: 14px;
            transition: color 0.3s;
        }
        .back-link a:hover {
            color: var(--gold);
        }
        .back-link a i {
            margin-right: 6px;
        }
        
        /* ===== FLOATING SHAPES ===== */
        .floating-shapes {
            position: absolute;
            width: 100%;
            height: 100%;
            top: 0;
            left: 0;
            overflow: hidden;
            pointer-events: none;
            z-index: 0;
        }
        .shape {
            position: absolute;
            border-radius: 50%;
            background: rgba(212, 175, 55, 0.03);
            animation: float 20s infinite;
        }
        .shape:nth-child(1) { width: 400px; height: 400px; top: -150px; right: -150px; animation-delay: 0s; }
        .shape:nth-child(2) { width: 300px; height: 300px; bottom: -100px; left: -100px; animation-delay: -5s; }
        .shape:nth-child(3) { width: 200px; height: 200px; top: 50%; left: 50%; transform: translate(-50%, -50%); animation-delay: -10s; }
        @keyframes float {
            0%, 100% { transform: translateY(0) scale(1); }
            50% { transform: translateY(-20px) scale(1.05); }
        }
        
        /* ===== RESPONSIVE ===== */
        @media (max-width: 480px) {
            .container { padding: 30px 20px; margin: 20px; }
            .logo h1 { font-size: 28px; }
        }
    </style>
</head>
<body>
    <!-- ===== FLOATING SHAPES ===== -->
    <div class="floating-shapes">
        <div class="shape"></div>
        <div class="shape"></div>
        <div class="shape"></div>
    </div>
    
    <!-- ===== LOGIN CONTAINER ===== -->
    <div class="container">
        <div class="logo">
            <h1> Noor e <span>Mehal</span></h1>
            <p>Admin Login</p>
        </div>
        <div class="gold-divider"></div>
        <div class="subtitle">Secure Admin Access</div>
        
        <?php if ($error): ?>
            <div class="error"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label><i class="fas fa-user"></i> Username</label>
                <div class="input-wrapper">
                    <i class="fas fa-user"></i>
                    <input type="text" name="username" placeholder="Enter admin username" required>
                </div>
            </div>
            
            <div class="form-group">
                <label><i class="fas fa-lock"></i> Password</label>
                <div class="input-wrapper">
                    <i class="fas fa-lock"></i>
                    <input type="password" name="password" placeholder="Enter admin password" required>
                </div>
            </div>
            
            <button type="submit" class="btn">
                <i class="fas fa-sign-in-alt"></i> Login to Dashboard
            </button>
        </form>
        
        <div class="demo-box">
            <p>Demo Credentials</p>
            <div class="creds">
                Username: <strong>admin</strong> &nbsp;|&nbsp; Password: <strong>admin123</strong>
            </div>
        </div>
        
        <div class="back-link">
            <a href="../index.php"><i class="fas fa-arrow-left"></i> Back to Website</a>
        </div>
    </div>
</body>
</html>