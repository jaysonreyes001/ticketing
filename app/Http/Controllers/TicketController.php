<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class TicketController extends Controller
{
    public function save_ticket(Request $request){
        $column = array("ticket_title","ticketstatus","ticketpriorities","assigned_user_id");
        $field = array();
        foreach($column as $col){
            $field[$col] = $request[$col];
        }
        $field = json_encode($field);

        if($request["ticket_id"] != ""){


            $ch = curl_init();
            curl_setopt($ch,CURLOPT_URL,"http://localhost/vtigercrm/TicketApi.php");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,array("action" => "update","id"=>$request["ticket_id"],"data" => $field ));
            $api_reply2 = curl_exec($ch);
            curl_close($ch); 
    

        }
        else{

        $id = session('sessionid');
        $data_field = "operation=create&sessionName={$id}&element={$field}&elementType=HelpDesk";
        
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"http://localhost/vtigercrm/webservice.php");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data_field);
            curl_setopt($ch,CURLOPT_HTTPHEADER,array(
                'Content-Type:application/x-www-form-urlencoded'
            ));
            $api_reply = curl_exec($ch);
            curl_close($ch);
            $jsondata = json_decode($api_reply,true);
            echo $id;
            echo $api_reply;
      
          //  session(["error_message" => $jsondata["error"]["message"]]);
            
    
        }
        return redirect("Home");
    }

    public function get_single_ticket($id=null){

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"http://localhost/vtigercrm/User.php");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $api_reply = curl_exec($ch);
        curl_close($ch); 



        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"http://localhost/vtigercrm/TicketApi.php");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,array("action" => "retrieve_one","id"=>$id));
        $api_reply2 = curl_exec($ch);
        curl_close($ch); 


        $UserData = json_decode($api_reply,true);
        $jsonData = json_decode($api_reply2,true);

        $data = array("select_users" => $UserData,"ticket_data" => $jsonData,"ticket_id" => $id);
    
       return view("contents/ticket_manage",$data);
        
    }

    public function display_ticket(){
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"http://localhost/vtigercrm/TicketApi.php");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,array("action" => "retrieve"));
        $api_reply = curl_exec($ch);
        curl_close($ch); 

        $this->display_datatable($api_reply);
      
    }




    public function delete_ticket(Request $request){

        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,"http://localhost/vtigercrm/TicketApi.php");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,array("action" => "delete","id" => $request["id"]));
        $api_reply = curl_exec($ch);
        curl_close($ch); 
       
       $this->display_datatable($api_reply);

       return redirect("Home");

    }


public function display_datatable(String $api_reply){

    $jsonData = json_decode($api_reply,true);
    if($jsonData["status"] == "success"){
        $data = array();
        $count = count($jsonData["result"]);
        for($a = 0; $a < $count; $a++){
            $sub_data = array();
            $btn = "";
            foreach($jsonData["result"][$a] as $key => $val){
                $sub_data[] = $val;

                if($key == "ticket_id"){
                    $btn = "<a href= 'Dashboard/TicketManage/{$val}' class='btn btn-warning btn-sm'>Edit</a>&nbsp;&nbsp;<a href= '/Ticket/Delete/{$val}' class='btn btn-danger btn-sm'>Delete</a>";
                }
            
            }
            $sub_data[] = $btn;
            $data[] = $sub_data;
        }
      $output["data"] = $data;
      echo json_encode($output);
  
    }

}


}

