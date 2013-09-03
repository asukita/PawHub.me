<!DOCTYPE HTML>
<?php
	session_start();
	
	if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > 30)) {
	    // last request was more than 1 minutes ago
	    session_unset();     // unset $_SESSION variable for the run-time 
	    session_destroy();   // destroy session data in storage
	}
	$_SESSION['LAST_ACTIVITY'] = time(); // update last activity time stamp
	
if(array_key_exists("login",$_GET)) {
	$oauth_provider=$_GET['oauth_provider'];
	if($oauth_provider=='twitter') {
		header("Location: login-twitter.php");
	}
}
	$userName=$_SESSION['userName'];
	$userCity=$_SESSION['userCity'];
	$userCity = str_replace("Ã©", "é", $userCity); 
	$userCity = str_replace("Ã¡", "á", $userCity); 
	$userCity = str_replace("Ã", "í", $userCity); 
	$userCity = str_replace("Ã³", "ó", $userCity);
	$userCity = str_replace("í³", "ó", $userCity); 
	$userCity= str_replace("Ãº", "ú", $userCity);  
	$userCity= str_replace("íº", "ú", $userCity);
	$tw= 'false';
	$tw=$_SESSION['tw'];
	$ml = $_GET['ml'];

?>
<html>
	<head>
		<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
		<meta name="viewport" content="width=device-width, initial-scale = 1.0">
		<title>Contacto</title>
		<link rel="stylesheet" href="css/formstyle.css" type="text/css" media="screen"/>
		<link rel="stylesheet" href="css/grid.css" type="text/css" media="screen">
		<link href='http://fonts.googleapis.com/css?family=Open+Sans:400,800,700,300' rel='stylesheet' type='text/css'>
		<link rel="shortcut icon" href="images/favicon.ico">

		<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.2/jquery.min.js"></script>
		<script type="text/javascript" src="js/sliding.form.js"></script>

		<!--[if lt IE 7 ]> <html lang="en" class="no-js ie6 lt8"> <![endif]-->
		<!--[if IE 7 ]>    <html lang="en" class="no-js ie7 lt8"> <![endif]-->
		<!--[if IE 8 ]>    <html lang="en" class="no-js ie8 lt8"> <![endif]-->
		<!--[if IE 9 ]>    <html lang="en" class="no-js ie9"> <![endif]-->

		<script type="text/javascript">
			$(document).ready(function() {

		function validar_email(valor) {
		// creamos nuestra regla con expresiones regulares.
		var filter = /[\w-\.]{3,}@([\w-]{2,}\.)*([\w-]{2,}\.)[\w-]{2,4}/;
		// utilizamos test para comprobar si el parametro valor cumple la regla
		if (filter.test(valor))
			return true;
		else
			return false;
		}
		
		// verificar correo usuario
		$("#userEmail").change(function() {
			if ($("#userEmail").val() == '') {
				alert("Ingresa un email");
			} else if (validar_email($("#userEmail").val())) {
				var mail = $("#userEmail").val();

				$.ajax({
					type : "GET",
					crossDomain : true,
					xhrFields : {
						withCredentials : false
					},
					cache : false,
					url : "http://wskrs.com/Register/Exist",
					data : { email: mail },
					success : function(respuesta){
						if(respuesta){
							$('#mesagges p').text(mail + ' ya ha sido pre-registrado anteriormente, puedes editar tus datos enviando el formulario nuevamente');
							$('#mesagges').css('display','block');
							//$("#userEmail").val('');
					   }else{
					   		$('#mesagges').css('display','none');
					   }	
					}
				});

		
			} else {
				alert("El email no es valido \nEjemplo: example@example.com");
				$("#userEmail").val("");
				$('#mesagges').css('display','none');
			}
		
		});
		
		
		// verificar correo candidato
		$("#candidateEmail").change(function() {
			if ($("#candidateEmail").val() == '') {
				$('#mesagges2 p').addClass('error');
				$('#mesagges2 p').text("Ingresa un email");
				$('#mesagges2').css('display','block');
			} else if (validar_email($("#candidateEmail").val())) {
		
			} else {
				alert("El email no es valido \nEjemplo: example@example.com");
				$("#candidateEmail").val("");
			}
		
		});
		
		//DROP menu
		if ($(window).width() < 750) {
			$(".btn_dropdown").click(function() {
				$(".navigation").slideToggle("slow");
			});
			
			$(".navigation li").click(function() {
				$(".navigation").hide("fast");
			});
		}
		
		//GETTERS DE TW
		
			var userN = '<?php echo $userName; ?>';
			var userL = '<?php echo $userLastname; ?>';
			var userC = '<?php echo $userCity; ?>';
			var tw = '<?php echo $tw; ?>';
			var ml = '<?php echo $ml; ?>';
				
			if(tw == 'true'){
				$('.btnsredes').remove();
				$('#mesagges p').text('¡¡Ya estás pre-registrado!! Ahora sólo falta verificar tus datos y envíarlos');
				$('#mesagges').css('display','block');
				
				if(userN != '')
					$('#userName').val(userN);
		
				if(userL != '')
					$('#userLastname').val(userL);
		
				if(userC != '')
					$('#userCity').val(userC);
			}
			
			if(ml == 'true'){
				alert('¡Muchas gracias por interesarte en PawHub!\nTus datos ya han sido enviados\n¡Pronto recibirás noticias de nosotros!');
			}
		
			});
			
		</script>
		<!-- FACEBOOK LOGIN -->

		<script>
			// Additional JS functions here
			window.fbAsyncInit = function() {
				FB.init({
					appId : '594368320614740', // App ID
					channelUrl : '//WWW.PAWHUB.ME/channel.html', // Channel File
					status : true, // check login status
					cookie : true, // enable cookies to allow the server to access the session
					xfbml : true // parse XFBML
				});

			};

			// Load the SDK asynchronously
			( function(d) {
					var js, id = 'facebook-jssdk', ref = d.getElementsByTagName('script')[0];
					if (d.getElementById(id)) {
						return;
					}
					js = d.createElement('script');
					js.id = id;
					js.async = true;
					js.src = "//connect.facebook.net/en_US/all.js";
					ref.parentNode.insertBefore(js, ref);
				}(document));
				
			function getFBInfo(){
					FB.login(function(response){
						
			            if(response.status == 'connected'){
			                console.log('Welcome!  Fetching your information.... ');
							FB.api('/me', function(response) {
								var userName = response.name;
								var userEmail = response.email;
								var userCity = response.location.name;
								
								$.ajax({
									type : "GET",
									crossDomain : true,
									xhrFields : {
										withCredentials : false
									},
									cache : false,
									url : "http://wskrs.com/Register/Exist",
									data : { email: userEmail },
									success : function(respuesta){
										if(respuesta){
									   		//$("form").trigger('reset');
											$('#mesagges p').text(userEmail + ' ya ha sido pre-registrado anteriormente, puedes editar tus datos enviando el formulario nuevamente');
											$('#mesagges').css('display','block');
											$('#userName').val(userName);
											$('#userEmail').val(userEmail);
											$('#userCity').val(userCity);
												
								   		}else{
									   		$('.btnsredes').remove();
											
											var data = "userName="+userName+'&userEmail='+userEmail+'&userCity='+userCity;
											
											//se guarda usuario
											try {
												$.ajax({
													type : "POST",
													crossDomain : true,
													xhrFields : {
														withCredentials : false
													},
													cache : false,
													url : "http://wskrs.com/Register/PreUser?jsoncallback=?",
													data : data,
													dataType : "json",
													error : callback_error,
													success : verificaFB
												});
											} catch(ex) {
												$('#mesagges p').text("Ha ocurrido un error\n"+ex.description);
												$('#mesagges').css('display','block');
												$('#mesagges p').addClass('error');
								
											}
											
											function verificaFB(){
												$('#mesagges p').text('¡¡Ya estás pre-registrado!! Ahora sólo falta verificar tus datos y envíarlos');
												$('#mesagges').css('display','block');
												$('#userName').val(userName);
												$('#userEmail').val(userEmail);
												$('#userCity').val(userCity);	
											}
											
								   		}	
									}
								});
							});
			                
			            }
        			},{scope: 'email'});
				}

		</script>

		<!-- TERMINA CODIGO FB -->
	</head>
	<body>

		<div class="menu">
			<div class="container clearfix">

				<div id="logo">
					<a href="index.html"><img src="images/logo.png" /></a>
				</div>

				<div id="nav">
					<a class="btn_dropdown" data-toggle="collapse" data-target=".nav-collapse_">MENU</a>
					<ul class="navigation">
						<li>
							<a href="index.html">Home</a>
						</li>
						<li>
							<a href="index.html#slide2">¿Qué es?</a>
						</li>
						<li>
							<a href="index.html#slide4">Herramientas</a>
						</li>
						<li>
							<a href="index.html#slide6">Motivo</a>
						</li>
						<li>
							<a href="index.html#slide7">Equipo</a>
						</li>

						<div class="clear"></div>
					</ul>
				</div>

			</div>
		</div>
		
		<div id="container">
			
			<div id="wrapper" align="center">
			<div id="navigation">
				<ul>
					<li id="li1" class="selected">
						<a href="#">Pre-regístrate</a>
					</li>
					<li id="li2">
						<a href="#">Intégrate</a>
					</li>
					<li id="li3">
						<a href="#">Apóyanos</a>
					</li>
				</ul>
			</div>
			<div id="steps">

				<form id="formElem1" name="formElem1" action="" method="post">
					<fieldset class="step">
						<legend>
							Pre Registro
						</legend>
						<p class="infohead">
							Pre-regístrate y mantente informado del avance del proyecto.
						</p>
						<br />
						<div class="btnsredes">
							<a href="#" onclick="getFBInfo();return false;"><img src="images/fbsign.jpg" style="margin-right: 22px; margin-bottom: 7px;" /></a>
							<a href="?login&oauth_provider=twitter"><img src="images/twsign.jpg" style="margin-bottom: 7px;" /></a>
						</div>
						<div id="mesagges" style="display: none;">
							<p>This is a test</p>
						</div>

						<p>
							<label for="userName">Nombre</label>
							<input id="userName" name="userName" type="text" required="required"/>
						</p>
						<p>
							<label for="userLastname">Apellido(s)</label>
							<input id="userLastname" name="userLastname" type="text" required="required"/>
						</p>
						<p>
							<label for="userEmail">Email</label>
							<input id="userEmail" name="userEmail" placeholder="info@pawhub.me" type="email" required="required" AUTOCOMPLETE=OFF />
						</p>
						<p>
							<label for="userCity">Ciudad</label>
							<input id="userCity" name="userCity" required="required" type="text"/>
						</p>

						<input class="submit" type="button" onclick="return Validar(this,1)" value="Avísenme cuando PawHub esté listo" />
					</fieldset>
				</form>

				<form id="formElem2" name="formElem2" action="mail.php" method="post" onsubmit="return Validar(this,2)">
					<fieldset class="step">
						<div id="mesagges2" style="display: none;">
							<p>This is a test</p>
						</div>
						<legend>
							Datos Personales
						</legend>
						<p>
							<label for="candidateName">Nombre</label>
							<input id="candidateName" name="candidateName" required="required" type="text" AUTOCOMPLETE=OFF />
						</p>
						<p>
							<label for="candidateLastname">Apellido(s)</label>
							<input id="candidateLastname" name="candidateLastname" required="required" type="text" AUTOCOMPLETE=OFF />
						</p>
						<p>
							<label for="candidateEmail">Email</label>
							<input id="candidateEmail" name="candidateEmail" placeholder="info@pawhub.me" required="required" type="email" AUTOCOMPLETE=OFF />
						</p>
						<p>
							<label for="candidateCity">Ciudad</label>
							<input id="candidateCity" name="candidateCity" type="text" required="required" AUTOCOMPLETE=OFF />
						</p>
						<p>
							<label for="candidateMsg" style="margin-top: 7px;">Platícanos de ti:</label>
							<textarea id="candidateMsg" rows="2" cols="50" name="candidateMsg" required>...</textarea>
						</p>
						<p>
							<label for="candidateInterest" style="line-height: 17px; margin-top: 5px;">¿Qué te interesa de PawHub?</label>
							<textarea id="candidateInterest" rows="2" cols="50" name="candidateInterest" required>...</textarea>
						</p>
						<input class="submit" type="submit" value="Quiero ayudar" style="width: 160px!important; margin: 23px 180px;" />
					</fieldset>
				</form>
				<form id="formElem3" name="formElem3" action="" method="post">
					<fieldset class="step">
						<legend>
							¡Contáctanos!
						</legend>
						<p>
							<a href="mailto:info@pawhub.me"><img src="images/mail_blue.png" alt="contacto" title="info@pawhub.me" /></a>
						</p>
						<p>
							<a href="https://www.facebook.com/PawHub" target="_blank"><img src="images/icnfb.png" alt="contacto" title="fb.com/PawHub" /></a>
						</p>
						<p>
							Revisa nuestro perfil en la plataforma para startups, <a style="color: #63C2D0; font-weight: bolder;" href="https://angel.co/pawhub" target="_blank">AngelList</a>
						</p>
					</fieldset>
				</form>

			</div>
		</div>
		
		<p class="aviso">
			Revisa nuestro <a href="aviso-privacidad.html">Aviso de Privacidad</a>
		</p>
			
		<script type="text/javascript">
			(function(i, s, o, g, r, a, m) {
				i['GoogleAnalyticsObject'] = r;
				i[r] = i[r] ||
				function() {
					(i[r].q = i[r].q || []).push(arguments)
				}, i[r].l = 1 * new Date();
				a = s.createElement(o), m = s.getElementsByTagName(o)[0];
				a.async = 1;
				a.src = g;
				m.parentNode.insertBefore(a, m)
			})(window, document, 'script', '//www.google-analytics.com/analytics.js', 'ga');

			ga('create', 'UA-10483060-4', 'pawhub.me');
			ga('send', 'pageview');

		</script>
		
		<script>
			//Funcion que verifica campos del formulario vacios para IE y Safari
			function Validar(f, inp) {
	
				//verificar datos usuario
				if (inp == 1) {
	
					var f = document.getElementById('formElem1');
	
					if (f.userName.value == "") {
						$('#mesagges p').addClass('error');
						$('#mesagges p').text("Por favor escribe tu nombre");
						$('#mesagges').css('display','block');
						f.userName.focus();
						return false;
					}
					if (f.userLastname.value == "") {
						$('#mesagges p').addClass('error');
						$('#mesagges p').text("Por favor escribe tu apellido");
						$('#mesagges').css('display','block');
						f.userLastname.focus();
						return false;
					}
					if (f.userEmail.value == "") {
						$('#mesagges p').addClass('error');
						$('#mesagges p').text("Por favor escribe tu email");
						$('#mesagges').css('display','block');
						f.userEmail.focus();
						return false;
					}
					if (f.userCity.value == "") {
						$('#mesagges p').addClass('error');
						$('#mesagges p').text("Ingresa tu Ciudad");
						$('#mesagges').css('display','block');
						f.userCity.focus();
						return false;
					}
	
					sendValues();
	
				}
	
				if (inp == 2) {
					//verificar datos candidato
					if (f.candidateName.value == "") {					
						$('#mesagges2 p').addClass('error');
						$('#mesagges2 p').text("Por favor escribe tu nombre");
						$('#mesagges2').css('display','block');
						f.candidateName.focus();
						return false;
					}
					if (f.candidateLastname.value == "") {
						$('#mesagges2 p').addClass('error');
						$('#mesagges2 p').text("Por favor escribe tu apellido");
						$('#mesagges2').css('display','block');
						f.candidateLastname.focus();
						return false;
					}
					if (f.candidateEmail.value == "") {
						$('#mesagges2 p').addClass('error');
						$('#mesagges2 p').text("Por favor escribe tu email");
						$('#mesagges2').css('display','block');
						f.candidateEmail.focus();
						return false;
					}
					if (f.candidateCity.value == "") {
						$('#mesagges2 p').addClass('error');
						$('#mesagges2 p').text("Ingresa tu Ciudad");
						$('#mesagges2').css('display','block');
						f.candidateCity.focus();
						return false;
					}
					if ((f.candidateMsg.value == "") || (f.candidateMsg.value == "...") || (f.candidateMsg.value.length == 0)) {//revisar espacios
						$('#mesagges2 p').addClass('error');
						$('#mesagges2 p').text("¡¡¡Queremos saber más de ti!!!");
						$('#mesagges2').css('display','block');
						f.candidateMsg.focus();
						return false;
					}
					if ((f.candidateInterest.value == "") || (f.candidateInterest.value == "...") || (f.candidateInterest.value.length == 0)) {//revisar espacios
						$('#mesagges2 p').addClass('error');
						$('#mesagges2 p').text("¡¡¡Queremos saber tus intereses!!!");
						$('#mesagges2').css('display','block');
						f.candidateInterest.focus();
						return false;
					}
	
				}
	
			}
	
			function sendValues() {
				var str;
				str = $("#formElem1").serialize();
				
				try {
					$.ajax({
						type : "POST",
						crossDomain : true,
						xhrFields : {
							withCredentials : false
						},
						cache : false,
						url : "http://wskrs.com/Register/PreUser?jsoncallback=?",
						data : str,
						dataType : "json",
						error : callback_error,
						success : recuperarInfo
					});
				} catch(ex) {				
					$('#mesagges p').addClass('error');
					$('#mesagges p').text("Ha ocurrido un error\n"+ex.description);
					$('#mesagges').css('display','block');
	
				}
	
	
			}
	
			// mostramos un mensaje con la causa del problema
			function callback_error(XMLHttpRequest, textStatus, errorThrown) {
				$('#mesagges p').addClass('error');
				$('#mesagges p').text("Ha ocurrido un error al registrarte, por favor intenta nuevamente");
				$('#mesagges').css('display','block');
	
				alert(XMLHttpRequest + textStatus + errorThrown);
			}
	
			//si tiene exito recuperamos la info
			function recuperarInfo(ajaxResponse, textStatus) {
				$('#mesagges p').text('Tus datos han sido enviados.¡¡¡Gracias!!!');
				$("form").trigger('reset');
				$('#mesagges').css('display','block');
			}
		</script>
		
		</div>
		
	</body>

</html>