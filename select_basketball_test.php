<?php
require 'db.php';

$sql     = "SELECT * FROM basketball_matches";
$stmt    = $pdo->query($sql);
$matches = $stmt->fetchAll();

echo "<pre>";
print_r($matches);
echo "</pre>";
?>
