<?php
  session_start();

  if(!isset($_SESSION['logged_in']))
  {
  	header('Location: index.php');
  	exit();
  }

  require_once "set_db.php";
  $id_przelewu_do_potw = $_SESSION['id_przelewu_do_potw'];
  $zapytaniePotwierdzajacePrzelew = "update przelew set zrealizowany='1' where id_przelew='$id_przelewu_do_potw'";
  $wynikPotwPrzelew = mysql_query($zapytaniePotwierdzajacePrzelew);

  if($wynikPotwPrzelew == FALSE)
  {
	die(mysql_error());
  }

  header("Location: transfer_validate.php");
?>