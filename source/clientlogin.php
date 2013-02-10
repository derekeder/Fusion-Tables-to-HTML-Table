<?php

class ClientLogin {
  public static function getAuthToken($username, $password) {
    $clientlogin_curl=curl_init();
    curl_setopt($clientlogin_curl,CURLOPT_URL,'https://www.google.com/accounts/ClientLogin');
    curl_setopt($clientlogin_curl, CURLOPT_POST, true); 
    curl_setopt ($clientlogin_curl, CURLOPT_POSTFIELDS,
      "Email=".$username."&Passwd=".$password."&service=fusiontables&accountType=GOOGLE");
    curl_setopt($clientlogin_curl,CURLOPT_CONNECTTIMEOUT,30);
    curl_setopt($clientlogin_curl,CURLOPT_TIMEOUT,30);
    curl_setopt($clientlogin_curl,CURLOPT_RETURNTRANSFER,1);
    $token = curl_exec($clientlogin_curl);
    curl_close($clientlogin_curl);
    $token_array = explode("=", $token);
    $token = str_replace("\n", "", $token_array[3]);
    return $token;
  }
}



class FTClientLogin {
  function __construct($token) {
    $this->token = $token;
  }
  
  function query($query) {
    
    $fusiontables_curl=curl_init();
    if(preg_match("/^select|^show tables|^describe/i", $query)) { 
      $query =  "sql=".urlencode($query)."&key=".ConnectionInfo::$googleApiKey;
      curl_setopt($fusiontables_curl,CURLOPT_URL,"https://www.googleapis.com/fusiontables/v1/query?".$query);
      curl_setopt($fusiontables_curl,CURLOPT_HTTPHEADER, array("Authorization: GoogleLogin auth=".$this->token));
    
    } else {
      $query = "sql=".urlencode($query)."&key=".ConnectionInfo::$googleApiKey;
      curl_setopt($fusiontables_curl,CURLOPT_POST, true);
      curl_setopt($fusiontables_curl,CURLOPT_URL,"https://www.googleapis.com/fusiontables/v1/query");
      curl_setopt($fusiontables_curl,CURLOPT_HTTPHEADER, array( 
        "Content-length: " . strlen($query), 
        "Content-type: application/x-www-form-urlencoded", 
        "Authorization: GoogleLogin auth=".$this->token         
      )); 
      curl_setopt($fusiontables_curl,CURLOPT_POSTFIELDS,$query); 
    }
    
    curl_setopt($fusiontables_curl,CURLOPT_CONNECTTIMEOUT,2);
    curl_setopt($fusiontables_curl,CURLOPT_RETURNTRANSFER,1);
    $result = curl_exec($fusiontables_curl);
    curl_close($fusiontables_curl);

    $json_result = json_decode($result);
    $rows = Array();
    if (array_key_exists('rows', $json_result))
      $rows = $json_result->{'rows'};

    $array_result = array_merge(array(array($json_result->{'columns'})), $rows);

    // returning as an array
    //echo var_dump($array_result);
    return $array_result;

    // This will return as a csv - not a good data format!
    // $csv_result = "";
    // foreach ($json_result->{'rows'} as $row) {
    //   foreach ($row as $field) {
    //     $csv_result .= $field.",";
    //   }
    //   $csv_result .= "\n";
    // }
    // echo $csv_result;
    // return $csv_result;
  }
}

?>