<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AuthController extends Controller
{
    public function signin(Request $request){
        $username = $request["username"];
        $url = "http://localhost/vtigercrm/webservice.php?operation=getchallenge&username={$username}";
        $ch = curl_init();
        curl_setopt($ch,CURLOPT_URL,$url);
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        $reply = curl_exec($ch);
        curl_close($ch);
        
        $jsondata = json_decode($reply,true);
        
        if($jsondata["success"]){
            $accesskey = "Z32CkSVz1BXcuNxw";
            $token = $jsondata["result"]["token"];
            $md5 = md5($token.$accesskey);
           // $this->login($md5,$username);

            $ch=curl_init();
            $data_field = "operation=login&username={$username}&accessKey={$md5}";
            curl_setopt($ch,CURLOPT_URL,"http://localhost/vtigercrm/webservice.php");
            curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
            curl_setopt($ch,CURLOPT_POST,1);
            curl_setopt($ch,CURLOPT_POSTFIELDS,$data_field);
            curl_setopt($ch,CURLOPT_HTTPHEADER,array(
                'Content-Type:application/x-www-form-urlencoded'
            ));
            $api_reply = curl_exec($ch);
            curl_close($ch);
            
            $json = json_decode($api_reply,true);
            print_r($json);

            if($json["success"]){
                $user = $json["result"]["username"];
                $sessionid = $json["result"]["sessionName"];
                $session = array("username" => $user,"sessionid" => $sessionid);
                session($session);
                echo $sessionid;
              return redirect("/Home");
            }
            else{
                
                session(["error_message" => "Login Api Error!! Please try again "]);
                return redirect("/Login");
            }
            
        }
        else{
            session(["error_message" => "Username not Exist "]);
            return redirect("/Login");
        }
    }

    public function logout(Request $request){

        $ch=curl_init();
        $data_field = "operation=logout&sessionName{$request["id"]}";
        curl_setopt($ch,CURLOPT_URL,"http://localhost/vtigercrm/webservice.php");
        curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);
        curl_setopt($ch,CURLOPT_POST,1);
        curl_setopt($ch,CURLOPT_POSTFIELDS,$data_field);
        curl_setopt($ch,CURLOPT_HTTPHEADER,array(
            'Content-Type:application/x-www-form-urlencoded'
        ));
        $api_reply = curl_exec($ch);
        curl_close($ch);
        return redirect("/");

    }
}
