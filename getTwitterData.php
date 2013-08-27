<?php
ob_start();
require("twitter/twitteroauth.php");
require 'config/twconfig.php';
ini_set("session.gc_maxlifetime","7200");  
session_start();

if (!empty($_GET['oauth_verifier']) && !empty($_SESSION['oauth_token']) && !empty($_SESSION['oauth_token_secret'])) {
    // We've got everything we need
    $twitteroauth = new TwitterOAuth(YOUR_CONSUMER_KEY, YOUR_CONSUMER_SECRET, $_SESSION['oauth_token'], $_SESSION['oauth_token_secret']);
// Let's request the access token
    $access_token = $twitteroauth->getAccessToken($_GET['oauth_verifier']);
// Save it in a session var
    $_SESSION['access_token'] = $access_token;
// Let's get the user's info
    $user_info = $twitteroauth->get('account/verify_credentials');
// Print user's info
    
    $userName = $user_info->screen_name;
	$userCity = $user_info->location;
	$userCity = str_replace("Ã©", "é", $userCity); 
	$userCity = str_replace("Ã¡", "á", $userCity); 
	$userCity = str_replace("Ã", "í", $userCity); 
	$userCity = str_replace("Ã³", "ó", $userCity);
	$userCity = str_replace("í³", "ó", $userCity); 
	$userCity= str_replace("Ãº", "ú", $userCity);  
	$userCity= str_replace("íº", "ú", $userCity);
	
	
	 
	echo "Espera a que tus datos se actualicen.";
	
   	if (isset($user_info->error)) {
        // Something's wrong, go back to square 1  
        header('Location: login-twitter.php');
		
    } else {
				
		$_SESSION["userName"] = $userName;
		$_SESSION["userCity"] = $userCity;
		$_SESSION["tw"] = 'true';

		header('Location: contacto.php');
	} 
	
} else {
    // Something's missing, go back to square 1
    header('Location: login-twitter.php');
}
?>
