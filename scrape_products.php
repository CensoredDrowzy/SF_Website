<?php
// Temporary product scraper
$productsUrl = 'https://skyfall.sellhub.cx/?category=All#products';

// Get page HTML
$html = file_get_contents($productsUrl);
if ($html === false) {
    die("Failed to fetch products page");
}

// Parse products (simplified example)
preg_match_all('/<div class="product-card".*?>(.*?)<\/div>/s', $html, $matches);

if (empty($matches[0])) {
    echo "<div class='error'>No products found. Please check back later.</div>";
} else {
    foreach ($matches[0] as $productHtml) {
        // Extract product details
        preg_match('/<h3 class="product-name">(.*?)<\/h3>/', $productHtml, $name);
        preg_match('/<span class="product-price">(.*?)<\/span>/', $productHtml, $price);
        
        echo "<div class='product'>";
        echo "<h3>" . htmlspecialchars($name[1] ?? 'Product') . "</h3>";
        echo "<p>Price: " . htmlspecialchars($price[1] ?? 'N/A') . "</p>";
        echo "</div>";
    }
}
?>