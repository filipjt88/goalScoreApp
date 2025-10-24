<?php
require 'db.php';

$apiKey = 'acf6304e-d385-48e4-b542-2d5570ff2b6b'; // ubaci svoj ključ
$url = "https://api.balldontlie.io/v1/games?per_page=10";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "Authorization: Bearer $apiKey"
    ]
]);

$response = curl_exec($curl);
$httpCode = curl_getinfo($curl, CURLINFO_HTTP_CODE);
curl_close($curl);

if ($httpCode !== 200) {
    die("❌ API request failed! HTTP Code: $httpCode");
}

$data = json_decode($response, true);

if (!empty($data['data'])) {
    $stmt = $pdo->prepare("
        INSERT INTO basketball_matches (league, home_team, away_team, home_score, away_score, match_date, source_api)
        VALUES (:league, :home_team, :away_team, :home_score, :away_score, :match_date, :source_api)
    ");

    foreach ($data['data'] as $game) {
        $league = "NBA";
        $home_team = $game['home_team']['full_name'] ?? '';
        $away_team = $game['visitor_team']['full_name'] ?? '';
        $home_score = $game['home_team_score'] ?? null;
        $away_score = $game['visitor_team_score'] ?? null;
        $match_date = $game['date'] ?? '';
        $source_api = 'BallDontLie';

        $stmt->execute([
            ':league' => $league,
            ':home_team' => $home_team,
            ':away_team' => $away_team,
            ':home_score' => $home_score,
            ':away_score' => $away_score,
            ':match_date' => $match_date,
            ':source_api' => $source_api
        ]);
    }

    echo "✅ Košarkaški podaci uspešno ubačeni u bazu!";
} else {
    echo "⚠️ Nema dostupnih podataka.";
}
?>
