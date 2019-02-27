<?php

class Main{
 //$this->

//------- start apiUrl
public function apiUrl($command){
    global $TOKEN;
    return "https://api.telegram.org/bot$TOKEN/$command";
}
//------- end apiUrl

//------- start sendCommand
public function sendCommand($command,$data=false,$fullReturn=false){
    //if data is not given, use GET method
    if(!$data){
        $url = $this->apiUrl($command);
        $result = file_get_contents($url);
        $result = json_decode($result,true);
        return $fullReturn ? $result : $result["result"];
    }
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $this->apiUrl($command));
    curl_setopt($ch, CURLOPT_POST, count($data));
    curl_setopt($ch, CURLOPT_POSTFIELDS,$data);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER,true);
    $result = curl_exec($ch);
    curl_close($ch);
    return $result;
}
//------- end sendCommand

// start RandomString
public function RandomString($data = "")
    {
        $key = 'J$T>cv-C/d(5bL$Z';
        $ciphertext = @openssl_encrypt(
            pack('L', intval($data)),
            'aes-256-ctr',
            $key
        );

        return rtrim(strtr($ciphertext, '+/', '-_'), '=');
    }
// end RandomString
}