<?php
require 'db.php';

$apiKey = '86a166ebe14c23ea3591d3934b47b439';
$leagueId = 2; // Champions League
$season = 2023;

$url = "https://v3.football.api-sports.io/fixtures?league=$leagueId&season=$season";

$curl = curl_init();
curl_setopt_array($curl, [
    CURLOPT_URL => $url,
    CURLOPT_RETURNTRANSFER => true,
    CURLOPT_HTTPHEADER => [
        "x-apisports-key: $apiKey",
        "x-rapidapi-host: v3.football.api-sports.io"
    ]
]);
$response = curl_exec($curl);
curl_close($curl);

$data = json_decode($response, true);

if (!empty($data['response'])) {
    $stmt = $pdo->prepare("
        INSERT INTO football_matches (league, home_team, away_team, home_score, away_score, match_date, source_api)
        VALUES (:league, :home_team, :away_team, :home_score, :away_score, :match_date, :source_api)
    ");

    foreach ($data['response'] as $match) {
        $league = $match['league']['name'] ?? 'Unknown';
        $home_team = $match['teams']['home']['name'] ?? '';
        $away_team = $match['teams']['away']['name'] ?? '';
        $home_score = $match['goals']['home'] ?? null;
        $away_score = $match['goals']['away'] ?? null;
        $match_date = $match['fixture']['date'] ?? '';
        $source_api = 'API-Football';

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

    echo "✅ Podaci uspešno ubačeni u bazu!";
} else {
    echo "⚠️ Nema podataka za uneti upit.";
}
?>
