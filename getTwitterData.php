<?php
ob_start();
require("twitter/twitteroauth.php");
require 'config/twconfig.php';

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
    echo "¡¡Tus datos han sido enviados!!";
    $userFullName = $user_info->name;
	$split = explode(' ', $userFullName);
	$userName = $split[0];
	$userLastname = $split[1];
	$userCity = $user_info->location;
	$bodytag = str_replace("Ã©", "é", $userCity); 
	$bodytag = str_replace("Ã¡", "á", $userCity); 
	$bodytag = str_replace("Ã", "í", $userCity); 
	$bodytag = str_replace("Ã³", "ó", $userCity); 
	$bodytag = str_replace("Ãº", "ú", $userCity);
	 
	echo $userName." ".$userCity."".$userLastName;
	
   	if (isset($user_info->error)) {
        // Something's wrong, go back to square 1  
        header('Location: login-twitter.php');
		
    } else {?>
	   	
		<script type="text/javascript">
				
				var userName = '<?php echo $userName; ?>';
				var userLastname = '<?php echo $userLastname; ?>';
				var userCity = '<?php echo $bodytag; ?>'; 
				
				location.href = "contactoLoginFB.php?userName="+userName+"&userLastname="+userLastname+"&userCity="+userCity;
				

		</script>
		
    <?php }
} else {
    // Something's missing, go back to square 1
    header('Location: login-twitter.php');
}
?>
