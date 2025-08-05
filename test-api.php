<?php
/**
 * API Test Script
 * Run this script to test your API endpoints
 */

// Configuration
$baseUrl = 'https://staging.skornaments.com';
$apiUrl = $baseUrl . '/api';

// Test endpoints
$tests = [
    'Basic API Test' => $apiUrl . '/test',
    'Health Check' => $apiUrl . '/health',
    'Products API' => $apiUrl . '/v1/products',
    'Categories API' => $apiUrl . '/v1/categories',
];

// Function to make HTTP requests
function makeRequest($url, $method = 'GET', $data = null) {
    $ch = curl_init();
    
    curl_setopt($ch, CURLOPT_URL, $url);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);
    curl_setopt($ch, CURLOPT_TIMEOUT, 30);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        'Content-Type: application/json',
        'Accept: application/json',
        'User-Agent: API-Test-Script/1.0'
    ]);
    
    if ($method === 'POST' && $data) {
        curl_setopt($ch, CURLOPT_POST, true);
        curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($data));
    }
    
    $response = curl_exec($ch);
    $httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
    $error = curl_error($ch);
    
    curl_close($ch);
    
    return [
        'http_code' => $httpCode,
        'response' => $response,
        'error' => $error
    ];
}

// Function to test registration
function testRegistration($baseUrl) {
    $url = $baseUrl . '/api/v1/register';
    $data = [
        'name' => 'Test User ' . time(),
        'email' => 'test' . time() . '@example.com',
        'password' => 'password123',
        'password_confirmation' => 'password123'
    ];
    
    return makeRequest($url, 'POST', $data);
}

// Run tests
echo "🔍 Testing API Endpoints\n";
echo "========================\n\n";

foreach ($tests as $testName => $url) {
    echo "Testing: $testName\n";
    echo "URL: $url\n";
    
    $result = makeRequest($url);
    
    if ($result['error']) {
        echo "❌ Error: " . $result['error'] . "\n";
    } else {
        echo "📊 HTTP Code: " . $result['http_code'] . "\n";
        
        if ($result['http_code'] === 200) {
            echo "✅ Success!\n";
            $response = json_decode($result['response'], true);
            if ($response) {
                echo "📄 Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
            } else {
                echo "📄 Response: " . substr($result['response'], 0, 200) . "...\n";
            }
        } else {
            echo "❌ Failed!\n";
            echo "📄 Response: " . substr($result['response'], 0, 200) . "...\n";
        }
    }
    
    echo "\n" . str_repeat("-", 50) . "\n\n";
}

// Test registration
echo "Testing: User Registration\n";
echo "URL: " . $baseUrl . "/api/v1/register\n";

$regResult = testRegistration($baseUrl);

if ($regResult['error']) {
    echo "❌ Error: " . $regResult['error'] . "\n";
} else {
    echo "📊 HTTP Code: " . $regResult['http_code'] . "\n";
    
    if ($regResult['http_code'] === 201) {
        echo "✅ Registration Success!\n";
        $response = json_decode($regResult['response'], true);
        if ($response) {
            echo "📄 Response: " . json_encode($response, JSON_PRETTY_PRINT) . "\n";
        }
    } else {
        echo "❌ Registration Failed!\n";
        echo "📄 Response: " . substr($regResult['response'], 0, 200) . "...\n";
    }
}

echo "\n" . str_repeat("=", 50) . "\n";
echo "🎯 Test Summary\n";
echo "If you see 404 errors, follow the troubleshooting guide in API_TROUBLESHOOTING_GUIDE.md\n";
echo "If you see 200/201 responses, your API is working correctly!\n";