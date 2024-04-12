<?php
// Load dependencies
require __DIR__ . '/vendor/autoload.php';
use Leaf\Blade;

// Declare global objects
$app = new Leaf\App();
$blade = new Blade('views', 'storage/cache');

# Load env variables
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__);
$dotenv->load();

// Main page
$app->get('/', function() use($app, $blade){
  echo $blade->render('main');
});

$app->get('/logout', function() use($app){
  $headr = array();
  $headr[] = 'Accept: application/json';
  $headr[] = 'Content-type: application/json';
  $headr[] = 'Authorization: Bearer ' . $_ENV['API_KEY_V3'];    
    
  $email = session()->get('email');
  $grant_id = session()->get('grant_id');
  
  $url = "https://api.us.nylas.com/v3/grants/" . $grant_id;
  $ch = curl_init( $url );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, $headr);
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  $result = curl_exec($ch);
  curl_close($ch);
  session()->delete(['email', 'grant_id']);
  echo "<script>location.href='/';</script>";
});

$app->get('/emails', function() use($app, $blade){
  $grant_id = session()->get('grant_id');
  if ($grant_id === NULL){
      echo "<script>location.href='/';</script>";
  }else{
    $headr = array();
    $headr[] = 'Accept: application/json';
    $headr[] = 'Content-type: application/json';
    $headr[] = 'Authorization: Bearer ' . $_ENV['API_KEY_V3'];  
    
    $email = session()->get('email');
    $grant_id = session()->get('grant_id');
  
    $url = "https://api.us.nylas.com/v3/grants/" . $grant_id . "/messages?limit=10";
    $ch = curl_init( $url );
    curl_setopt( $ch, CURLOPT_HTTPHEADER, $headr);
    curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
    $result = json_decode(curl_exec($ch));
    curl_close($ch);
    echo $blade->render('emails', ['emails' => $result->data]);
  }
});

$app->get('/oauth/exchange', function () use($app) {
  $email = request()->get('email');
  $grant_id = request()->get('grant_id');
  session()->set('email', $email);
  session()->set('grant_id', $grant_id);
  echo "<script>location.href='/emails';</script>";
});

$app->get('/auth', function () use($app) {

  $headr = array();
  $headr[] = 'Accept: application/json';
  $headr[] = 'Content-type: application/json';
  $headr[] = 'Authorization: Bearer ' . $_ENV['API_KEY_V3'];
    
  $data = array(
            'provider' => "google",
            'redirect_uri' => "http://localhost:8000/oauth/exchange",
            'state' => "123456",
        );  
    
  $url = "https://api.us.nylas.com/v3/connect/auth";
  $ch = curl_init( $url );
  $payload = json_encode( $data );
  curl_setopt( $ch, CURLOPT_POSTFIELDS, $payload );
  curl_setopt( $ch, CURLOPT_HTTPHEADER, $headr);
  curl_setopt($ch, CURLOPT_POST, true);
  curl_setopt( $ch, CURLOPT_RETURNTRANSFER, true );
  $result = json_decode(curl_exec($ch));
  $url = $result->data->url;
  echo "<script>location.href='$url';</script>";
  curl_close($ch);
});

$app->run();
?>
