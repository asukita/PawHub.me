<?php
require ("PHPMailer/class.phpmailer.php");

//variables de forma
$name = $_POST['candidateName'];
$lastname = $_POST['candidateLastname'];
$email = $_POST['candidateEmail'];
$city = $_POST['candidateCity'];
$about = $_POST['candidateMsg'];
$interest = $_POST['candidateInterest'];

if($name != ''){
	//se prepara el correo
	$mail = new PHPMailer;

	$mail -> IsSMTP();
	// Set mailer to use SMTP
	$mail -> Host = 'smtp.live.com';
	// Specify main and backup server
	$mail -> Port = 587;
	$mail -> SMTPAuth = true;
	// Enable SMTP authentication
	$mail -> Username = 'info@pawhub.me';
	// SMTP username
	$mail -> Password = 'evoluciona5500';
	// SMTP password
	$mail -> SMTPSecure = 'tls';
	// Enable encryption, 'ssl' also accepted
	$mail -> SMTPDebug = 1;
	
	$mail -> From = 'info@pawhub.me';
	$mail -> FromName = 'PawHub Info';
	$mail -> AddAddress('pamela.vargas@pawhub.me', 'Pamela Vargas');
	$mail -> AddAddress('julio.avila@pawhub.me', 'Julio Ávila');
	$mail -> AddAddress('israel.marban@pawhub.me', 'Israel Marbán');
	$mail -> AddAddress('info@pawhub.me', 'Info PawHub');
	
	$mail -> AddReplyTo('info@pawhub.me', 'PawHub Info');
	//$mail->AddCC('cc@example.com');
	//$mail->AddBCC('bcc@example.com');
	
	$mail -> WordWrap = 50;
	$mail -> IsHTML(true);
	
	// Set email format to HTML
	
	$mail -> Subject = 'Nuevo candidato desde sitio PawHub.me';
	$mail -> Body = '<html> 
					<head> 
					<title>Nuevo candidato desde sitio PawHub.me</title> 
					</head> 
					<body> 
					<h1>Nuevo candidato desde el sitio de PawHub.me</h1> 
					<p> 
					<b>Éstos son sus datos:</b>
					</p> <br />
					<p><b>Nombre:</b> ' . $name . ' ' . $lastname . '.</p>
					<p><b>Correo: </b>' . $email . '.</p>
					<p><b>Ciudad: </b>' . $city . '.</p>
					<p><b>Acerca del candidato: </b>' . $about . '.</p>
					<p><b>Se interesa por: </b>' . $interest . '.</p>
					<p style="text-align: right;">Correo Automático, no contestar.</p>
					</body> 
					</html> ';
	$mail -> AltBody = 'Nuevo candidato desde sitio PawHub.me\n
						Nuevo candidato desde el sitio de PawHub.me\n 
						Éstos son sus datos:\n
						Nombre: ' . $name . ' ' . $lastname . '.\n
						Correo: ' . $email . '.\n
						Ciudad: ' . $city . '. \n
						Acerca del candidato: ' . $about . '.\n
						Se interesa por: </b>' . $interest . '.\n';
	
	if (!$mail -> Send()) {
		echo 'Message could not be sent.';
		echo 'Mailer Error: ' . $mail -> ErrorInfo;
		exit ;
	} 
	
	header('Location: contacto.php?ml=true');
	
}else{
 echo "Debes de llenar el formulario";
}

?>



