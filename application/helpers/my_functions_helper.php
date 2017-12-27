<?php

/**
 * function to check module menu status and 
 * display the corresponding status
 * @param $menu_status integer
 * @return string
 */
 if(!function_exists('menu_status')){
    
    function menu_status($menu_status){
        if($menu_status == 1){
            return "<span class='label label-success'>Enabled</span>";
        }else{
            return "<span class='label label-danger'>Disabled</span>";
        }
    }
 }
 
 
 
 
 /**
 * function to check status and 
 * display the corresponding status
 * @param $status integer
 * @return string
 */
 if(!function_exists('status')){
    
    function status($status){
        if($status == 0){
            return "<span class='label label-default'>Draft</span>";
        }elseif($status == 1){
            return "<span class='label label-success'>Active</span>";
        }elseif($status == 2){
            return "<span class='label label-warning'>Inactive</span>";
        }elseif($status == 3){
            return "<span class='label label-danger'>Trash</span>";
        }else{
            return "<span class='label label-info'>Unkown</span>";
        }
    }
 }
 
 
 
 /**
  * function to check the database value of a radio and
  * conpare it against the the value of that radio and 
  * return checked="checked" if both are same
  * @param $db_value mixed database value of the radio
  * @param $current_value html value of radio
  * @return string checked="checked"
  */
 if(!function_exists('radio_checked')){
    
    function radio_checked($db_value, $current_value){
        
        if($db_value == $current_value){
            
            return "checked='checked'";
        }else{
            
            return "";
        }
    }
 }
 
 
 /**
  * function to compare current value with object's value and return
  * selected="selected" attribute for option list
  * @param $this_value mixed current value of iteration
  * @param $object_value mixed the value of the object
  * @return $attr string selected="selected"
  */
 if(!function_exists('sel_attr')){
    
    function sel_attr($this_value, $object_value){
        
        if($this_value == $object_value){
            return " selected='selected' ";
        }else{
            return "";
        }
    }
 }

   
         //-------------------------------------------------
//sms sending api and code------------------------------------------
   function get_session()
{
   $username="68"; #Put your API Username here
   $password="dw@123"; #Put your API Password here
    
   $data=file_get_contents("http://api.smilesn.com/session?username=".$username."&password=".$password);
   $data=json_decode($data);
   $sessionid=$data->sessionid;

   $file2 = fopen('session.txt', 'w');

   $file1 = fopen('session.txt', 'a');
   fputs($file1, $sessionid);
   fclose($file1);

   return $sessionid;
}
    
 function sendsms($mobile_number,$message)

{      
        
         $username = '68';
         $password = 'dw@123';
          $session_id =get_session();


        $url = "http://api.smilesn.com/sendsms?sid=".$session_id."&receivenum=".$mobile_number."&textmessage=".urlencode($message);
        $ch  =  curl_init();
        $timeout  =  1;
        $url = str_replace(" ", '%20', $url);
        curl_setopt ($ch,CURLOPT_URL, $url) ;
        curl_setopt ($ch,CURLOPT_RETURNTRANSFER, 1);
        curl_setopt ($ch,CURLOPT_CONNECTTIMEOUT, $timeout) ;
        $response = curl_exec($ch);
        curl_close($ch) ; 
        return true;
}
 