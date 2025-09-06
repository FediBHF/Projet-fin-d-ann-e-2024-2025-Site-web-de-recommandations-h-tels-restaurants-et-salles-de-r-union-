<?php
require_once("../config/database.php");

function SearchEst($cnx, $query) {
  
    $index_path = "../controller/indexation/establishment_index.json";

    if (!file_exists($index_path)) {
        return [];
    }

    $index = json_decode(file_get_contents($index_path), true);
    $query = strtolower(trim($query));
    $matched_names = [];

    // Find matching names from the index
    foreach ($index as $key => $establishments) {
        if (strpos($key, $query) !== false) {
            foreach ($establishments as $est) {
                $matched_names[] = $est['name'];
            }
        }
    }

    if (empty($matched_names)) return [];

    // Now query the DB to get full data for those names
    $placeholders = rtrim(str_repeat('?,', count($matched_names)), ',');
    $sql = "SELECT * FROM Establishments WHERE name IN ($placeholders)";
    $stmt = $cnx->prepare($sql);
    $stmt->execute($matched_names);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
