<?php 

  session_start();

  if(!isset($_SESSION['logged_in']))
  {
  	header('Location: index.php');
  	exit();
  }
echo '<html lang="en">
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
							
							require_once "set_db.php";

							$imie = $_SESSION['imie'];
							$nazwisko = $_SESSION['nazwisko'];

							$zapytanieStanKonta = "select stanKonta, numerKonta from konto join klient on konto.id_konto = klient.id_konto where imie = '$imie' and nazwisko = '$nazwisko'";
							$wynikStanKonta = mysql_query( $zapytanieStanKonta );

							if($wynikStanKonta == FALSE)
							{
								die(mysql_error());
							}

							$wiersz4 = mysql_fetch_row( $wynikStanKonta );	

							
							$sstanKonta = $wiersz4[0];
							$numerKonta = $wiersz4[1];
							echo '<div><span class="prawa"><h6>Jesteś zalogowany jako:  '.$_SESSION['imie']." ".$_SESSION['nazwisko'].'</h6></span><span class="lewa"><h2>Przelew</h2>';	
							echo '</span></div>';
							echo '<hr>';
							echo '<p><h5>Aby zrealizować nowy przelew wpisz dane takie jak: numer konta osoby, której chcesz przekazać pieniądze, jej imię, nazwisko 
							     oraz jej numer konta bankowego.</h5></p><hr>';
					   		echo '<form id="transferForm" name="transfeForm" method="post" action="przelew.php">';
							echo '<center>Tytuł przelewu:&nbsp<input type="text" style="width: 265px;" id="tytulPrzelewu" name="tytulPrzelewu" placeholder="" />&nbsp&nbsp&nbsp <br />';
					   		echo '<center>Numer konta:&nbsp<input type="text" maxlength="26" style="width: 265px;" id="nrKontaOdbiorcy" name="nrKontaOdbiorcy" placeholder="" /> <br />';
					   		echo 'Imię:&nbsp<input type="text" style="width: 145px;" id="imieOdbiorcy" name="imieOdbiorcy" placeholder="" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <br />';
					   		echo 'Nazwisko:&nbsp<input type="text" style="width: 145px;" id="nazwiskoOdbiorcy" name="nazwiskoOdbiorcy" value="" placeholder="" />&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp <br />';
							echo 'Kwota:&nbsp<input type="text" style="width: 105px;" id="kwota" name="kwota" value="" placeholder="" /> PLN&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp&nbsp</center>';
							echo '<p class="submit"><center><input type="submit" id="zrealizuj" name="zrealizuj" value="ZREALIZUJ" onclick = "postResul()"></p><hr>';
							echo '</form>';


							//$_SESSION['nrKontaOdbiorcy'] = $_POST['nrKontaOdbiorcy'];
							

							if(isset($_POST['tytulPrzelewu']))
							$tytulPrzelewu = $_POST['tytulPrzelewu'];
							if(isset($_POST['nrKontaOdbiorcy']))
							$nrKontaOdbiorcy = $_POST['nrKontaOdbiorcy'];
							if(isset($_POST['imieOdbiorcy']))
							$imieOdbiorcy = $_POST['imieOdbiorcy'];
							if(isset($_POST['nazwiskoOdbiorcy']))
							$nazwiskoOdbiorcy = $_POST['nazwiskoOdbiorcy'];
							if(isset($_POST['kwota']))
							$kwota = $_POST['kwota'];

							if(!isset($_POST['nrKontaOdbiorcy'])&&!isset($_POST['imieOdbiorcy'])&&!isset($_POST['nazwiskoOdbiorcy']))
							{
								echo '<br /><hr><div><span class="prawa"><h6>Stan Twojego konta: '.$sstanKonta.' PLN </h6></span><span class="lewa"><h6>Numer Twojego konta: '.$numerKonta.'</span></div><hr>';
							}
							else
							{

								require_once "set_db.php";

								$zapytanieNrKontaOdb = "select numerKonta from konto where numerKonta = '$nrKontaOdbiorcy'";
								$zapytanieImieOdbiorcy = "select imie from klient where imie = '$imieOdbiorcy'";
								$zapytanieNazwiskoOdbiorcy = "select nazwisko from klient where nazwisko = '$nazwiskoOdbiorcy'";
								$zapytanieBiezacyStanKontaOdbiorcy = "select stanKonta from konto where numerKonta = 
												      '$nrKontaOdbiorcy'";

								$zapytanieBiezacyStanKontaZalogowanego = "select stanKonta from konto join klient on konto.id_konto = klient.id_konto where imie = 
													  '$imie' and nazwisko = '$nazwisko'";

								

								//$zapytaniePoprawnoscDanych = "select numerKonta, imie, nazwisko from konto join klient on konto.id_konto = klient.id_konto where 
								//			      numerKonta = '$nrKontaOdbiorcy' and imie = '$imieOdbiorcy' and nazwisko = '$nazwiskoOdbiorcy'";
								

								$wynikNrKontaOdb = mysql_query( $zapytanieNrKontaOdb );
								$wynikImieOdbiorcy = mysql_query( $zapytanieImieOdbiorcy );
								$wynikNazwiskoOdbiorcy = mysql_query( $zapytanieNazwiskoOdbiorcy );
								$wynikBiezacyStanKontaOdbiorcy = mysql_query( $zapytanieBiezacyStanKontaOdbiorcy );

								//$wynikPoprawnoscDanych = mysql_query( $zapytaniePoprawnoscDanych );

								$wynikBiezacyStanKontaZalogowanego = mysql_query( $zapytanieBiezacyStanKontaZalogowanego );


								//if(!$wynikBiezacyStanKontaZalogowanego)
								//{
								//	echo 'Nie można wykonać zapytania.';
								//	exit;
								//}


								if(!$wynikNrKontaOdb)
								{
									echo 'Nie można wykonać zapytania.';
									exit;
								}		
								if(!$wynikImieOdbiorcy)
								{
									echo 'Nie można wykonać zapytania.';
									exit;
								}
								if(!$wynikNazwiskoOdbiorcy)
								{
									echo 'Nie można wykonać zapytania.';
									exit;
								}
								if(!$wynikBiezacyStanKontaOdbiorcy)
								{
									echo 'Nie można wykonać zapytania.';
									exit;
								}
								if(!$wynikBiezacyStanKontaZalogowanego)
								{
									echo 'Nie można wykonać zapytania.';
									exit;
								}


								$wiersz = mysql_fetch_row( $wynikNrKontaOdb );
								$wiersz2 = mysql_fetch_row( $wynikImieOdbiorcy );
								$wiersz3 = mysql_fetch_row( $wynikNazwiskoOdbiorcy );
								$wiersz4 = mysql_fetch_row( $wynikBiezacyStanKontaOdbiorcy );
				
								$wiersz5 = mysql_fetch_row( $wynikBiezacyStanKontaZalogowanego );

								$nrKontaOdb = $wiersz[0];
								//echo $nrKonta;
								$imieOdb = $wiersz2[0];
								$nazwiskoOdb = $wiersz3[0];
								$biezacyStanKontaOdb = $wiersz4[0];

								$biezacyStanKontaZalogowanego = $wiersz5[0];

								if($tytulPrzelewu == '')
								{
									echo '<center><b><font color="red">Wpisz tytuł przelewu!</font></b></center>';
									echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: '.$sstanKonta.' PLN </h6></span><span class="lewa"><h6>Numer Twojego
 									konta: '.$numerKonta.'</span></div><hr>';
								}
								if(!strlen($nrKontaOdb) == 26 || $nrKontaOdb == $numerKonta)
								{
									echo $nrKontaOdb;
									echo '<center><b><font color="red">Podaj poprawny numer konta odbiorcy!</font></b></center>';
									echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: '.$sstanKonta.' PLN </h6></span><span class="lewa"><h6>Numer Twojego
 									konta: '.$numerKonta.'</span></div><hr>';
								}
								else if(!mysql_num_rows($wynikNrKontaOdb) > 0)
								{
									echo '<center><b><font color="red">Podany numer konta nie istnieje!</font></b></center>';
									echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: '.$sstanKonta.' PLN </h6></span><span class="lewa"><h6>Numer Twojego
 									konta: '.$numerKonta.'</span></div><hr>';
								}
								else if($imieOdb == '' || $imieOdb == $imie)
								{
									echo '<center><b><font color="red">Podaj poprawne imię odbiorcy!</font></b></center>';
									echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: '.$sstanKonta.' PLN </h6></span><span class="lewa"><h6>Numer Twojego
 									konta: '.$numerKonta.'</span></div><hr>';
								}
								else if(!mysql_num_rows($wynikImieOdbiorcy) > 0)
								{
									echo '<center><b><font color="red">Podaj poprawne imię odbiorcy!</font></b></center>';
									echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: '.$sstanKonta.' PLN </h6></span><span class="lewa"><h6>Numer Twojego
 									konta: '.$numerKonta.'</span></div><hr>';
								}
								else if($nazwiskoOdb == '' || $nazwiskoOdb == $nazwisko)
								{
									echo '<center><b><font color="red">Podaj poprawne nazwisko odbiorcy!</font></b></center>';
									echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: '.$sstanKonta.' PLN </h6></span><span class="lewa"><h6>Numer Twojego
 									konta: '.$numerKonta.'</span></div><hr>';
								}
								else if(!mysql_num_rows($wynikNazwiskoOdbiorcy) > 0)
								{
									echo '<center><b><font color="red">Podaj poprawne nazwisko odbiorcy!</font></b></center>';
									echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: '.$sstanKonta.' PLN </h6></span><span class="lewa"><h6>Numer Twojego
 									konta: '.$numerKonta.'</span></div><hr>';
								}
								else if($kwota == '' || $kwota < 0.01)
								{
									echo '<center><b><font color="red">Podaj poprawną kwotę przelewu!</font></b></center>';
									echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: '.$sstanKonta.' PLN </h6></span><span class="lewa"><h6>Numer Twojego
 									konta: '.$numerKonta.'</span></div><hr>';
								}
								else if($kwota > $biezacyStanKontaZalogowanego)
								{
									echo '<center><b><font color="red">Nie masz wystarczających środków, aby wykonać ten przelew!</font></b></center>';
									echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: '.$sstanKonta.' PLN </h6></span><span class="lewa"><h6>Numer Twojego
 									konta: '.$numerKonta.'</span></div><hr>';
								}
								else {
								$nowyStanKontaOdb = $biezacyStanKontaOdb + $kwota;
								$nowyStanKontaZalogowanego = $biezacyStanKontaZalogowanego - $kwota;
								//echo $nowyStanKontaZalogowanego;
								$zapytanieZmianaStanuKontaZalogowanego = "update konto set stanKonta = '$nowyStanKontaZalogowanego' where stanKonta = 
													 '$biezacyStanKontaZalogowanego'";
								$zapytanieZmianaStanuKontaOdb = "update konto set stanKonta = '$nowyStanKontaOdb' where stanKonta ='$biezacyStanKontaOdb'";
								
								$zapytanieIdKonto = "select id_konto from konto where numerKonta = '$numerKonta'";
								$wynikIdKonto = mysql_query( $zapytanieIdKonto );
								$wiersz11 = mysql_fetch_row( $wynikIdKonto );
								$idKonto = $wiersz11[0];


								$zapytanieIdPrzelew = "select id_przelew from przelew where id_przelew in (select max(id_przelew) from przelew)";
								$wynikIdPrzelew = mysql_query( $zapytanieIdPrzelew );

								if($wynikIdPrzelew == FALSE)
								{
									die(mysql_error());
								}
								$wiersz13 = mysql_fetch_row( $wynikIdPrzelew );
								$idPrzeleww = $wiersz13[0];
								$idPrzelew = $idPrzeleww + 1;

								$wynikZmianaStanuKontaZalogowanego = mysql_query( $zapytanieZmianaStanuKontaZalogowanego );

								if($wynikZmianaStanuKontaZalogowanego == FALSE)
								{
									die(mysql_error());
								}
								$wynikZmianaStanuKontaOdb = mysql_query( $zapytanieZmianaStanuKontaOdb );
								
								if($wynikZmianaStanuKontaOdb == FALSE)
								{
									die(mysql_error());
								}
								$wiersz6 = mysql_fetch_row( $wynikZmianaStanuKontaZalogowanego );
								
								$wiersz7 = mysql_fetch_row( $wynikZmianaStanuKontaOdb );
								$stanKonta = $wiersz6[0];
								$stanKontaOdb = $wiersz7[0];
								
								$zapytanieIdKlient = "select id_klient from klient where imie = '$imie' and nazwisko = '$nazwisko'";
								$wynikIdKlient = mysql_query( $zapytanieIdKlient );
								$wiersz12 = mysql_fetch_row( $wynikIdKlient );
								$idKlient = $wiersz12[0];


									$zapytanieIdKlientOdb = "select id_klient from klient where imie = '$imieOdb' and nazwisko = '$nazwiskoOdb'";
									$wynikIdKlientOdb = mysql_query( $zapytanieIdKlientOdb );
									$wiersz13 = mysql_fetch_row( $wynikIdKlientOdb );
									$idKlientOdb = $wiersz13[0];

								$date = date("Y-m-d H:i:s");

								$zapytanieNadInsertTabPrzelew = "insert into przelew (id_klient_nad, id_klient_odb, tytulPrzelewu, kwotaPrzelewu, saldoNadPoOperacji, saldoOdbPoOperacji, dataPrzelewu)
								values ('$idKlient', '$idKlientOdb' , '$tytulPrzelewu', '$kwota', '$nowyStanKontaZalogowanego', $nowyStanKontaOdb, '$date')";
								$wynikNadInsertTabPrzelew = mysql_query( $zapytanieNadInsertTabPrzelew );
/*
								$zapytanieNadInsertTabPotw = "insert into potwierdzenia (id_klient_nad, id_klient_odb, tytulPrzelewu, kwotaPrzelewu)
								values ('$idKlient', '$idKlientOdb' , '$tytulPrzelewu', '$kwota')";
								$wynikNadInsertTabPotw = mysql_query( $zapytanieNadInsertTabPotw );
*/
								echo '<center><b><font color="orange">Przelew zostanie zrealizowany po akceptacji administratora i wtedy będzie wyświetlony w historii jako zrealizowany </font></b></center>';
								echo '<hr><div><span class="prawa"><h6>Stan Twojego konta: '.$nowyStanKontaZalogowanego.' PLN </h6></span><span class="lewa"><h6>Numer 
								Twojego konta: '.$numerKonta.'</span></div><hr>';
								}
							}
?>
				</div>
			</div>
			<div class="footer">
				&copy; eBank Polska S.A. Wszelkie prawa zastrzeżone.
			</div>
		</div>
	</body>
</html>