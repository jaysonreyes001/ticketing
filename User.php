<?php


header("Access-Control-Allow-Origin: *");
header("Content-Type: application/json");

 
require_once 'include/utils/utils.php';
require_once 'config.inc.php';
global $adb;




try{


    $query=$adb->pquery("SELECT id,last_name as `name` from `vtiger_users` union SELECT groupid as id,groupname as `name` from `vtiger_groups` ");
    $result = array();
    for($a=0;$a < $adb->num_rows($query);$a++){
  
         array_push($result,
            array("id" => $adb->query_result($query,$a,"id"),
                "name" =>         $adb->query_result($query,$a,"name")
            )
        );

    }

    echo json_encode($result,JSON_PRETTY_PRINT);
   
}
catch(Exception $a){
    print_r($a);
}