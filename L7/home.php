<?php 

  session_start();

  if(!isset($_SESSION['logged_in']))
  {
  	header('Location: index.php');
  	exit();
  }

	  echo	'<html lang="en">
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
								<li><a href="home.php">Home</a></li>
								<li><a href="przelew.php">Przelew</a></li>
								<li><a href="doladowanie.php">Doładowanie</a></li>
								<li><a href="historia.php">Historia</a></li>
								<li><a href="pomoc.php">Pomoc</a></li>
								<li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li><li></li>
	       						<li><a href="logout.php">Wyloguj</a></li>
							</ul>
						</div>
						<div class="content">
							<div class="main">';
	  echo '<div><span class="prawa"><h6>Jesteś zalogowany jako:  '.$_SESSION['imie']." ".$_SESSION['nazwisko'].'</h6></span><span class="lewa"><h2>Home</h2>';
	  echo '</span></div><hr>';
	  echo '<h5> Twój numer konta: <b>'.$_SESSION['numerKonta'].'</b></h5><br />';
	  echo '<h5> Bieżący stan Twojego konta: <b>'.$_SESSION['stanKonta'].'</b> PLN</h5><br /><br /><br />';
	  echo '<h5>Twoje dane osobowe: </h5><hr>';
	  echo '<h5>Imię i nazwisko: <b>'.$_SESSION['imie'].' '.$_SESSION['nazwisko'].'</b><br />Data urodzenia: <b>'.$_SESSION['dataUrodzenia'].'</b></h5><br />';
	  echo '<h5>Adres zamieszkania: <b>'.$_SESSION['ulica'].' '.$_SESSION['nrDomu'].', '.$_SESSION['kodPocztowy'].' '.$_SESSION['miejscowosc'].', '.$_SESSION['panstwo'].'</b></h5><br />';
	  echo '<hr>';
	  echo '</div>
					</div>
					<div class="footer">
						&copy; eBank Polska S.A. Wszelkie prawa zastrzeżone.
					</div>
					</div>
					</body>
			</html>';
			
?>
