<?php
session_start();
session_register('fbid');
session_register('searchplace');
session_register('reco');
require("config.php");
?>

<!DOCTYPE html>
<html lang="en">
  <head>
<link href='http://fonts.googleapis.com/css?family=Alfa+Slab+One' rel='stylesheet' type='text/css'>    <meta charset="utf-8">
    <title> Trippin'</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">
<?php
include_once("gmaps/GoogleMap.php");
include_once("gmaps/JSMin.php");
include 'wa_wrapper/WolframAlphaEngine.php';

if($_GET['searchkey']!="")
{
$requested = strtolower($_GET['searchkey']);} 
else{$requested = strtolower($_POST['searchkey']);
}
 $requested = str_replace("/", "",$requested);
 if(strpos($requested,",")!=0){
 $requested = substr($requested, 0, strpos($requested, ","));}

if(!$requested){
$requested=$_SESSION['searchplace'];
	//echo $_SESSION['searchplace']; //
	if(!$requested){
	echo "<h2>No Search String</h2>";
	exit;
}
}
else{
	$_SESSION['searchplace']=$requested;
	//echo $_SESSION['searchplace'];
	}
	//echo $requested;
$appID = 'J5RGVE-434LU67HY6';
$engine = new WolframAlphaEngine( $appID );


$MAP_OBJECT = new GoogleMapAPI(); $MAP_OBJECT->_minify_js = isset($_REQUEST["min"])?FALSE:TRUE;
$MAP_OBJECT->addMarkerByAddress($requested, "Marker Title", "Marker Description");
$MAP_OBJECT->enableStreetViewControls();
$MAP_OBJECT->setMapType('map');
$geocode = $MAP_OBJECT->getGeocode($requested);
if(!$geocode){$placeExists=1;}
else{$placeExists=0;}
$MAP_OBJECT->setWidth('102%');
//print_r($geocode);
$lat=$geocode['lat'];
$lon=$geocode['lon'];
?>
    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    <link href="style.css" rel="stylesheet">
    <style>
      body {
        padding-top: 60px; /* 60px to make the container go all the way to the bottom of the topbar */
      }
    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
 <script type="text/javascript" src="js/jquery-min.js"></script>
    <script type="text/javascript" src="js/bootstrap-tab.js"></script>
    <script type="text/javascript" src="js/bootstrap-dropdown.js"></script>  <script src="js/script.js" language="javascript" type="text/javascript" ></script>
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  
  
	<!--jQuery lightbox
	-->
	<script type="text/javascript" src="js/jquery.js"></script>
	<script type="text/javascript" src="js/jquery.lightbox-0.5.js"></script>
	<link rel="stylesheet" type="text/css" href="css-lightbox/jquery.lightbox-0.5.css" media="screen" />
	
	<script type="text/javascript">
	$(function() {
	// Use this example, or...
	$('a[@rel*=lightbox]').lightBox({
		imageLoading: 'images/lightbox-ico-loading.gif',
	imageBtnClose: 'images/lightbox-btn-close.gif',
	imageBtnPrev: 'images/lightbox-btn-prev.gif',
	imageBtnNext: 'images/lightbox-btn-next.gif',
	}); // Select all links that contains lightbox in the attribute rel
	});
	</script>
	<!--jQuery lightbox
	-->
  
  </head>

  <body>

<?php require("headerbar.php"); ?>
 <div class="container-fluid">
  <div class="row-fluid">
    <div class="span6 sidecontent">
  <ul id="tabs" class="nav nav-tabs">
            <li class="active"><a href="#home" data-toggle="tab">Info</a></li>
            <li><a href="#profile" data-toggle="tab">Weather</a></li>
             <li><a href="#poi" data-toggle="tab">Places Of Interest</a></li>
             <li><a href="#geography" data-toggle="tab">Geography</a></li>
             <li><a href="#recommended" data-toggle="tab">Hangout</a></li>
             <li><a href="#pics" data-toggle="tab">Pics</a></li>
             <li><a href="#ai" data-toggle="tab">AI</a></li>
             <li><a href="#theatres" data-toggle="tab">Theatres</a></li>
          </ul>
          <div id="myTabContent" class="tab-content">
            <div class="tab-pane fade in active" id="home">
              <p class="infoClass">  <?php 
    $ch = curl_init();
    $requested2 = str_replace(" ", '%20',$requested);
    $requested3 = str_replace(" ", '_',$requested);
    $requested4 = str_replace(" ", '+',$requested);

   // echo $requested2;
