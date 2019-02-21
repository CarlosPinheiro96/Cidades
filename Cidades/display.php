<?php

if (isset($_GET["location"])) {
	$location = urlencode($_GET["location"]);
} else {
    $location = NULL;
}


if ($location) {
    $MAP_APIKEY = "XFNxQ82etHEFDAjhOSzhE4hozjwbRq45";
    $MAP_base_URL = "http://www.mapquestapi.com/geocoding/v1/address?";
    $MAP_key_param = "key=".$MAP_APIKEY;
    $MAP_location_param = "location=".$location;

    $MAP_URL = $MAP_base_URL.$MAP_key_param."&".$MAP_location_param;


    $geoData = file_get_contents($MAP_URL);  
    $geoDataPHP = json_decode($geoData);     

    $lat = $geoDataPHP->results[0]->locations[0]->latLng->lat;
    $lng = $geoDataPHP->results[0]->locations[0]->latLng->lng;

    $wlocation = $geoDataPHP->results[0]->locations[0]->adminArea5;
    $wcountry =  $geoDataPHP->results[0]->locations[0]->adminArea1;

  
    $url_base = "https://api.darksky.net/forecast";
    $url_sep = "/";
    $url_params = "?units=si";
    $api_key = "814e5b27d87937feb926c8b0178f77c3";


    $url = $url_base.$url_sep.$api_key.$url_sep.$lat.",".$lng.$url_params;


    $wforecastJSON = file_get_contents($url);
    $wforecastPHP  = json_decode($wforecastJSON);


    $temp = $wforecastPHP->currently->temperature;
    $iconTXT = $wforecastPHP->currently->icon;
    $iconURL = "https://darksky.net/images/weather-icons/".$iconTXT.".png";

    
} else {
    echo "go back and fill the form with some location";
}

?>
<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="UTF-8">
    <meta name="viewport" content="width=, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
	<title>Carlos Pinheiro API'S</title>
	<style type="text/css">
		img {	margin : 30px;
				border-style: solid;
				border-width: 1px;
				border-color: navy;
				border-radius: 20px;
		}
	</style>
    <link rel="stylesheet" type="text/css" href="css.css">
	<script src='https://api.tiles.mapbox.com/mapbox-gl-js/v0.51.0/mapbox-gl.js'></script>
    <link href='https://api.tiles.mapbox.com/mapbox-gl-js/v0.51.0/mapbox-gl.css' rel='stylesheet' />
</head>
<body id="fundo" >


<div>
<h5 id=cidade> <?php echo $wlocation;?> </h5>
 </div>



    <div class="weather">

		<div id='map' style='width: 500px; height: 400px; float: right; margin-top: 45px; margin-right: 100px'>
		</div>

<script src='https://unpkg.com/es6-promise@4.2.4/dist/es6-promise.auto.min.js'></script>
<script src="https://unpkg.com/@mapbox/mapbox-sdk/umd/mapbox-sdk.min.js"></script>
<script>
mapboxgl.accessToken = 'pk.eyJ1IjoiY21jcDk2IiwiYSI6ImNqcDlvMzNpbjFucmczcW8zNmxycnMya2MifQ.HeT2CNYycG3eKB8Ed1r9ng';



var mapboxClient = mapboxSdk({ accessToken: mapboxgl.accessToken });
mapboxClient.geocoding.forwardGeocode({
    query: 'value="<?php echo $location; ?>", value="<?php echo $wcountry; ?>"',
    autocomplete: false,
    limit: 1
})
    .send()
    .then(function (response) {
        if (response && response.body && response.body.features && response.body.features.length) {
            var feature = response.body.features[0];

            var map = new mapboxgl.Map({
                container: 'map',
                style: 'mapbox://styles/mapbox/satellite-streets-v9',
                center: feature.center,
                zoom: 14
            });
            new mapboxgl.Marker()
                .setLngLat(feature.center)
                .addTo(map);
        }
    });

</script>



<div id="tempo">
        <h1> Tempo atual em <?php echo $wlocation;?></h1>
        <img id="imagem-tempo" src="<?php echo $iconURL;?>" />
        <h1> Temperatura : <?php echo $temp; ?> </h1>
 </div>

    </div>

<div id = "divtwitter">
<form id="twtr" action="twitter.php" method="GET">
		<input type="hidden" name="localidade" value="<?php echo $location; ?>">
		<input type="hidden" name="pais" value="<?php echo $wcountry;?>" >
        <input type="submit" value="T">
    </form>

<form id="news" action="noticias.php" method="GET">
		<input type="submit" value="_">
		<input type="hidden" name="localidade" value="<?php echo $location; ?>">
		<input type="hidden" name="pais" value="<?php echo $wcountry; ?>">
    </form>
	</div>


<div id="content">
	

</div>
</body>


<script type="text/javascript">
	
	url_base = "https://api.flickr.com/services/rest/?";
	fmethod  = "method=flickr.photos.search";
	fapikey  = "api_key=1c029a053d66b93bc624ef93f77e5f98";
	fperpage = "per_page=12";
	fformat  = "format=json";
	fcallback= "nojsoncallback=1";
	fextras  = "extras=url_q";
	fsort = "sort=relevance";
	divcontent = document.getElementById("content");
	getPhotos();

	function getPhotos() {

		intextStr = value="<?php echo $location; ?>";
		fsearch = "text=" + intextStr;
		urlFinal = 	url_base + 
					fmethod + "&" + 
					fformat + "&" +
					fapikey + "&" +
					fcallback + "&" + 
					fextras + "&" + 
					fperpage + "&" +
					fsort + "&" + 
					fsearch;
		console.log(urlFinal);

 		req = new XMLHttpRequest();

		req.open("GET",urlFinal);
		req.onreadystatechange = function () {
			console.log(req.readyState);
			console.log(req.status);
			if (req.readyState == 4 && req.status == 200) {
				console.log(req.responseText);
				result = JSON.parse(req.responseText);
				console.log(result);
				for (i=0; i<result.photos.photo.length;i++) {
					nimg = document.createElement("img");
					nimg.setAttribute("src",result.photos.photo[i].url_q);
					divcontent.appendChild(nimg);
				}
			}
		}
		req.send();
	}
</script>




<fieldset id="wikipp" disabled="disabled">

	<?php 
		if(@$_GET['location']){
			$api_url = "https://en.wikipedia.org/w/api.php?format=json&action=query&prop=extracts&titles=".ucwords($_GET['location'])."&redirects=true";
			$api_url = str_replace(' ','%20',$api_url);

			if($data = json_decode(@file_get_contents($api_url))){
				foreach ($data->query->pages as $key=>$val) {
					$pageId = $key;
					break;
				}
				$content = $data->query->pages->$pageId->extract;
				header('Content-Type:text/html; charset=utf-8');
				
				echo "<p style=\"color:#000\">".$content."</p>";
			}else{
				echo 'No Result Found..';
			}
		}
	?>	
	</fieldset>
</body>
</html>
