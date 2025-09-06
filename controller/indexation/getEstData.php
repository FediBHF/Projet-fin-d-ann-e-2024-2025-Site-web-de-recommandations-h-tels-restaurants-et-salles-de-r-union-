<?php
    require_once("../../config/database.php");

    $req = "SELECT name, location, description FROM establishments";
    $res = $cnx->query($req);
    
    $establishments = [];
    if($res->rowCount() > 0) {
        while($row = $res->fetch(PDO::FETCH_ASSOC)) {
            $establishments[] = $row;
        }
    }
    $output = ["establishments" => $establishments];
    header('Content-Type:application/json');
    echo json_encode($output, JSON_UNESCAPED_UNICODE);
?>