$add = 'https://www.googleapis.com/freebase/v1/text/en/'.$requested3;
curl_setopt ($ch, CURLOPT_URL, "$add");
curl_setopt ($ch, CURLOPT_POST, 0);
curl_setopt ($ch, CURLOPT_COOKIEFILE, 'files/cookie.txt');
curl_setopt ($ch, CURLOPT_FOLLOWLOCATION, 0);
curl_setopt ($ch, CURLOPT_RETURNTRANSFER, TRUE);
$postdata = curl_exec ($ch);
$resultarray = json_decode($postdata, true);
if(!$resultarray["result"] || $placeExists!=0)
{
	$resulttext="<h4>Sorry, No Info available for this place.</h4>";
}
else if($placeExists==0){
$resulttext=preg_replace("/\([^\)]+\)/","",$resultarray["result"]); // 'ABC '
$resulttext=preg_replace('#\.\s*[^\.]+$#ms', '.', $resulttext);
$resulttext=str_replace(")", '', $resulttext);}
echo "<div class='well'>";
echo $resulttext;
echo "</div>";
$findCountryURL="http://api.geonames.org/searchJSON?q=${requested2}&maxRows=10&username=jacksparrow007";
//echo $findCountryURL;
$findCountry = file_get_contents($findCountryURL);
$findCountry=json_decode($findCountry,true);
//print_r($findCountry);
$country=$findCountry["geonames"][0]["countryName"];
$country=str_replace(" ", "%20", $country);
//echo $country;
$findWeatherURL = "http://api.wunderground.com/api/4404ee2f54f258eb/geolookup/conditions/forecast/q/${country}/${requested2}.json";
//echo $findWeatherURL;
$findWeather=file_get_contents($findWeatherURL);
$findWeather=json_decode($findWeather, true);
//print_r($findWeather);
//print_r($findWeather["forecast"]["txt_forecast"]["forecastday"][0] );


$i=0;

?></p>
            </div>
            <div class="tab-pane fade" id="profile">
              <p><?php
              if(!$findWeather["forecast"]["txt_forecast"]["forecastday"][0] || $placeExists!=0){
echo "<div class='well'><h4>Sorry, No Weather Info available for this place at this time.</h4></div>";
}
else{?><table class="table"><?php 
              for($i=0;$i<8;$i++)
			{
				echo "<tr><td width=70px>";
				echo $findWeather["forecast"]["txt_forecast"]["forecastday"][$i]["title"];
				echo "</td><td width=50px><img src='";
				echo $findWeather["forecast"]["txt_forecast"]["forecastday"][$i]["icon_url"];
				echo "' /></td><td>";
				echo $findWeather["forecast"]["txt_forecast"]["forecastday"][$i]["fcttext"];
				echo "</td></tr>";
				}
				?>
				</table><?php } ?></p>
            </div>
            <div class="tab-pane fade" id="poi">
             <p><table class="table">
            <?php
            
            $poiURL = "https://maps.googleapis.com/maps/api/place/search/json?location=${lat},${lon}&radius=10000&&sensor=false&key=AIzaSyAHGNFyAkkPUj1vLEwG4sFLaZzwir8SXQ8";
            $getpoi = file_get_contents($poiURL);
            $getpoi=json_decode($getpoi, true);
            $leng=sizeof($getpoi["results"]);
            $k=1;
             for($k=1;$k<$leng;$k++)
			{
				echo "<tr><td width=70px>";
				echo "<img src='";
				echo $getpoi["results"][$k]["icon"];
				echo "' /></td><td>";
				$nameOfPoi=$getpoi["results"][$k]["name"]; echo $nameOfPoi; echo "<br/>";
				$latOfPoi = $getpoi["results"][$k]["geometry"]["location"]["lat"];
				//echo $latOfPoi;
				$lngOfPoi = $getpoi["results"][$k]["geometry"]["location"]["lng"];
				$MAP_OBJECT->addMarkerByCoords($lngOfPoi,$latOfPoi, $nameOfPoi,"<b>${nameOfPoi}</b>");
				echo $getpoi["results"][$k]["vicinity"];
				echo "</td></tr>";
				}
				?>
				</table></p>

            </div>
                        <div class="tab-pane fade" id="geography">
                      <?php   if($placeExists==0){ $response = $engine->getResults( $requested );?>
                      <?php
  if ( count($response->getPods()) > 0 && $placeExists==0) {
?>
    <table class="table">
<?php
    foreach ( $response->getPods() as $pod ) {
?>
      <tr>
        <td>
          <h3><?php echo $pod->attributes['title']; ?></h3>
<?php
        foreach ( $pod->getSubpods() as $subpod ) {
?>
          <img src="<?php echo $subpod->image->attributes['src']; ?>">
          <hr>
<?php
        }
?>
          
        </td>
      </tr>
<?php
    }
?>
    </table>
<?php
  }
  else{
  echo "<div class='well'><h4>Sorry, No Geographical Info available for this place at this time.</h4></div>";
  
  }
}
else{
  echo "<div class='well'><h4>Sorry, No Geographical Info available for this place at this time.</h4></div>";
  
  }
  ?>


