<?php
// Enhanced API Test with Cloudflare bypass headers 
$apiKey = '51037694-66b1-4372-8fb1-6177d2b37011_od1qpdz3b0kt3faez2n9ok7xexdvyi8vi1rujaggubrt6ow5nhz8f1j06s1yow12';
$apiUrl = 'https://skyfall.sellhub.cx/api/sellhub/products';

$ch = curl_init();
curl_setopt($ch, CURLOPT_URL, $apiUrl);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    // Set proper API headers per SellHub documentation
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Authorization: ' . $apiKey,  // API key alone, no 'Basic' prefix
        'Content-Type: application/json'
    ]);
    
    // Additional security for Cloudflare
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);

// Enable verbose output
curl_setopt($ch, CURLOPT_VERBOSE, true);
$verbose = fopen('php://temp', 'w+');
curl_setopt($ch, CURLOPT_STDERR, $verbose);

$response = curl_exec($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);

// Get debug info
rewind($verbose);
$verboseLog = stream_get_contents($verbose);

echo "<h2>Enhanced API Test Results</h2>";
echo "<h3>Request Details:</h3>";
echo "<pre>URL: $apiUrl</pre>";
echo "<pre>Headers: Authorization: [API_KEY_REDACTED]</pre>";

echo "<h3>Response:</h3>";
echo "<pre>HTTP Code: $httpCode</pre>";
echo "<pre>Response Body: " . htmlspecialchars($response) . "</pre>";

echo "<h3>Debug Info:</h3>";
echo "<pre>" . htmlspecialchars($verboseLog) . "</pre>";

curl_close($ch);
fclose($verbose);
?>