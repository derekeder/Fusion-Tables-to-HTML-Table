<?php

include_once "oauth-php/library/OAuthStore.php";
include_once "oauth-php/library/OAuthRequester.php";

define('SCOPE', 'https://www.googleapis.com/fusiontables/v1/query');
define('SERVER_URI', 'https://www.google.com');
define('GOOGLE_OAUTH_REQUEST_TOKEN_API', 'https://www.google.com/accounts/OAuthGetRequestToken');
define('GOOGLE_OAUTH_ACCESS_TOKEN_API', 'https://www.google.com/accounts/OAuthGetAccessToken');
define('GOOGLE_OAUTH_AUTHORIZE_API', 'https://www.google.com/accounts/OAuthAuthorizeToken');


class OAuthClient {
  
  public static function storeServer($consumer_key, $consumer_secret, $store_type="MySQL", $user_id=1, $extra_options=array()) {
    //Set up the store for the user id. Only run this once.
    $options = OAuthClient::merge_options($consumer_key, $consumer_secret, $extra_options);
    $store = OAuthClient::storeInstance($consumer_key, $consumer_secret, $store_type="MySQL", $options);
  	$ckey = $store->updateServer($options, $user_id);
  }

  public static function getAuthURL($consumer_key, $consumer_secret, $store="MySQL", $user_id=1, $callback=null, $extra_options=array()) {
    //return the authorization URL. Redirect the header to this location.
    OAuthClient::storeInstance(OAuthClient::merge_options($consumer_key, $consumer_secret, $extra_options), $store);
  
    $getAuthTokenParams = array('scope' => 'https://www.googleapis.com/fusiontables/v1/query',
									              'oauth_callback' => $callback);

	  $tokenResultParams = OAuthRequester::requestRequestToken($consumer_key, $user_id, $getAuthTokenParams);

	  return "Location: ".GOOGLE_OAUTH_AUTHORIZE_API.
		     "?oauth_token=".$tokenResultParams['token'].
		     "&scope=".$getAuthTokenParams['scope'].
		     "&domain=".$consumer_key;
  }
  
  public static function authorize($consumer_key, $consumer_secret, $oauth_token, $verifier, $store="MySQL", $user_id=1, $extra_options=array()) {
    //Obtain an access token. This token can be reused until it expires.
		OAuthClient::storeInstance(OAuthClient::merge_options($consumer_key, $consumer_secret, $extra_options), $store);
		
	  try {
		  OAuthRequester::requestAccessToken($consumer_key, $oauth_token, $user_id, 'POST', array('oauth_token' => $oauth_token, 'oauth_verifier' => $verifier));
	
	  } catch (OAuthException2 $e) {
		  var_dump($e);
		  return;
	  }
  }
    
  public static function storeInstance($options, $store_type) {
    $store = OAuthStore::instance($store_type, $options);
    return $store;
  }
  
  public static function merge_options($consumer_key, $consumer_secret, $extra_options) {
    return array_merge(array(
      'signature_methods' => array('HMAC-SHA1', 'PLAINTEXT'),
      'server_uri' =>  SERVER_URI,
      'request_token_uri' =>  GOOGLE_OAUTH_REQUEST_TOKEN_API,
      'authorize_uri' =>  GOOGLE_OAUTH_AUTHORIZE_API,
      'access_token_uri' =>  GOOGLE_OAUTH_ACCESS_TOKEN_API
    ),
    array('consumer_key' => $consumer_key, 'consumer_secret' => $consumer_secret),
    $extra_options);
  }
}

class FTOAuthClient {

  function __construct($consumer_key, $consumer_secret, $store="MySQL", $user_id=1, $extra_options=array()) {
    $this->user_id = $user_id;
    OAuthClient::storeInstance(OAuthClient::merge_options($consumer_key, $consumer_secret, $extra_options), $store);
  }
  
  function query($query) {
  
  	if(preg_match("/^SELECT|^SHOW|^DESCRIBE/i", $query)) {
		  $request = new OAuthRequester("https://www.googleapis.com/fusiontables/v1/query?sql=".rawurlencode($query), 'GET');
		
	  } else {
		  $request = new OAuthRequester("https://www.googleapis.com/fusiontables/v1/query", 'POST', "sql=".rawurlencode($query));
		
	  }
	  $result = $request->doRequest($this->user_id);
	
	  if ($result['code'] == 200) {
		   return $result['body'];
	
	  } else {
		   return null;
	  }
		
  }

}

?>