</div>
 <div class="tab-pane fade" id="recommended">
 
 <?php
if($placeExists==0){
$foursquare = file_get_contents("https://api.foursquare.com/v2/venues/explore?ll=${lat},${lon}&oauth_token=QLU4CPPHBCDT4VUFCF3HDRNNHEAFYQHV5HK0JUX1QC1KZXKU&v=20120412");
$foursquare=json_decode($foursquare, true);
//print_r($foursquare);
$numberOfPlaces = $foursquare["response"]["keywords"]["count"];
$i=0;
}
?><p><?php 
if($numberOfPlaces==0 && $placeExists==1){
echo "<div class='well'><h4>Sorry, No Recommendations available for this place.</h4></div>"; 
}
else{
echo "<h3>Recommended Places</h3>";?>
<table class="table">
<?php
for($i=0;$i<$numberOfPlaces;$i++)
{

echo "<tr><td>";
$link=($foursquare["response"]["groups"][0]["items"][$i]["venue"]["categories"][0]["icon"]["prefix"]);
$link=$link.$foursquare["response"]["groups"][0]["items"][$i]["venue"]["categories"][0]["icon"]["sizes"][2];
//$link=str_replace("_", '', $link);
//$link = substr($link, 0, strlen($link)-1); 
$link=$link.$foursquare["response"]["groups"][0]["items"][$i]["venue"]["categories"][0]["icon"]["name"];
echo "<img src='";
echo $link;echo "' />";
echo "<br/><br/>";
print_r($foursquare["response"]["groups"][0]["items"][$i]["venue"]["categories"][0]["name"]);
$venue_id=$foursquare["response"]["groups"][0]["items"][$i]["venue"]["id"];
$venue_URL="http://foursquare.com/v/".$venue_id;
echo "</td><td><a href=${venue_URL} target ='_blank'><b>";
print_r($foursquare["response"]["groups"][0]["items"][$i]["venue"]["name"]);
echo "</b></a>";
echo "<br/>";

print_r($foursquare["response"]["groups"][0]["items"][$i]["venue"]["location"]["address"]);
echo "<br/>";
print_r($foursquare["response"]["groups"][0]["items"][$i]["venue"]["location"]["crossStreet"]);
echo "<br/><br/><i>" ;
echo "<blockquote>";
print_r($foursquare["response"]["groups"][0]["items"][$i]["tips"][0]["text"]);
echo "<br/>";
echo "</blockquote></i>";
echo "</td></tr>";
}
?>
</table><?php } ?></p>
 </div>
 <div class="tab-pane fade" id="pics">
  <ul class="thumbnails">
   <?php
   if($placeExists==0){
  $a="http://api.tixik.com/api/nearby?lat=${lat}&lng=${lon}&limit=12&key=20120414150356090742823&lang=en";
  //echo $a;
  $x=simplexml_load_file($a, 'SimpleXMLElement', LIBXML_NOCDATA);
 foreach ($x->items->item as $item) {
 echo "<li class='span2'><div class='thumbnail'><a href='";
 echo $item->tn_big;
 echo "' rel='lightbox'>" ;
 echo "<img class='timg' src='";
 echo $item->tn_big;
 echo "' /></a>" ;
echo "<div class='caption'><h5>";
 echo $item->name;
 echo "</h5></div>";
 echo "</div></li>" ;}
 }

?>
</ul>



 </div>
             <div class="tab-pane fade" id="ai">
             		<?php

//----------------------------------------------------------------------ratings
$loc=$_SESSION['searchplace'];

