<?php
include "twitteroauth/twitteroauth.php";

$location = $_GET['localidade'];
$country = $_GET['pais'];

$url1 = "https://api.twitter.com/1.1/search/tweets.json?q=";
$url2 = "&result_type=recent&count=20";
$virgula = ",";
$urlcompleto = $url1 . $location . $virgula . $country . $url2;
$consumer_key = "pviGeLbWhsWr6CDg2Lc8R6dXb";
$consumer_secret = "K1qGlDh6aN6Ces2L37iwJHfkJYmOrXLx3C4LdL9g4MbTCGhQNN";
$access_token = "911755442132529152-htLPHpxy6rYbQsP350rH9H5OfiFcLnn";
$access_token_secret = "LXUuKGFaekscx1cgQLoe0W30taXxwiIwCEUWtHdrWE01J";
$twitter = new TwitterOAuth($consumer_key, $consumer_secret, $access_token, $access_token_secret);

$tweets = $twitter->get("$urlcompleto");

?>
<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="css.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta charset="UTF-8">
  <title>Pesquisa Twitter</title>
</head>
<body background="twitte.png" bgproperties="fixed">

<div id="inicio">

<div id="Anterior">
<form action="javascript:history.go(-1)">
    <input type="submit" value="Página Anterior" />
</form>
</div>
<div id="Inicial">
<form action="http://localhost:8080/SIR/SIR%20API'S%20-%2017515%20-%20Carlos%20Pinheiro/API'S.html">
    <input type="submit" value="Página Inicial" />
</form>
</div>
</div>

<div>
<?php
foreach($tweets->statuses as $key => $tweet)
	{ ?>
  <img src="<?php echo $tweet->user->profile_image_url; ?>" /><?php echo $tweet->text; ?><br />
<?php
	} ?>
</div>

</body>
</html>