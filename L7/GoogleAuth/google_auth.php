<?php

//Include GP config file && User class
include_once 'gpConfig.php';
include_once 'User.php';
include "connect.php";

if(isset($_GET['code']))
{
    $gClient->authenticate($_GET['code']);
    $_SESSION['token'] = $gClient->getAccessToken();
    header('Location: ' . filter_var($redirectURL, FILTER_SANITIZE_URL));
}

if (isset($_SESSION['token'])) 
{
    $gClient->setAccessToken($_SESSION['token']);
}

if ($gClient->getAccessToken())
{
    //Get user profile data from google
    $gpUserProfile = $google_oauthV2->userinfo->get();
    
    //Initialize User class
    $user = new User();
    
    //Insert or update user data to the database
    $gpUserData = array(
        'oauth_provider'=> 'google',
        'oauth_uid'     => $gpUserProfile['id'],
        'first_name'    => $gpUserProfile['given_name'],
        'last_name'     => $gpUserProfile['family_name'],
        'email'         => $gpUserProfile['email'],
        'gender'        => $gpUserProfile['gender'],
        'locale'        => $gpUserProfile['locale'],
        'picture'       => $gpUserProfile['picture'],
        'link'          => $gpUserProfile['link']
    );
    $userData = $user->checkUser($gpUserData);
    

    $connection = @new mysqli($host, $db_user, $db_password, $db_name);
        
    if ($connection->connect_errno!=0)
    {
        echo "Error: ".$connect->connect_errno;
    }

    if (isset($userData['email']))
    {
        $userEmail = $userData['email'];
        $query="SELECT imie, nazwisko, dataUrodzenia, ulica, nrDomu, kodPocztowy, miejscowosc, panstwo, numerKonta, stanKonta FROM uzytkownik JOIN klient ON uzytkownik.id_uzytkownik = klient.id_uzytkownik JOIN konto ON konto.id_konto = klient.id_konto WHERE email ='$userEmail'";
        $result   = mysqli_query($connection, $query) or die(mysqli_error($connection));
        $count=mysqli_num_rows($result);

        if($count==1)
        {
            $rows=mysqli_fetch_array($result);
            $_SESSION['imie'] = $rows['imie'];
            $_SESSION['nazwisko'] = $rows['nazwisko'];
            $_SESSION['dataUrodzenia'] = $rows['dataUrodzenia'];
            $_SESSION['ulica'] = $rows['ulica'];;
            $_SESSION['nrDomu'] = $rows['nrDomu'];
            $_SESSION['kodPocztowy'] = $rows['kodPocztowy'];
            $_SESSION['miejscowosc'] = $rows['miejscowosc'];
            $_SESSION['panstwo'] = $rows['panstwo'];
            $_SESSION['numerKonta'] = $rows['numerKonta'];
            $_SESSION['stanKonta'] = $rows['stanKonta'];
            $_SESSION['userData'] = $userData;
            $_SESSION['logged_in'] = true;
        }
    }
} 
else 
{
    $authUrl = $gClient->createAuthUrl();
    $output = '<a href="'.filter_var($authUrl, FILTER_SANITIZE_URL).'">Zaloguj przez Google</a>';
}

?>

<div><?php  echo $output; ?></div>