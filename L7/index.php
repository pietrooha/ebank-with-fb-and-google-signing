<?php

session_start();

require_once __DIR__ . '/FacebookAuth/Facebook/autoload.php';

if ((isset($_SESSION['logged_in'])) && ($_SESSION['logged_in']==true))
{
	header('Location: home.php');
	exit();
}

?>

<!DOCTYPE HTML>
<html lang="pl">
<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
	<title>eBank Poland S.A.</title>
	<link rel="shortcut icon" href="favicon.ico">
	<link rel="stylesheet" href="css/style2.css">
</head>
<body>
	<div class="container">
		<div class="header">
			<h1 class="header-heading">eBank</h1>
		</div>
		<div class="nav-bar">
			<ul class="nav">
			<li><a href="home.php">Home</a></li>
			<li><a href="przelew.php">Przelew</a></li>
			<li><a href="doladowanie.php">Doładowanie</a></li>
			<li><a href="historia.php">Historia</a></li>
			<li><a href="pomoc.php">Pomoc</a></li>
			</ul>
		</div>
		<section class="content"><hr>
			<div class="login">
				<h1>Logowanie </h1>
				<form method="post" action="login.php">
					<p class="infoI">
						<?php
						if(isset($_SESSION['error'])) echo $_SESSION['error'];
						?>
						<label>
							<b><font size="1">Aby uzyskać dostęp do konta podaj identyfikator i klucz</font></b>
						</label>
					</p>
					<p>
						<input type="text" name="identyfikator" value="" placeholder="Identyfikator">
					</p>
					<p>
						<input type="password" name="klucz" value="" placeholder="Klucz">
					</p>
					<p>
						<div class="g-recaptcha" data-callback="recaptchaCallback" data-sitekey="6LfXEA8UAAAAAKLyq8NLC9g_wzT77g-RFy2j0uwO"></div>
					</p>
					<p class="submit">
						<center><input type="submit" id ="submitBtn" name="zatwierdz" value="ZATWIERDŹ"></center>
					</p><hr>
					<p>
						<center><a href="forgotform.php">Kliknij, jeśli zapomniałeś hasła</a></center>	
					</p>
				</form><hr>
				<?php
					$fb = new Facebook\Facebook([
						'app_id' => '1852882558325683', // Replace {app-id} with your app id
						'app_secret' => '855fb024290e34a31a77e15517f58106',
						'default_graph_version' => 'v2.8',
					]);

					$helper = $fb->getRedirectLoginHelper();

					$permissions = ['email']; // Optional permissions
					$loginUrl = $helper->getLoginUrl('http://e-systempieniezny.pl/crypto/L4/Lista4/Lista7/L7/FacebookAuth/fb-callback.php', $permissions);

					echo '<center><a href="' . htmlspecialchars($loginUrl) . '">Zaloguj przez Facebook </a></center>';
				?>

				<hr>
				<center>
					<?php
						include "GoogleAuth/google_auth.php";
					?>
				</center><hr>
			</div><hr>
		</section>

		<div class="footer">
			&copy; 2015 eBank Polska S.A. Wszelkie prawa zastrzeżone.
		</div>
	</div>
	<script src='https://www.google.com/recaptcha/api.js'></script>
	<script src="https://code.jquery.com/jquery-3.1.1.min.js" integrity="sha256-hVVnYaiADRTO2PzUGmuLJr8BLUSjGIZsDYGmIJLv2b8=" crossorigin="anonymous"></script>
	<script type="text/javascript">
		function recaptchaCallback()
		{
			$('#submitBtn').removeAttr('disabled');
		};
	</script>
	</body>
</html>