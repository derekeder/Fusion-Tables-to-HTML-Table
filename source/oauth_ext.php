<?php

define('SCOPE', 'https://www.googleapis.com/fusiontables/v1/query');
define('SERVER_URI', 'https://www.google.com');
define('GOOGLE_OAUTH_REQUEST_TOKEN_API', 'https://www.google.com/accounts/OAuthGetRequestToken');
define('GOOGLE_OAUTH_ACCESS_TOKEN_API', 'https://www.google.com/accounts/OAuthGetAccessToken');
define('GOOGLE_OAUTH_AUTHORIZE_API', 'https://www.google.com/accounts/OAuthAuthorizeToken');


class OAuthClientExt {
  
  public static function getAuthURL($consumer_key, $consumer_secret, $callback=null) {
    $oauth = new OAuth($consumer_key, $consumer_secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_URI);

		$request_token_info = $oauth->getRequestToken(GOOGLE_OAUTH_REQUEST_TOKEN_API . "?scope=".SCOPE,
													                        $callback);

		$request_token = $request_token_info["oauth_token"];
		$request_secret = $request_token_info["oauth_token_secret"];
		
	  return array("url" => "Location: ".GOOGLE_OAUTH_AUTHORIZE_API.
		       "?oauth_token=".$request_token.
		       "&scope=".SCOPE.
		       "&domain=".$consumer_key, 
		     "request_token" => $request_token,
		     "request_secret" => $request_secret);
  }
  
  public static function authorize($consumer_key, $consumer_secret, $request_token, $request_secret) {
    $oauth = new OAuth($consumer_key, $consumer_secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_FORM);
		$oauth->setToken($request_token, $request_secret);
		$access_token_info = $oauth->getAccessToken(GOOGLE_OAUTH_ACCESS_TOKEN_API);
		
		return array("access_token" => $access_token_info["oauth_token"],
		             "access_secret" => $access_token_info["oauth_token_secret"]);
  }
}

class FTOAuthClientExt {

  function __construct($consumer_key, $consumer_secret, $access_token, $access_secret) {
    $this->oauth = new OAuth($consumer_key, $consumer_secret, OAUTH_SIG_METHOD_HMACSHA1, OAUTH_AUTH_TYPE_FORM);
    $this->oauth->setToken($access_token, $access_secret);
  }
  
  function query($query) {
  
  	if(preg_match("/^SELECT|^SHOW|^DESCRIBE/i", $query)) {
  	  $this->oauth->setAuthType(OAUTH_AUTH_TYPE_URI);
	  } 
	  
	  try {
  	  $this->oauth->fetch(SCOPE, array('sql' => $query));
  	
  	} catch(OAuthException $e) {
  	  var_dump($e);
		  return null;
  	}
  	
	  $result = $this->oauth->getLastResponse();
	  return $result;
  }
}

?>