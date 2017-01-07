<?php

	$mysql = mysql_pconnect("localhost","root","1234");
      		
    if(!$mysql)
	{
		echo 'Brak połączenia z bazą danych.';
		exit;
	}
	$wybrana = mysql_select_db("ebank");

	if(!$wybrana)
	{
		echo 'Błąd wyboru bazy danych.';
		exit;
	}

?>