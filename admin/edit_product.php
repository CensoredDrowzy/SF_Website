<?php
session_start();
require_once 'new_db_config.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: new_login.php');
    exit();
}

// Get product ID
$product_id = $_GET['id'] ?? 0;
$product = $pdo->prepare("SELECT * FROM products WHERE id = ?");
$product->execute([$product_id]);
$product = $product->fetch();

if (!$product) {
    $_SESSION['product_error'] = 'Product not found';
    header('Location: products.php');
    exit();
}

// Handle form submission
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $name = trim($_POST['name']);
        $description = trim($_POST['description']);
        $category = trim($_POST['category']);
        $sellhub_id = trim($_POST['sellhub_id']);
    $price = trim($_POST['price']);
    $features = trim($_POST['features']);
    $status = trim($_POST['status']);

        // Validate inputs
        if (empty($name) || empty($description) || empty($sellhub_id) || empty($price) || empty($status)) {
            throw new Exception('All required fields must be filled');
        }

        // Update product
        $stmt = $pdo->prepare("UPDATE products SET name = ?, description = ?, category = ?, sellhub_id = ?, price = ?, features = ?, status = ? WHERE id = ?");
        $stmt->execute([$name, $description, $category, $sellhub_id, $price, $features, $status, $product_id]);

        $_SESSION['product_success'] = 'Product updated successfully';
        header('Location: products.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['product_error'] = $e->getMessage();
    }
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Edit Product</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600;800&family=Oxanium:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">
    <style>
        :root {
            --primary: #00f0ff;
            --secondary: #7b2dff;
            --dark: #0a0a14;
            --darker: #05050c;
        }
        body {
            background: radial-gradient(circle at center, var(--darker), var(--dark));
            color: #e0e0ff;
            font-family: 'Oxanium', sans-serif;
        }
        .cyber-card {
            background: rgba(10, 10, 20, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 240, 255, 0.2);
            border-radius: 16px;
        }
        .text-gradient {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        input, textarea, select {
            background: rgba(10, 10, 20, 0.6);
            border: 1px solid rgba(0, 240, 255, 0.25);
            color: #e0e0ff;
        }
    </style>
</head>
<body>
    <div class="container mx-auto px-4 py-8">
        <div class="flex justify-between items-center mb-8">
            <h1 class="text-3xl font-bold font-kanit text-gradient">Edit Product</h1>
            <a href="products.php" class="cyber-btn px-6 py-2 text-black font-bold">
                <i class="fas fa-arrow-left mr-2"></i> Back to Products
            </a>
        </div>

        <?php if (isset($_SESSION['product_error'])): ?>
            <div class="cyber-card p-4 mb-6 text-red-400">
                <?= htmlspecialchars($_SESSION['product_error']) ?>
            </div>
            <?php unset($_SESSION['product_error']); ?>
        <?php endif; ?>

        <div class="cyber-card p-6">
            <form method="POST" class="space-y-4">
                <div>
                    <label class="block text-cyan-300 mb-2">Product Name</label>
                    <input type="text" name="name" value="<?= htmlspecialchars($product['name']) ?>" required class="w-full p-3 rounded-lg">
                </div>
                <div>
                    <label class="block text-cyan-300 mb-2">Description</label>
                    <textarea name="description" required class="w-full p-3 rounded-lg" rows="3"><?= htmlspecialchars($product['description']) ?></textarea>
                </div>
                <div>
                    <label class="block text-cyan-300 mb-2">Category</label>
                    <select name="category" required class="w-full p-3 rounded-lg">
                        <option value="fortnite" <?= $product['category'] === 'fortnite' ? 'selected' : '' ?>>Fortnite</option>
                        <option value="call of duty" <?= $product['category'] === 'call of duty' ? 'selected' : '' ?>>Call of Duty</option>
                        <option value="r6" <?= $product['category'] === 'r6' ? 'selected' : '' ?>>Rainbow Six Siege</option>
                        <option value="Apex" <?= $product['category'] === 'Apex' ? 'selected' : '' ?>>Apex Legends</option>
                        <option value="Valorant" <?= $product['category'] === 'Valorant' ? 'selected' : '' ?>>Valorant</option>
                        <option value="Spoofers" <?= $product['category'] === 'Spoofers' ? 'selected' : '' ?>>Spoofers</option>
                    </select>
                </div>
                <div>
                    <label class="block text-cyan-300 mb-2">SellHub Product ID</label>
                    <input type="text" name="sellhub_id" value="<?= htmlspecialchars($product['sellhub_id']) ?>" required class="w-full p-3 rounded-lg">
                </div>
                <div>
                    <label class="block text-cyan-300 mb-2">Price ($)</label>
                    <input type="number" name="price" step="0.01" value="<?= htmlspecialchars($product['price']) ?>" required class="w-full p-3 rounded-lg">
                </div>
                <div>
                    <label class="block text-cyan-300 mb-2">Features (one per line)</label>
                    <textarea name="features" class="w-full p-3 rounded-lg" rows="3"><?= htmlspecialchars($product['features']) ?></textarea>
                </div>
                <div>
                    <label class="block text-cyan-300 mb-2">Status</label>
                    <select name="status" required class="w-full p-3 rounded-lg">
                        <option value="UNDETECTED" <?= $product['status'] === 'UNDETECTED' ? 'selected' : '' ?>>UNDETECTED</option>
                        <option value="UPDATED" <?= $product['status'] === 'UPDATED' ? 'selected' : '' ?>>UPDATED</option>
                        <option value="DETECTED" <?= $product['status'] === 'DETECTED' ? 'selected' : '' ?>>DETECTED</option>
                    </select>
                </div>
                <button type="submit" class="cyber-btn px-6 py-3 text-black font-bold w-full">
                    <i class="fas fa-save mr-2"></i> Save Changes
                </button>
            </form>
        </div>
    </div>
</body>
</html>
<?php
// Close database connection
$pdo = null;
?>