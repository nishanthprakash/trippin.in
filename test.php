<?php

$foursquare = file_get_contents("https://api.foursquare.com/v2/venues/explore?ll=19.0759837,72.8776559&oauth_token=QLU4CPPHBCDT4VUFCF3HDRNNHEAFYQHV5HK0JUX1QC1KZXKU&v=20120331");
$foursquare=json_decode($foursquare, true);
//print_r($foursquare);
$numberOfPlaces = ($foursquare["response"]["keywords"]["count"]);
$i=0;
?><table class="table">
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
echo "</td><td><b>";
print_r($foursquare["response"]["groups"][0]["items"][$i]["venue"]["name"]);
echo "</b>";
echo "<br/>";

print_r($foursquare["response"]["groups"][0]["items"][$i]["venue"]["location"]["address"]);
echo "<br/>";
print_r($foursquare["response"]["groups"][0]["items"][$i]["venue"]["location"]["crossStreet"]);
echo "<br/>" ;
echo "<blockquote>";
print_r($foursquare["response"]["groups"][0]["items"][$i]["tips"][0]["text"]);
echo "<br/>";
echo "</blockquote>";
echo "</td></tr>";
}
?>
</table>