<?php
#====================================FOR DETAILS CONTACT US
#	Office: FF-04, first floor, deans trade center, Peshawar cantt.
#	Phone: 091-5253258 | E-mail: Business@mcwnetwork.com
#====================================FOR DETAILS CONTACT US



#======================* START - Smile API Class

CLASS Smile_api
{
	
function get_session()
{
$username="68";	#Put your API Username here
$password="dw@123";	#Put your API Password here
	
$data=file_get_contents("http://api.smilesn.com/session?username=".$username."&password=".$password);
$data=json_decode($data);
$sessionid=$data->sessionid;

$file2 = fopen('session.txt', 'w');

$file1 = fopen('session.txt', 'a');
fputs($file1, $sessionid);
fclose($file1);

return $sessionid;
}
	


function send_sms($receivenum, $sendernum, $textmessage)
{
$receivenum=urlencode($receivenum);
$sendernum=urlencode($sendernum);
$textmessage=urlencode($textmessage);


$session_file = file("session.txt");
$session_id = trim($session_file[0]);

if(empty($session_id))
{
$session_id = $this->get_session();
}

$data=file_get_contents("http://api.smilesn.com/sendsms?sid=".$session_id."&receivenum=".$receivenum."&sendernum=8333&textmessage=".$textmessage);

$data2=json_decode($data);
$response_status=$data2->status;

#=====* START - IF SESSION EXPIRED IS RETURN, GENERATE ANOTHER SESSION & RETRY
if($response_status=="SESSION_EXPIRED")
{
$session_id = $this->get_session();
$data=file_get_contents("http://api.smilesn.com/sendsms?sid=".$session_id."&receivenum=".$receivenum."&sendernum=8333&textmessage=".$textmessage);
}
#=====* END - IF SESSION EXPIRED IS RETURN, GENERATE ANOTHER SESSION & RETRY

return $data;
}



function receive_sms()
{
$session_file = file("session.txt");
$session_id = trim($session_file[0]);

if(empty($session_id))
{
$session_id = $this->get_session();
}

$data=file_get_contents("http://api.smilesn.com/receivesms?sid=".$session_id);

$data2=json_decode($data);
$response_status=$data2->status;


#=====* START - IF SESSION EXPIRED IS RETURN, GENERATE ANOTHER SESSION & RETRY
if($response_status=="SESSION_EXPIRED")
{
$session_id = $this->get_session();
$data=file_get_contents("http://api.smilesn.com/receivesms?sid=".$session_id);
}
#=====* END - IF SESSION EXPIRED IS RETURN, GENERATE ANOTHER SESSION & RETRY


return $data;
}

/**
 * 
 * function to check quota
 * void()
 * 
 * */
 function getQuota()
 {
    $session_file = file("session.txt");
    $session_id = trim($session_file[0]);

    if(empty($session_id))
    {
        $session_id = $this->get_session();
    }
    $quota = file_get_contents('http://api.smilesn.com/check_quota?sid='.$session_id);
    $quota = json_decode($quota);
    if($quota->status == 'SESSION_EXPIRED')
    {
        $session_id = $this->get_session();
        $quota = file_get_contents('http://api.smilesn.com/check_quota?sid='.$session_id);
        $quota = json_decode($quota);
    }
    switch($quota->status)
    {
        case 'QUOTA_EXPIRED':
            return 'Quota expired';
        break;
        case 'LIMIT_REACHED':
            return 'Sms limit reached';
        break;
    }
    if(preg_match('/^[0-9]+$/', $quota->status))
    {
        return 'Remaining sms: '.$quota->status;
    }
    return $quota->status;
 }



function sendsms($mobile_number,$message){      
    
         $session_id = $this->get_session();
        $username = '68';
        $password = 'dw@123';

       echo  $url = "http://api.smilesn.com/sendsms?sid=".$session_id."&receivenum=".$mobile_number."&textmessage=".urlencode($message);
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
	
}
#======================* END - Smile API Class

$object_smile_api = new Smile_api();

//$object_smile_api->sendsms("03339639706","From Waseem khan");





?>