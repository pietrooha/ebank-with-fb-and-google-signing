<?php

session_start();

include "/opt/lampp/htdocs/crypto/L4/Lista4/Lista7/L7/connect.php";
require_once __DIR__ . '/Facebook/autoload.php';


$fb = new Facebook\Facebook([
  'app_id' => '1852882558325683', // Replace {app-id} with your app id
  'app_secret' => '855fb024290e34a31a77e15517f58106',
  'default_graph_version' => 'v2.8',
  ]);

$helper = $fb->getRedirectLoginHelper();

try
{
  $accessToken = $helper->getAccessToken();
} 
catch(Facebook\Exceptions\FacebookResponseException $e)
{
  // When Graph returns an error
  echo 'Graph returned an error: ' . $e->getMessage();
  exit;
}
catch(Facebook\Exceptions\FacebookSDKException $e)
{
  // When validation fails or other local issues
  echo 'Facebook SDK returned an error: ' . $e->getMessage();
  exit;
}

if (! isset($accessToken))
{
  if ($helper->getError())
  {
    header('HTTP/1.0 401 Unauthorized');
    echo "Error: " . $helper->getError() . "\n";
    echo "Error Code: " . $helper->getErrorCode() . "\n";
    echo "Error Reason: " . $helper->getErrorReason() . "\n";
    echo "Error Description: " . $helper->getErrorDescription() . "\n";
  } 
  else
  {
    header('HTTP/1.0 400 Bad Request');
    echo 'Bad request';
  }
  exit;
}

// The OAuth 2.0 client handler helps us manage access tokens
$oAuth2Client = $fb->getOAuth2Client();

// Get the access token metadata from /debug_token
$tokenMetadata = $oAuth2Client->debugToken($accessToken);
$userId = $tokenMetadata->getUserId();

$connection = @new mysqli($host, $db_user, $db_password, $db_name);
    
if ($connection->connect_errno!=0)
{
    echo "Error: ".$connect->connect_errno;
}

if (isset($userId))
{
    $query="SELECT imie, nazwisko, dataUrodzenia, ulica, nrDomu, kodPocztowy, miejscowosc, panstwo, numerKonta, stanKonta FROM uzytkownik JOIN klient ON uzytkownik.id_uzytkownik = klient.id_uzytkownik JOIN konto ON konto.id_konto = klient.id_konto WHERE fbUserId ='$userId'";
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
        $_SESSION['logged_in'] = true;
        header('Location: /crypto/L4/Lista4/Lista7/L7/index.php');
    }
}
else
{
  echo 'User not found';
}

?>