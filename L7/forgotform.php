<html lang="pl">
	<head>
		<meta charset="utf-8">
		<meta http-equiv="X-UA-Compatible" content="IE=edge">
		<title>eBank Polska S.A.</title>
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
   				<li><a href="index.php">Wróć do strony logowania</a></li>
				</ul>
			</div>
			<div class="content">
				<div class="main"><hr>
					<center>
						<form method="post" action="forgotpassword.php">
							<p class="infoI">
								<label>
									<b><font size="1">Aby odzyskać hasło podaj swój Identyfikator</font></b>
								</label>
							</p>
							<p>
								<input type="text" name="identyfikator" value="" placeholder="Identyfikator">
							</p>
							<p class="submit">
								<center><input type="submit" id ="submitForgotPassBtn" name="odzyskaj" value="ODZYSKAJ"></center>
							</p>
						</form>
					</center><hr>
				</div>
			</div>
			<div class="footer">
				&copy; eBank Polska S.A. Wszelkie prawa zastrzeżone.
			</div>
		</div>
	</body>
</html>