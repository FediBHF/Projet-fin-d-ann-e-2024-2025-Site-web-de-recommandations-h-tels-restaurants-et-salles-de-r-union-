<?php
require_once("../config/database.php");

function SearchEst($cnx, $query) {
  
    $index_path = "../controller/indexation/establishment_index.json";
    $python_script = "../controller/indexation/indexer.py";

    // if no index file, run indexer.py
    if (!file_exists($index_path)) {
        $python_cmd = "python " . escapeshellarg($python_script) . " 2>&1";
        exec($python_cmd, $output, $return_code);

        if ($return_code !== 0 || !file_exists($index_path)) {
            error_log("failed to generate index: " . implode("\n", $output));
            return [];
        }
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

    // Query the DB to get full data for those names
    $placeholders = rtrim(str_repeat('?,', count($matched_names)), ',');
    $sql = "SELECT * FROM Establishments WHERE name IN ($placeholders)";
    $stmt = $cnx->prepare($sql);
    $stmt->execute($matched_names);
    
    return $stmt->fetchAll(PDO::FETCH_ASSOC);
}
?>
