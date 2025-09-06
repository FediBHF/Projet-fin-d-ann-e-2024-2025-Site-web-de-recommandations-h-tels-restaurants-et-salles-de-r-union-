<?php
require_once '../config/database.php';

$output = [];
$return_var = 0;

$command = 'mvn -f ../controller/AI/json-java1 compile exec:java -Dexec.mainClass=com.example.Recommender';
exec($command, $output, $return_var);

$recommendedEstData = '../controller/AI/recommended_establishments.json';
$recommendedEstData = file_get_contents($recommendedEstData);
$establishmentIds = json_decode($recommendedEstData, true);

?>
