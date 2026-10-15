<?php
// admin/add_book_services.php
require_once '../config/db.php';

if (!isset($_SESSION['admin_logged_in']) || $_SESSION['admin_logged_in'] !== true) {
    header('Location: login.php');
    exit();
}

$id = isset($_GET['id']) ? (int)$_GET['id'] : 0;
$is_edit = $id > 0;

$service = null;
if ($is_edit) {
    $stmt = $pdo->prepare("SELECT * FROM services WHERE id = ?");
    $stmt->execute([$id]);
    $service = $stmt->fetch();
    if (!$service) {
        header('Location: index.php#services');
        exit();
    }
}

$error = '';
$success = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $service_name = trim($_POST['service_name']);
    $description = trim($_POST['description']);
    $price = (float)$_POST['price'];
    $category = trim($_POST['category']);
    $status = $_POST['status'];
    
    if (empty($service_name) || empty($price)) {
        $error = 'Service name and price are required';
    } else {
        if ($is_edit) {
            $stmt = $pdo->prepare("UPDATE services SET service_name = ?, description = ?, price = ?, category = ?, status = ? WHERE id = ?");
            $stmt->execute([$service_name, $description, $price, $category, $status, $id]);
            $success = 'Service updated successfully!';
        } else {
            $stmt = $pdo->prepare("INSERT INTO services (service_name, description, price, category, status) VALUES (?, ?, ?, ?, ?)");
            $stmt->execute([$service_name, $description, $price, $category, $status]);
            $success = 'Service added successfully!';
        }
        header("refresh:2;url=index.php#services");
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?php echo $is_edit ? 'Edit' : 'Add'; ?> Service - Admin</title>
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
        textarea { resize: vertical; min-height: 80px; }
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
        <h1><?php echo $is_edit ? '✏️ Edit' : '➕ Add'; ?> <span>Service</span></h1>
        <p class="subtitle"><?php echo $is_edit ? 'Update service details' : 'Add a new service'; ?></p>
        
        <?php if ($error): ?>
            <div class="error"><i class="fas fa-exclamation-circle"></i> <?php echo $error; ?></div>
        <?php endif; ?>
        <?php if ($success): ?>
            <div class="success"><i class="fas fa-check-circle"></i> <?php echo $success; ?></div>
        <?php endif; ?>
        
        <form method="POST" action="">
            <div class="form-group">
                <label>Service Name <span class="required">*</span></label>
                <input type="text" name="service_name" required value="<?php echo $service ? htmlspecialchars($service['service_name']) : ''; ?>" placeholder="e.g., Bridal Makeup">
            </div>
            <div class="form-group">
                <label>Category</label>
                <select name="category">
                    <option value="Decor" <?php echo $service && $service['category'] == 'Decor' ? 'selected' : ''; ?>>Decor</option>
                    <option value="Food" <?php echo $service && $service['category'] == 'Food' ? 'selected' : ''; ?>>Food</option>
                    <option value="Media" <?php echo $service && $service['category'] == 'Media' ? 'selected' : ''; ?>>Media</option>
                    <option value="Beauty" <?php echo $service && $service['category'] == 'Beauty' ? 'selected' : ''; ?>>Beauty</option>
                    <option value="Entertainment" <?php echo $service && $service['category'] == 'Entertainment' ? 'selected' : ''; ?>>Entertainment</option>
                    <option value="Venue" <?php echo $service && $service['category'] == 'Venue' ? 'selected' : ''; ?>>Venue</option>
                    <option value="Other" <?php echo $service && $service['category'] == 'Other' ? 'selected' : ''; ?>>Other</option>
                </select>
            </div>
            <div class="form-group">
                <label>Price (PKR) <span class="required">*</span></label>
                <input type="number" name="price" required min="0" step="100" value="<?php echo $service ? $service['price'] : ''; ?>" placeholder="0">
            </div>
            <div class="form-group">
                <label>Description</label>
                <textarea name="description" placeholder="Service description"><?php echo $service ? htmlspecialchars($service['description']) : ''; ?></textarea>
            </div>
            <div class="form-group">
                <label>Status</label>
                <select name="status">
                    <option value="active" <?php echo $service && $service['status'] == 'active' ? 'selected' : ''; ?>>Active</option>
                    <option value="inactive" <?php echo $service && $service['status'] == 'inactive' ? 'selected' : ''; ?>>Inactive</option>
                </select>
            </div>
            <button type="submit" class="btn"><i class="fas fa-save"></i> <?php echo $is_edit ? 'Update' : 'Add'; ?> Service</button>
        </form>
        
        <div class="back-link">
            <a href="index.php#services"><i class="fas fa-arrow-left"></i> Back to Dashboard</a>
        </div>
    </div>
</body>
</html>