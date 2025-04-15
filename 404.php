<?php
header("HTTP/1.0 404 Not Found");
require 'admin/api_helper.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyFall | Page Not Found</title>
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
            overflow-x: hidden;
        }
        .text-gradient {
            background: linear-gradient(90deg, var(--primary), var(--secondary));
            -webkit-background-clip: text;
            background-clip: text;
            color: transparent;
        }
        .glitch {
            animation: glitch 2s linear infinite;
        }
        @keyframes glitch {
            0% { transform: translate(0); }
            20% { transform: translate(-3px, 3px); }
            40% { transform: translate(-3px, -3px); }
            60% { transform: translate(3px, 3px); }
            80% { transform: translate(3px, -3px); }
            100% { transform: translate(0); }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="text-center p-8">
        <div class="text-6xl mb-6 text-gradient glitch">
            <i class="fas fa-exclamation-triangle"></i>
        </div>
        <h1 class="text-4xl font-bold mb-4 text-gradient">404 - PAGE NOT FOUND</h1>
        <p class="text-xl mb-8 max-w-md mx-auto">
            The page you're looking for doesn't exist or has been moved.
        </p>
        <a href="/" class="inline-block px-6 py-3 bg-gradient-to-r from-cyan-500 to-purple-500 text-black font-bold rounded-lg hover:opacity-90 transition">
            Return Home <i class="fas fa-arrow-right ml-2"></i>
        </a>
    </div>
</body>
</html>