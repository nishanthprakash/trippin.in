<?php 

$db_host = "localhost";
// Place the username for the MySQL database here
$db_username = "anandheg_test"; 
// Place the password for the MySQL database here
$db_pass = "testis";
// Place the name for the MySQL database here
$db_name = "anandheg_test";

$connection = mysql_connect($db_host,$db_username,$db_pass) or die(mysql_error());
mysql_select_db($db_name,$connection) or die("no database by that name");

$userID=100;
echo "<html>";
function predict_all($userID ) {
    $sql2 = "SELECT d.itemID1 as 'item', sum(d.count) as 'denom', 
    sum(d.sum + d.count*r.ratingValue) as 'numer' FROM rating r,
    dev d WHERE r.userID=$userID 
    AND d.itemID1<>r.itemID 
    AND d.itemID2=r.itemID GROUP BY d.itemID1";
    //return 
    $resul1 = mysql_query($sql2) or die($myQuery."<br/><br/>".mysql_error()); //, $connection);
    


while($row = mysql_fetch_array($resul1)){
	echo $row['item']. " - ". $row['denom']. " - ". $row['numer'] ;
	echo "<br />";
}
echo "</html>";
}

//$result = 

predict_all($userID);

?>