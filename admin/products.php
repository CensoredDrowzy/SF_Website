<?php
session_start();
require_once 'api_helper.php';

if (!isset($_SESSION['admin_id'])) {
    header('Location: new_login.php');
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
            $empty_fields = [];
            if (empty($name)) $empty_fields[] = 'name';
            if (empty($description)) $empty_fields[] = 'description';
            if (empty($sellhub_id)) $empty_fields[] = 'sellhub_id';
            if (empty($price)) $empty_fields[] = 'price';
            if (empty($status)) $empty_fields[] = 'status';
            
            throw new Exception('Missing required fields: ' . implode(', ', $empty_fields));
        }

        // Create product via API
        $productData = [
            'name' => $name,
            'description' => $description,
            'category' => $category,
            'external_id' => $sellhub_id,
            'price' => $price,
            'features' => $features,
            'status' => $status
        ];

        $result = createSellHubProduct($productData);
        
        if ($result) {
            $_SESSION['product_success'] = 'Product added successfully to SellHub';
        } else {
            throw new Exception('Failed to create product via API');
        }
        
        header('Location: products.php');
        exit();
    } catch (Exception $e) {
        $_SESSION['product_error'] = $e->getMessage();
    }
}

// Get all products from API
$products = getSellHubProducts();
?>
<!DOCTYPE html>
<html>
<head>
    <title>Manage Products</title>
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
            <h1 class="text-3xl font-bold font-kanit text-gradient">Manage Products</h1>
            <a href="dashboard.php" class="cyber-btn px-6 py-2 text-black font-bold">
                <i class="fas fa-arrow-left mr-2"></i> Back to Dashboard
            </a>
        </div>

        <?php if (isset($_SESSION['product_success'])): ?>
            <div class="cyber-card p-4 mb-6 text-green-400">
                <?= htmlspecialchars($_SESSION['product_success']) ?>
            </div>
            <?php unset($_SESSION['product_success']); ?>
        <?php endif; ?>

        <?php if (isset($_SESSION['product_error'])): ?>
            <div class="cyber-card p-4 mb-6 text-red-400">
                <?= htmlspecialchars($_SESSION['product_error']) ?>
            </div>
            <?php unset($_SESSION['product_error']); ?>
        <?php endif; ?>

        <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
            <!-- Add Product Form -->
            <div class="cyber-card p-6">
                <h2 class="text-2xl font-bold font-kanit mb-6 text-gradient">Add New Product</h2>
                <form method="POST" class="space-y-4">
                    <div>
                        <label class="block text-cyan-300 mb-2">Product Name</label>
                        <input type="text" name="name" required class="w-full p-3 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-cyan-300 mb-2">Description</label>
                        <textarea name="description" required class="w-full p-3 rounded-lg" rows="3"></textarea>
                    </div>
                    <div>
                        <label class="block text-cyan-300 mb-2">Category</label>
                        <select name="category" required class="w-full p-3 rounded-lg">
                            <option value="fortnite">Fortnite</option>
                            <option value="call of duty">Call of Duty</option>
                            <option value="r6">Rainbow Six Siege</option>
                            <option value="Apex">Apex Legends</option>
                            <option value="Valorant">Valorant</option>
                            <option value="Spoofers">Spoofers</option>
                        </select>
                    </div>
                    <div>
                        <label class="block text-cyan-300 mb-2">SellHub Product ID</label>
                        <input type="text" name="sellhub_id" required class="w-full p-3 rounded-lg" 
                               placeholder="e.g. 3e77f619-d7e3-4e1a-9954-6fe5e688660a">
                    </div>
                    <div>
                        <label class="block text-cyan-300 mb-2">Price ($)</label>
                        <input type="number" name="price" step="0.01" required class="w-full p-3 rounded-lg">
                    </div>
                    <div>
                        <label class="block text-cyan-300 mb-2">Features (one per line)</label>
                        <textarea name="features" class="w-full p-3 rounded-lg" rows="3" 
                                  placeholder="Advanced Aimbot&#10;Wallhack & ESP&#10;No Recoil"></textarea>
                    </div>
                    <div>
                        <label class="block text-cyan-300 mb-2">Status</label>
                        <select name="status" required class="w-full p-3 rounded-lg">
                            <option value="UPDATED">UPDATED</option>
                            <option value="UNDETECTED">UNDETECTED</option>
                            <option value="DETECTED">DETECTED</option>
                        </select>
                    </div>
                    <button type="submit" class="cyber-btn px-6 py-3 text-black font-bold w-full">
                        <i class="fas fa-plus mr-2"></i> Add Product
                    </button>
                </form>
            </div>

            <!-- Product List -->
            <div class="cyber-card p-6">
                <h2 class="text-2xl font-bold font-kanit mb-6 text-gradient">Existing Products</h2>
                <div class="space-y-4">
                    <?php if (empty($products)): ?>
                        <p class="text-cyan-300">No products found</p>
                    <?php else: ?>
                        <?php foreach ($products as $product): ?>
                            <div class="cyber-card p-4">
                                <div class="flex justify-between items-start">
                                    <div>
                                        <h3 class="text-xl font-bold"><?= htmlspecialchars($product['name']) ?></h3>
                                        <p class="text-cyan-300"><?= htmlspecialchars($product['category']) ?> - $<?= htmlspecialchars($product['price']) ?></p>
                                    </div>
                                    <div class="flex space-x-2">
                                        <a href="edit_product.php?id=<?= $product['id'] ?>" class="px-3 py-1 bg-cyan-500/10 text-cyan-400 rounded">
                                            <i class="fas fa-edit"></i>
                                        </a>
                                        <a href="delete_product.php?id=<?= $product['id'] ?>" class="px-3 py-1 bg-red-500/10 text-red-400 rounded" onclick="return confirm('Delete this product?')">
                                            <i class="fas fa-trash"></i>
                                        </a>
                                    </div>
                                </div>
                                <div class="mt-2">
                                    <p class="text-cyan-100"><?= nl2br(htmlspecialchars($product['description'])) ?></p>
                                </div>
                                <div class="mt-3">
                                    <h4 class="text-sm font-bold text-cyan-300 mb-1">Features:</h4>
                                    <ul class="list-disc list-inside text-cyan-100">
                                        <?php foreach (explode("\n", $product['features']) as $feature): ?>
                                            <li><?= htmlspecialchars(trim($feature)) ?></li>
                                        <?php endforeach; ?>
                                    </ul>
                                </div>
                                    <div class="mt-4 pt-2 border-t border-cyan-500/20">
                                    <h4 class="text-sm font-bold text-cyan-300 mb-2">SellHub Integration:</h4>
                                    <p class="text-cyan-100 text-sm">Product ID: <?= htmlspecialchars($product['sellhub_id']) ?></p>
                                    <script type="module" src="https://public.sellhub.cx/embeds.js"></script>
                                </div>
                            </div>
                        <?php endforeach; ?>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</body>
</html>
<?php
// No database connection to close
?>
