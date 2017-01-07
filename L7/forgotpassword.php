<?php 
session_start();

include "connect.php";
include "new_key_generator.php";
require_once('phpmailer/class.phpmailer.php');

$connection = @new mysqli($host, $db_user, $db_password, $db_name);
      	
if ($connection->connect_errno!=0)
{
	echo "Error: ".$connect->connect_errno;
}

if (isset($_POST['identyfikator']))
{
	$username = $_POST['identyfikator'];
	$query="SELECT * FROM `uzytkownik` WHERE identyfikator='$username'";
	$result   = mysqli_query($connection, $query) or die(mysqli_error($connection));
	$count=mysqli_num_rows($result);

	if($count==1)
	{
		$rows=mysqli_fetch_array($result);
		$email = $rows['email'];
		
		$key = genNewKey();
		$encryptedKey = password_hash($key, PASSWORD_DEFAULT);

		$insertNewKeyToDb = "UPDATE uzytkownik SET klucz = '$encryptedKey' WHERE identyfikator = '$username'";

		if ($connection->query($insertNewKeyToDb) === TRUE)
		{}
		else
		{
			echo "Error: " . $insertNewKeyToDb . "<br>" . $connection->error;
		}
		$connection->close();

		$mail = new PHPMailer();
	    	$mail->CharSet =  "utf-8";
	    	$mail->IsSMTP();
	    	$mail->SMTPAuth = true;
	    	$mail->Username = "recoverykey.e.systempieniezny@gmail.com";
	    	$mail->Password = "RecKey2017!";
		$mail->SMTPSecure = "ssl";  
	    	$mail->Host = "smtp.gmail.com";
	    	$mail->Port = "465";
	 
	    	$mail->setFrom('recoverykey.e.systempieniezny@gmail.com', 'Recovery Key');
	    	$mail->AddAddress($email, $email);
	 
	    	$mail->Subject  =  'New Key';
	    	$mail->IsHTML(true);
	    	$mail->Body    = 'Hi,
		                  			<br />
						  	your new key is: '.$key.'
						  	<br />
						  	cheers...';
			
		if($mail->Send())
		{
			echo "<center><h1>Your Password Has Been Sent To Your Email Address</h1></center>";
			header("refresh:5;url=index.php");
		}
		else
		{
			echo "Mail Error - >".$mail->ErrorInfo;
		}
	} 
	else
	{
		if($to != "")
		{
	    	$fmsg = "Not found your email in our database";
	    	echo $fmsg;
		}
	}
}
?>