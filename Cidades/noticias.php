<!DOCTYPE html>
<html lang="en">
<head>
  <link rel="stylesheet" type="text/css" href="css.css">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">
  <meta charset="UTF-8">
  <title>Noticias </title>
</head>
<body>
<body>

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
</body>
</html>


<?php
$location = $_GET['localidade'];
$wcountry = $_GET['pais'];
$url1 = 'https://newsapi.org/v2/top-headlines?country=';
$url2 = '&category=business&apiKey=a5b8173fe2d94977ae5dc07a4ecaca1f';
$urlcompleto = $url1 . $wcountry . $url2;
$urlArticles = file_get_contents("$urlcompleto");
$urlArticlesArray = json_decode($urlArticles, true);
$articles = $urlArticlesArray['articles'];

for ($i = 0; $i < count($articles); $i++)
	{
	$sites = $urlArticlesArray['articles'][$i];
	echo $sites['title'];
	echo "<br />";
	echo "<br />";
	echo "<a href='" . $sites['url'] . "'>$sites[url]</a>";
	echo "<br />";
	echo "<br />";
	echo '<img src="' . $sites['urlToImage'] . '">';
	echo "<br />";
	echo "<br />";
	}

?>
