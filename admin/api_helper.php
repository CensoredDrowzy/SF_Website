<?php
// SellHub API Configuration
$apiKey = 'cec68c8f-c259-4b62-a7ef-7cdd81a03d9d_oi7vv55dn58wwom9fbmbl4xg99ixfdo2ni3zqo7ewd904dmvt8f0tbq8cvpqmzzv';
$apiBaseUrl = 'https://dash.sellhub.cx/api/sellhub';

// Function to make API requests
function sellhubApiRequest($method, $endpoint, $data = null) {
    $apiBaseUrl = 'https://dash.sellhub.cx/api/sellhub';
    $apiKey = 'cec68c8f-c259-4b62-a7ef-7cdd81a03d9d_oi7vv55dn58wwom9fbmbl4xg99ixfdo2ni3zqo7ewd904dmvt8f0tbq8cvpqmzzv';
    
    $url = $apiBaseUrl . $endpoint;
    $ch = curl_init();
    
    // Set cURL options
    curl_setopt_array($ch, [
        CURLOPT_URL => $url,
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_HTTPHEADER => [
            'Authorization: ' . $apiKey,
            'Content-Type: application/json',
            'Accept: application/json'
        ],
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_SSL_VERIFYHOST => 2
    ]);

    if ($method === 'POST') {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    } elseif ($method === 'GET') {
        curl_setopt($ch, CURLOPT_HTTPGET, true);
    }
    
    // Execute and get response
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    
    // Error handling
    if (curl_errno($ch)) {
        error_log('SellHub API Error: ' . curl_error($ch));
    }
    
    curl_close($ch);
    
    return [
        'status' => $httpCode,
        'data' => json_decode($response, true)
    ];
}

// Specific function to get store info
function getSellHubStoreInfo() {
    $response = sellhubApiRequest('GET', '/store');
    
    if ($response['status'] === 200) {
        return $response['data']['data']['store'] ?? null;
    }
    
    error_log('Failed to get store info. HTTP Code: ' . $response['status']);
    return null;
}

// Specific function to get products
function getSellHubProducts() {
    $response = sellhubApiRequest('GET', '/products');
    
    if ($response['status'] === 200) {
        return $response['data']['data']['products'] ?? [];
    }
    
    error_log('Failed to get products. HTTP Code: ' . $response['status']);
    return [];
}