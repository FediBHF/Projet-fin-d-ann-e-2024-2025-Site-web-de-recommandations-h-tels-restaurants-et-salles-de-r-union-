<?php
require_once '../config/database.php';


$userId = $_SESSION['user_id'];

$userResult = $cnx->query("SELECT id, location FROM users WHERE id = $userId");
$user = $userResult->fetch(PDO::FETCH_ASSOC);

$estResult = $cnx->query("SELECT id_establishment, location, price, stars, type FROM establishments");
$establishments = $estResult->fetchAll(PDO::FETCH_ASSOC);

$data = [
    'user' => $user,
    'establishments' => $establishments
];

file_put_contents("../controller/AI/json-java1/data.json", json_encode($data, JSON_PRETTY_PRINT));

?>
