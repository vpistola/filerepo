<?php

require_once "functions.php"; 

if(!empty($_POST['action']) && $_POST['action'] == 'fetch') {
    fetch();
}


function fetch()
{
    global $pdo;
    $resp = array();
    $result = array();
    $sql= "SELECT * FROM Data";
    $stmt = $pdo->query($sql);
    
    try {
        $result = $stmt->fetchAll();
    } catch(PDOException $err) {
        echo $err->getMessage();
    }

    foreach($result as $row){
        //$tmp = array();
        //$tmp = $row;
        $id = $row['Id'];
        $r = fetchDataFiles($id);
        //array_push($tmp, $r);
        $merge = array_merge($row, $r);
        array_push($resp, $merge);
    }
    
    echo json_encode($resp);
}



?>