$fbid=$_SESSION['fbid'];

$data = mysql_query("SELECT * FROM Location WHERE place='$loc'");

//use session variable value for searched place n get row/rating of only that place...if such a place doesnt exist...say F U n give a rating form...if rated add to database !


$row=mysql_fetch_assoc($data);
	
	$id=$row["id"];
	$place=$_SESSION['searchplace'];
	$current_rating=$row["rating"];
	$hits=$row["hits"];
	$summary=$row["summary"];
	$cool=$_SESSION['reco'];
	//echo $_SESSION['reco'];
	if(!$cool){$cool = "No recommendation for you sadly...rate a few more places and ask your friends to rate too. It helps the AI bot recommend better :) ";}
	echo "	Rate and get personalized recommendations now !!! <br /><br />
		<form action='rate.php' method='POST'>
			$loc : <select name ='rating'>
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
					</select>
		<input type='hidden' value='$id' name='placid'>
		<input type='hidden' value='$uid' name='uid'>
		<input type='hidden' value='$place' name='place'>
		<input type='submit' value='Rate it yo !'> 
		Current Rating : "; echo $current_rating; echo " ($hits votes)
		</br><h3> Recommended Places for you based on your ratings:</h3><br/>".
		$cool.
		"</form>	
		<br />
		";
	
	
echo "<h3>Reviews & their Summary</h3>";
//--------------------------------------------------------------------summary review

$data = mysql_query("SELECT id FROM fbusers WHERE fbid='$fbid'") or die('Error: ' . mysql_error());

while($row = mysql_fetch_assoc($data)){
	$uid=$row['id'];
}

error_reporting(E_ALL);

require_once 'includes/summarizer.php';
require_once 'includes/html_functions.php';

$data = mysql_query("SELECT fbname, text FROM summary,fbusers WHERE placeid='$id' AND fbusers.id=summary.uid") or die('Error: ' . mysql_error());
$summit='';
while($row = mysql_fetch_assoc($data)){
	//$user=$row['fbname'];
	$rev=$row['text'];
	$summit=$summit." ".$rev;
	//echo "<br/> $user : $rev <br/>";
}

$summarizer = new Summarizer();
$texty='';
if (!empty($_POST['text'])){

	$texty = $_POST['text'];
	$sql = "INSERT into summary VALUES($uid, $id, '$texty')";
            mysql_query($sql) or die('Error: ' . mysql_error());
          }
            
          $summit=$summit.$texty;  

	$text = normalizeHtml($summit);

	$rez = $summarizer->summary($text);

	

	$summary = implode(' ',$rez);
	//echo '</pre>';
//}

$data = mysql_query("SELECT fbname, text FROM summary,fbusers WHERE placeid='$id' AND fbusers.id=summary.uid") or die('Error: ' . mysql_error());
//$summit='';
while($row = mysql_fetch_assoc($data)){
	$user=$row['fbname'];
	$rev=$row['text'];
	//$summit=$summit." ".$rev;
	echo "<br/> $user : $rev <br/>";
}


?>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<div align='center'>
<form method='POST' action='map.php'>

<textarea name='text' cols='50' rows='10'><?php 
	echo !empty($_POST['text'])?htmlspecialchars($_POST['text']):''; 
?></textarea><br/>
<input type='submit' name='submit' value='Post Your Review'>
</form>
<?php
	if(!empty($summary)) echo "Summary of the reviews above :".$summary."<br/>";
?>
</div>
             
                          </div> 
  
  
                        <div class="tab-pane fade" id="theatres">
                      <?php  if($placeExists==0){
                      $muvURL="http://trippin.in/muv.php?place=".$requested3;
$muvydata = file_get_contents($muvURL);
echo $muvydata;}else{echo "<h4> No theaters in the place</h4>";}
//$muvies=file_get_contents("textfiles/file.txt");
//echo $muvies;
?>                        </div>
          </div>
    </div>
    <script>
        $(function () {
            $('#tabs').tab();
        })
        </script>
    <div class="span6"><?php if($placeExists==0){?>
      <?=$MAP_OBJECT->getHeaderJS();?>
<?=$MAP_OBJECT->getMapJS();?>
    <?=$MAP_OBJECT->printOnLoad();?>
<?=$MAP_OBJECT->printMap();?>
    </div> <?php }?>
  </div>
</div>


  </body>
</html>