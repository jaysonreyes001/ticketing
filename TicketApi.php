<?php

header('Access-Control-Allow-Origin: *');
header('Content-Type: application/json');
 
require_once 'include/utils/utils.php';
require_once 'config.inc.php';
global $adb;


// try {
//     // $tickets = $adb->pquery("SELECT *
//     // FROM `vtiger_troubletickets` a  ", array());

//     // $result = array(); 

//     // for ($x = 0; $x < $adb->num_rows($tickets); $x++) {
         
//     //     array_push($result,
//     //         array(
//     //             "title" => $adb->query_result($tickets,$x,"category"),                
//     //             "status" => $adb->query_result($tickets,$x,"status"),                 
//     //             "ticket_no" => $adb->query_result($tickets,$x,"ticket_no")
//     //         )
//     //     );
//     // }
//     // echo json_encode($result, JSON_PRETTY_PRINT);

//     $arr = array();
//     $result = $adb->pquery("select asd from `vtiger_users` where id = 1 ");
//     for($a = 0 ; $a < $adb->num_rows($result); $a++){
//         echo  $adb->query_result($result,$a,"last_name");

//     }


    

// } catch (Exception $ex) {
//     print_r($ex);
// }
if($_POST["action"] == "retrieve"){
    echo TicketApi::ticket_list();
}
else if($_POST["action"] == "delete"){
    echo TicketApi::delete_ticket(intval($_POST["id"]));
}
else if($_POST["action"] == "retrieve_one"){
    echo TicketApi::get_edit(intval($_POST["id"]));
}
else if($_POST["action"] == "update"){
    echo TicketApi::update_ticket(intval($_POST["id"]),$_POST["data"]);
}

Class TicketApi{
  
    public static function ticket_list(){
        global $adb;
      
       
    
try {

    $tickets = $adb->pquery("SELECT *,a.status
    FROM `vtiger_troubletickets` a left join `vtiger_crmentity` b on a.ticketid = b.crmid  ", array());

    $result = array(); 

    for ($x = 0; $x < $adb->num_rows($tickets); $x++) {
         
       $ownerid =  $adb->query_result($tickets,$x,"smownerid");
         

         array_push($result,
            array(
                "ticket_id" =>  $adb->query_result($tickets,$x,"ticketid"),
                "ticket_title" =>  $adb->query_result($tickets,$x,"title"),
                "ticket_priority" =>  $adb->query_result($tickets,$x,"priority"),
                "ticket_status" =>  $adb->query_result($tickets,$x,"status"),
                "assign_name" =>  TicketApi::checkowner($ownerid)
            )
        );
       
    }

    $api = array(
        "status" => "success",
        "result" => $result
    );
     return json_encode($api, JSON_PRETTY_PRINT);


} catch (Exception $ex) {
    print_r($ex);
}

    }

    public static function checkowner(Int $id){
        global $adb;
       $query = $adb->pquery("SELECT last_name from `vtiger_users` where id = $id ");
       $query2 = $adb->pquery("SELECT groupname from `vtiger_groups` where groupid = $id ");

       if($adb->num_rows($query) > 0){
          return  $adb->query_result($query,0,"last_name");
          
       }
       else{
        return  $adb->query_result($query2,0,"groupname");
       }
    }

    public  static function delete_ticket(Int $id){
        global $adb;    
        $query = $adb->pquery("delete from vtiger_troubletickets where ticketid = $id ");
        echo TicketApi::ticket_list();

    }

    public static function get_edit(String $id){
        
        global $adb;

        $query = $adb->pquery("SELECT *,a.status
        FROM `vtiger_troubletickets` a left join `vtiger_crmentity` b on a.ticketid = b.crmid where ticketid = '$id' ");
        $result = array();
        $data = array();

        if($adb->num_rows($query) > 0){

            for($a=0;$a<$adb->num_rows($query);$a++){
            $ownerid = $adb->query_result($query,$a,"smownerid");
            $data["ticket_id"] = $adb->query_result($query,$a,"ticketid");
            $data["ticket_title"] =$adb->query_result($query,$a,"title");
            $data["ticket_priority"] =$adb->query_result($query,$a,"priority");
            $data["ticket_status"] =$adb->query_result($query,$a,"status");
            $data["assign_name"] =TicketApi::checkowner($ownerid);
            }

        }
        else{

            $data["ticket_id"] = "";
            $data["ticket_title"] ="";
            $data["ticket_priority"] ="";
            $data["ticket_status"] ="";
            $data["assign_name"] ="";

        }

        $result[] = $data;
        
       
        echo json_encode($result,JSON_PRETTY_PRINT);
    }

    public static function update_ticket($id,$data){

        global $adb;
        $field_data = json_decode($data,true);

        $query = $adb->pquery("update `vtiger_troubletickets` set title = '{$field_data["ticket_title"]}',priority = '{$field_data["ticketpriorities"]}',
        status='{$field_data["ticketstatus"]}'  where ticketid = $id ");
        $query2 = $adb->pquery("update `vtiger_crmentity` set smownerid = '{$field_data["assigned_user_id"]}' where crmid = $id ");
        echo TicketApi::ticket_list();
    }

}


