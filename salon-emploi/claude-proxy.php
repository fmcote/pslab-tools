<?php
// P&S Lab - Claude API Proxy
// Déposer dans : public_html/salon-emploi/claude-proxy.php

header('Content-Type: application/json');
header('Access-Control-Allow-Origin: https://pscreativelab.ca');
header('Access-Control-Allow-Methods: POST, OPTIONS');
header('Access-Control-Allow-Headers: Content-Type');

if ($_SERVER['REQUEST_METHOD'] === 'OPTIONS') {
    http_response_code(200);
    exit();
}

if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(['error' => 'Method not allowed']);
    exit();
}

// Clé API — ne jamais exposer côté client
define('ANTHROPIC_API_KEY', getenv('ANTHROPIC_API_KEY') ?: 'METTRE_CLE_ICI');

$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    http_response_code(400);
    echo json_encode(['error' => 'Invalid JSON']);
    exit();
}

// Rate limiting simple par IP (optionnel mais recommandé)
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rate_file = sys_get_temp_dir() . '/pslab_rate_' . md5($ip) . '.json';
$now = time();
$window = 3600; // 1 heure
$max_requests = 20; // max 20 analyses par IP par heure

if (file_exists($rate_file)) {
    $rate_data = json_decode(file_get_contents($rate_file), true);
    $rate_data['requests'] = array_filter($rate_data['requests'] ?? [], fn($t) => $t > $now - $window);
    if (count($rate_data['requests']) >= $max_requests) {
        http_response_code(429);
        echo json_encode(['error' => 'Trop de requêtes. Réessaie dans une heure.']);
        exit();
    }
    $rate_data['requests'][] = $now;
} else {
    $rate_data = ['requests' => [$now]];
}
file_put_contents($rate_file, json_encode($rate_data));

// Appel API Anthropic
$payload = [
    'model'      => 'claude-sonnet-4-20250514',
    'max_tokens' => 2000,
    'system'     => $input['system'] ?? '',
    'messages'   => $input['messages'] ?? [],
];

$ch = curl_init('https://api.anthropic.com/v1/messages');
curl_setopt_array($ch, [
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_POST           => true,
    CURLOPT_POSTFIELDS     => json_encode($payload),
    CURLOPT_HTTPHEADER     => [
        'Content-Type: application/json',
        'x-api-key: ' . ANTHROPIC_API_KEY,
        'anthropic-version: 2023-06-01',
    ],
    CURLOPT_TIMEOUT        => 60,
]);

$response = curl_exec($ch);
$http_code = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

http_response_code($http_code);
echo $response;
