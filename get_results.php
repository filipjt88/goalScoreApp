<?php
require 'db.php';

header('Content-Type: application/json; charset=utf-8');

$type = $_GET['type'] ?? 'all';

if ($type === 'football') {
    $stmt = $pdo->query("SELECT * FROM football_matches ORDER BY match_date DESC LIMIT 20");
    $results = $stmt->fetchAll();
    echo json_encode(['sport' => 'football', 'data' => $results]);
} elseif ($type === 'basketball') {
    $stmt = $pdo->query("SELECT * FROM basketball_matches ORDER BY match_date DESC LIMIT 20");
    $results = $stmt->fetchAll();
    echo json_encode(['sport' => 'basketball', 'data' => $results]);
} else {
    $football = $pdo->query("SELECT * FROM football_matches ORDER BY match_date DESC LIMIT 10")->fetchAll();
    $basketball = $pdo->query("SELECT * FROM basketball_matches ORDER BY match_date DESC LIMIT 10")->fetchAll();
    echo json_encode([
        'football' => $football,
        'basketball' => $basketball
    ]);
}
?>
