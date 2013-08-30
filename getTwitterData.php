<?php

ob_start();

require("twitter/twitteroauth.php");

require 'config/twconfig.php';

if (isset($_REQUEST['_SESSION'])) die("Get lost!");
  
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
	 
	echo "Espera a que tus datos se actualicen.";
	
   	if (isset($user_info->error)) {
        // Something's wrong, go back to square 1  
        header('Location: login-twitter.php');
		
    } else {
				
		$_SESSION["userName"] = $userName;
		$_SESSION["userCity"] = $userCity;
		$_SESSION["tw"] = 'true';?>
		
		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		
		<script type="text/javascript">
		
			var userName = '<?php echo $userName ?>';
			var userCity = '<?php echo $userCity ?>';
			
			var data = "userName="+userName+'&userCity='+userCity;
											
			//se guarda usuario
			try {
				$.ajax({
					type : "POST",
					crossDomain : true,
					xhrFields : { withCredentials : false },
					cache : false,
					url : "http://wskrs.com/Register/PreUser?jsoncallback=?",
					data : data,
					dataType : "json",
					error : callback_error,
					success : regresarContacto
				});
			} catch(ex) {
				alert("Ha ocurrido un error\n"+ex.description);
			}
											
			function regresarContacto(){
				window.location.href = 'contacto.php';
			}
			
			// mostramos un mensaje con la causa del problema
			function callback_error(XMLHttpRequest, textStatus, errorThrown) {
				alert("Ha ocurrido un error al registrarte, por favor intenta nuevamente");
				alert(XMLHttpRequest + textStatus + errorThrown);
			}
			
		</script>

		<?php 
	} 
	
} else {
    // Something's missing, go back to square 1
    header('Location: login-twitter.php');
}
?>
