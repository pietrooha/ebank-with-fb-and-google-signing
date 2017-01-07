<?php

	session_start();

	if((!isset($_POST['identyfikator'])) || (!isset($_POST['klucz'])))
	{
		header('Location: index.php');
		exit();
	}

	if(isset($_POST['g-recaptcha-response']))
	{
    	$captcha=$_POST['g-recaptcha-response'];
   	}
    if(!$captcha)
    {
    	echo '<h2>Please check the the captcha form.</h2>';
    	$_SESSION['error'] = '<center><span style="color:red" align="center"><b>Uzupełnij pole CAPTCHA</b></span></center>';
    	header('Location: index.php');
       	exit;
    }

	$secret = '6LfXEA8UAAAAAALWZYoV3SBguV5UmfHpPWCOg1J3';
	$response = $_POST['g-recaptcha-response'];
	$remoteip = $_SERVER['REMOTE_ADDR'];

	$url = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret&response=$response&remoteip=$remoteip");
	$result = json_decode($url, TRUE);

	if(intval($result['success']) !== 1)
	{
		echo "Jesteś spamerem!";
	}
		
	require_once "connect.php";

	$connect = @new mysqli($host, $db_user, $db_password, $db_name);
      	
	if ($connect->connect_errno!=0)
	{
		echo "Error: ".$connect->connect_errno;
	}
	else
	{
		$identyfikator = $_POST['identyfikator'];
		$klucz = $_POST['klucz'];


		$identyfikator = htmlentities($identyfikator, ENT_QUOTES, "UTF-8");

		if ($result = @$connect->query(
		sprintf("SELECT * FROM klient JOIN uzytkownik ON klient.id_uzytkownik = uzytkownik.id_uzytkownik JOIN konto ON klient.id_konto = konto.id_konto WHERE identyfikator='%s'",
		mysqli_real_escape_string($connect, $identyfikator))))
		{
			$number_of_users = $result->num_rows;
			
			if($number_of_users > 0)
			{
				
				$row = $result->fetch_assoc();
				

				if(password_verify($klucz, $row['klucz']))
				{
					$_SESSION['logged_in'] = true;
					$_SESSION['imie'] = $row['imie'];
					$_SESSION['nazwisko'] = $row['nazwisko'];
					$_SESSION['dataUrodzenia'] = $row['dataUrodzenia'];
					$_SESSION['ulica'] = $row['ulica'];
					$_SESSION['nrDomu'] = $row['nrDomu'];
					$_SESSION['kodPocztowy'] = $row['kodPocztowy'];
					$_SESSION['miejscowosc'] = $row['miejscowosc'];
					$_SESSION['panstwo'] = $row['panstwo'];
					$_SESSION['numerKonta'] = $row['numerKonta'];
					$_SESSION['stanKonta'] = $row['stanKonta'];

					unset($_SESSION['error']);
					$result->free_result();

					if($identyfikator == 'Admin')
					{
						header('Location: transfer_validate.php');
					}
					else
					{
						header('Location: home.php');
					}
				}
				else
				{
					$_SESSION['error'] = '<center><span style="color:red" align="center"><b>Nieprawidłowy klucz</b></span></center>';
					header('Location: index.php');
				}	

				
			} else {
				
				$_SESSION['error'] = '<center><span style="color:red" align="center"><b>Nieprawidłowy identyfikator</b></span></center>';
				header('Location: index.php');
				
			}
			
		}

		$connect->close();
	}
	
?>