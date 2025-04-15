<?php
require 'admin/api_helper.php';
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>SkyFall | Maintenance</title>
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
        .maintenance-pulse {
            animation: pulse 2s infinite;
        }
        @keyframes pulse {
            0%, 100% { opacity: 1; }
            50% { opacity: 0.5; }
        }
    </style>
</head>
<body class="min-h-screen flex items-center justify-center">
    <div class="text-center p-8">
        <div class="text-6xl mb-6 text-gradient maintenance-pulse">
            <i class="fas fa-server"></i>
        </div>
        <h1 class="text-4xl font-bold mb-4 text-gradient">UNDER MAINTENANCE</h1>
        <p class="text-xl mb-8 max-w-md mx-auto">
            This page is currently being worked on by Drowzy. Please check back soon!
        </p>
        <div class="flex justify-center space-x-4">
            <div class="h-2 w-2 bg-cyan-500 rounded-full animate-bounce" style="animation-delay: 0s"></div>
            <div class="h-2 w-2 bg-cyan-500 rounded-full animate-bounce" style="animation-delay: 0.2s"></div>
            <div class="h-2 w-2 bg-cyan-500 rounded-full animate-bounce" style="animation-delay: 0.4s"></div>
        </div>
    </div>
</body>
</html>