<?php
// Robust Product Scraper Solution
function getSellHubProducts() {
    $url = 'https://skyfall.sellhub.cx/?category=All#products';
    
    try {
        // Configure cURL with browser-like headers
        $ch = curl_init();
        $headers = [
            'User-Agent: Mozilla/5.0 (Windows NT 10.0; Win64; x64)',
            'Accept: text/html,application/xhtml+xml',
            'Accept-Language: en-US,en;q=0.9',
            'Connection: keep-alive'
        ];
        
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_HTTPHEADER, $headers);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
        curl_setopt($ch, CURLOPT_TIMEOUT, 15);

        $html = curl_exec($ch);
        $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
        curl_close($ch);

        if ($httpCode !== 200 || empty($html)) {
            throw new Exception("Failed to fetch products page. HTTP Code: $httpCode");
        }

        // Parse with DOMDocument
        $dom = new DOMDocument();
        @$dom->loadHTML($html);
        $xpath = new DOMXPath($dom);
        
        $products = [];
        $cards = $xpath->query("//div[contains(@class, 'product-card')]");
        
        foreach ($cards as $card) {
            $products[] = [
                'name' => trim($xpath->query(".//h3", $card)->item(0)->nodeValue ?? 'Unknown'),
                'price' => trim($xpath->query(".//span[contains(@class, 'price')]", $card)->item(0)->nodeValue ?? 'N/A'),
                'description' => trim($xpath->query(".//div[contains(@class, 'description')]", $card)->item(0)->nodeValue ?? '')
            ];
        }

        return $products;

    } catch (Exception $e) {
        error_log("Scraper Error: " . $e->getMessage());
        return [];
    }
}

// Display products
$products = getSellHubProducts();

if (empty($products)) {
    echo '<div class="error">Products currently unavailable. Please try again later.</div>';
} else {
    foreach ($products as $product) {
        echo '<div class="product">';
        echo '<h3>' . htmlspecialchars($product['name']) . '</h3>';
        echo '<div class="price">' . htmlspecialchars($product['price']) . '</div>';
        if (!empty($product['description'])) {
            echo '<div class="description">' . htmlspecialchars($product['description']) . '</div>';
        }
        echo '</div>';
    }
}
?>