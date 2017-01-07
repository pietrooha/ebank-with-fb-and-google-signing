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
	       						<li><a href="logout.php">Wyloguj</a></li>
							</ul>
						</div>
						<div class="content">
							<div class="main">';
/*	  echo '<div><span class="prawa"><h6>Jesteś zalogowany jako:  '.$_SESSION['imie']." ".$_SESSION['nazwisko'].'</h6></span><span class="lewa"><h2>Potwierdzanie przelewów</h2>';
	  echo '</span></div>';*/
	  echo '<hr><h5><b>Lista przelewów do potwierdzenia</b></h5><hr><br />';

	  require_once "set_db.php";
	  
	  $zapytaniePotw = "select id_przelew, id_klient_nad, id_klient_odb, tytulPrzelewu, kwotaPrzelewu from przelew where zrealizowany = '0'";
	  $wynikPotw = mysql_query( $zapytaniePotw );

	  if($wynikPotw == FALSE)
	  {
	    die(mysql_error());
	  }

	  if(mysql_num_rows($wynikPotw) > 0) {

	  
echo '<table class="responstable">
  
  <tr>
    <th>Potwiedzenie</th>
  	<th>ID</th>    
    <th><span>Od</span></th>
    <th>Do</th>
    <th>Tytuł przelewu</th>
    <th>Kwota</th>
  </tr>';}

  $count = 1;
  while($r = mysql_fetch_array($wynikPotw)) {
  	echo '<tr>
    <td><form action="validate.php" method="post"><input type="submit" value="Potwierdź" name="submit'.$count.'" /></form></td>
    <td>' . $r[0] . '</td>
    <td>' . $r[1] . '</td>
    <td>' . $r[2] . '</td>
    <td>' . $r[3] . '</td>
    <td>' . $r[4] . '</td>
  </tr>';
  $_SESSION['id_przelewu_do_potw'] = $r[0];

  $count++;
  }
  
echo '</table>';
//	  echo '<hr>';
	  echo '</div>
					</div>
					<div class="footer">
						&copy; eBank Polska S.A. Wszelkie prawa zastrzeżone.
					</div>
					</div>
					</body>
			</html>';
			
?>