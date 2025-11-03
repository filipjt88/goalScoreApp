<?php
require 'db.php';

$apiKey   = '86a166ebe14c23ea3591d3934b47b439';
$leagueId = 2; // Primer: UEFA Champions League (možemo promeniti)
$season   = 2023;

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
$data     = json_decode($response, true);

echo "<pre>";
print_r($data);
echo "</pre>";
?>
