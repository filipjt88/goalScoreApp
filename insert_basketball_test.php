<?php
require 'db.php'; // Connect PDO

$league     = "NBA";
$home_team  = "Los Angeles Lakers";
$away_team  = "Golden State Warriors";
$home_score = 102;
$away_score = 99;
$match_date = "2025-10-24 19:00";

$sql = "INSERT INTO basketball_matches (league, home_team, away_team, home_score, away_score, match_date)
        VALUES (:league, :home_team, :away_team, :home_score, :away_score, :match_date)";

$stmt = $pdo->prepare($sql);

$stmt->execute([
    ':league'     => $league,
    ':home_team'  => $home_team,
    ':away_team'  => $away_team,
    ':home_score' => $home_score,
    ':away_score' => $away_score,
    ':match_date' => $match_date
]);

echo "Test basketball score entered!";
?>
