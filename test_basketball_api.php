<?php
$url = "https://api.balldontlie.io/v1/games?per_page=5";

$response = file_get_contents($url);
$data     = json_decode($response, true);

echo "<pre>";
print_r($data);
echo "</pre>";
?>
