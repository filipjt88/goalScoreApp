<?php
require 'db.php'; // Include PDO connect

// Test data for a soccer match
$league = "Champions League";
$home_team = "Real Madrid";
$away_team = "Liverpool";
$home_score = 2;
$away_score = 1;
$match_date = "2025-10-24 20:45";

$sql = "INSERT INTO football_matches (league, home_team, away_team, home_score, away_score, match_date)
        VALUES (:league, :home_team, :away_team, :home_score, :away_score, :match_date)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':league' => $league,
    ':home_team' => $home_team,
    ':away_team' => $away_team,
    ':home_score' => $home_score,
    ':away_score' => $away_score,
    ':match_date' => $match_date
]);

echo "Test football score entered!";
?>
