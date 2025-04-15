<?php
session_start();
if (isset($_SESSION['admin_id'])) {
    header('Location: dashboard.php');
    exit();
}

// Generate CSRF token
if (empty($_SESSION['csrf_token'])) {
    $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyFall Admin Login</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Kanit:wght@400;600;800&family=Oxanium:wght@400;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
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
            background: rgba(10, 10, 20, 0.6);
            backdrop-filter: blur(10px);
            border: 1px solid rgba(0, 240, 255, 0.1);
            transition: all 0.3s ease;
        }
        .cyber-card:hover {
            transform: translateY(-5px);
            box-shadow: 0 15px 30px rgba(0, 240, 255, 0.1);
            border-color: rgba(0, 240, 255, 0.3);
        }
        .text-gradient {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        input {
            background: rgba(10, 10, 20, 0.5);
            border: 1px solid rgba(0, 240, 255, 0.2);
            color: #e0e0ff;
        }
        input:focus {
            border-color: var(--primary);
            box-shadow: 0 0 0 2px rgba(0, 240, 255, 0.3);
            outline: none;
        }
        .error-message {
            background: rgba(255, 0, 0, 0.1);
            border: 1px solid rgba(255, 0, 0, 0.3);
        }
    </style>
</head>
<body class="flex items-center justify-center p-4">
    <div class="cyber-card rounded-xl p-6 sm:p-8 max-w-md w-full mx-4 sm:mx-auto">
        <div class="text-center mb-6 sm:mb-8">
            <div class="w-12 h-12 sm:w-16 sm:h-16 bg-cyan-500 rounded-full flex items-center justify-center mx-auto mb-3 sm:mb-4">
                <i class="fas fa-lock text-xl sm:text-2xl text-black"></i>
            </div>
            <h1 class="text-2xl sm:text-3xl font-bold font-kanit mb-1 sm:mb-2 text-gradient">
                SKYFALL ADMIN
            </h1>
            <p class="text-cyan-300 text-sm sm:text-base">Enter your credentials to continue</p>
        </div>
        
        <?php if (isset($_SESSION['login_error'])): ?>
            <div class="error-message p-4 rounded-lg mb-6 text-red-400">
                <i class="fas fa-exclamation-circle mr-2"></i>
                <?= htmlspecialchars($_SESSION['login_error']) ?>
            </div>
            <?php unset($_SESSION['login_error']); ?>
        <?php endif; ?>

        <form action="authenticate.php" method="POST" class="space-y-6">
            <input type="hidden" name="csrf_token" value="<?= htmlspecialchars($_SESSION['csrf_token']) ?>">
            <div>
                <label for="username" class="block text-cyan-300 mb-2">Username</label>
                <input type="text" id="username" name="username" 
                       class="w-full px-3 py-2 sm:px-4 sm:py-3 rounded-lg placeholder-cyan-500/70 text-sm sm:text-base" 
                       placeholder="Enter admin username" required>
            </div>
            
            <div>
                <label for="password" class="block text-cyan-300 mb-2">Password</label>
                <input type="password" id="password" name="password" 
                       class="w-full px-4 py-3 rounded-lg placeholder-cyan-500/70" 
                       placeholder="Enter your password" required>
            </div>
            
                    <button type="submit" 
                            class="cyber-btn w-full py-2 sm:py-3 px-3 sm:px-4 text-black font-bold text-sm sm:text-base">
                        LOGIN <i class="fas fa-sign-in-alt ml-2"></i>
                    </button>
        </form>
        
        <div class="mt-6 text-center text-sm text-cyan-500/80">
            <a href="#" class="hover:text-cyan-300">Forgot password?</a>
        </div>
    </div>
</body>
</html>