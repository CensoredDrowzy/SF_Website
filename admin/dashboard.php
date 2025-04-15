<?php
session_start();
if (!isset($_SESSION['admin_id'])) {
    header('Location: new_login.php');
    exit();
}
?>
<!DOCTYPE html>
<html>
<head>
    <title>Admin Dashboard</title>
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
            min-height: 100vh;
        }
        .cyber-btn {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            clip-path: polygon(10% 0, 100% 0, 90% 100%, 0% 100%);
            transition: all 0.3s ease;
        }
        .cyber-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0, 240, 255, 0.3);
        }
        .cyber-card {
            background: rgba(10, 10, 20, 0.7);
            backdrop-filter: blur(16px);
            border: 1px solid rgba(0, 240, 255, 0.2);
            border-radius: 16px;
            transition: all 0.4s cubic-bezier(0.16, 1, 0.3, 1);
            box-shadow: 0 8px 32px rgba(0, 0, 0, 0.2);
        }
        .cyber-card:hover {
            transform: translateY(-6px);
            box-shadow: 0 12px 40px rgba(0, 240, 255, 0.15);
            border-color: rgba(0, 240, 255, 0.4);
        }
        .text-gradient {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        input {
            background: rgba(10, 10, 20, 0.6);
            border: 1px solid rgba(0, 240, 255, 0.25);
            border-radius: 8px;
            color: #e0e0ff;
            padding: 0.75rem;
            transition: all 0.3s ease;
        }
        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 3px rgba(0, 240, 255, 0.2);
            outline: none;
            background: rgba(10, 10, 20, 0.7);
        }
    </style>
</head>
<body>
    <header class="border-b border-cyan-500/20 py-4">
        <div class="container mx-auto px-6 flex justify-between items-center">
            <div class="flex items-center">
                <div class="w-10 h-10 bg-cyan-500 rounded-full flex items-center justify-center mr-3">
                    <i class="fas fa-bolt text-black"></i>
                </div>
                <h1 class="text-2xl font-bold font-kanit">
                    <span class="text-gradient">SKYFALL</span> ADMIN
                </h1>
            </div>
            <a href="logout.php" class="cyber-btn px-6 py-2 text-black font-bold">
                LOGOUT <i class="fas fa-sign-out-alt ml-2"></i>
            </a>
        </div>
    </header>

    <main class="container mx-auto px-4 sm:px-6 py-8 sm:py-12">
        <div class="cyber-card p-6 sm:p-8 rounded-xl max-w-4xl mx-auto">
            <h1 class="text-2xl sm:text-3xl font-bold font-kanit mb-4 sm:mb-6 text-gradient">Welcome, <?= htmlspecialchars($_SESSION['admin_username']) ?></h1>
            <p class="text-cyan-300 text-sm sm:text-base mb-6 sm:mb-8">You have successfully logged in to the admin panel.</p>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mt-8">
                <a href="products.php" class="cyber-card p-6 hover:border-cyan-500 transition">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-cyan-500/10 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-boxes text-2xl text-cyan-400"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Manage Products</h3>
                            <p class="text-cyan-300 text-sm">Add/edit game cheat products</p>
                        </div>
                    </div>
                </a>
                <div class="cyber-card p-6">
                    <div class="flex items-center">
                        <div class="w-12 h-12 bg-purple-500/10 rounded-lg flex items-center justify-center mr-4">
                            <i class="fas fa-key text-2xl text-purple-400"></i>
                        </div>
                        <div>
                            <h3 class="text-xl font-bold">Account Settings</h3>
                            <p class="text-cyan-300 text-sm">Change your password</p>
                        </div>
                    </div>
                </div>
            </div>
            
            <?php if (isset($_SESSION['password_change_success'])): ?>
                <div class="mt-3 p-4 sm:p-5 bg-green-900/60 text-green-300 rounded-xl border border-green-500/40 mb-4 sm:mb-6 text-sm sm:text-base backdrop-blur-sm">
                    <i class="fas fa-check-circle mr-2"></i> Password changed successfully!
                </div>
                <?php unset($_SESSION['password_change_success']); ?>
            <?php elseif (isset($_SESSION['password_change_error'])): ?>
                <div class="mt-4 p-4 sm:p-5 bg-red-900/60 text-red-300 rounded-xl border border-red-500/40 mb-6 backdrop-blur-sm">
                    <i class="fas fa-exclamation-circle mr-2"></i> Error: <?= htmlspecialchars($_SESSION['password_change_error']) ?>
                </div>
                <?php unset($_SESSION['password_change_error']); ?>
            <?php endif; ?>

            <div class="mt-6 sm:mt-8 border-t border-cyan-500/20 pt-4 sm:pt-6">
                <h2 class="text-lg sm:text-xl font-bold font-kanit mb-3 sm:mb-4 text-gradient">Change Password</h2>
                <form action="change_password.php" method="POST" class="space-y-4 sm:space-y-6">
                    <div>
                        <label for="current_password" class="block text-xs sm:text-sm font-medium text-cyan-300 mb-1 sm:mb-2">Current Password</label>
                        <input type="password" name="current_password" required 
                               class="mt-1 block w-full rounded-md p-2 sm:p-3 text-sm">
                    </div>
                    <div>
                        <label for="new_password" class="block text-sm font-medium text-cyan-300 mb-2">New Password</label>
                        <input type="password" name="new_password" required minlength="8"
                               class="mt-1 block w-full rounded-md p-2 sm:p-3 text-sm">
                        <p class="mt-1 sm:mt-2 text-xs sm:text-sm text-cyan-500/80">Minimum 8 characters</p>
                    </div>
                    <div>
                        <label for="confirm_password" class="block text-sm font-medium text-cyan-300 mb-2">Confirm New Password</label>
                        <input type="password" name="confirm_password" required
                               class="mt-1 block w-full rounded-md p-2 sm:p-3 text-sm">
                    </div>
                    <button type="submit" 
                            class="cyber-btn px-4 sm:px-6 py-2 sm:py-3 text-black font-bold text-base sm:text-lg w-full mt-4 sm:mt-6">
                        CHANGE PASSWORD <i class="fas fa-lock ml-2"></i>
                    </button>
                </form>
            </div>
        </div>
    </main>

    <footer class="border-t border-cyan-500/20 py-6 mt-12">
        <div class="container mx-auto px-6 text-center text-cyan-500/80">
            <p>&copy; 2023 SkyFall. All rights reserved.</p>
        </div>
    </footer>
</body>
</html>