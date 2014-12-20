<?php
session_start(); 


$db_host = "";
// Place the username for the MySQL database here
$db_username = ""; 
// Place the password for the MySQL database here
$db_pass = "";
// Place the name for the MySQL database here
$db_name = "";

$connection = mysql_connect($db_host,$db_username,$db_pass) or die(mysql_error());
mysql_select_db($db_name,$connection) or die("no database by that name");

//-----------------------------------------------------------------------------------------------avging

$placeid= $_POST['placid'];
$post_rating = $_POST['rating'];
$place= $_POST['place'];
$itemID=$_POST['placid'];
$a="hahahaha";
$data = mysql_query("SELECT * FROM Location WHERE id=$placeid");
$h=1;


if(!$data){
$query="INSERT INTO Location(place,rating,hits) VALUES('$place',$post_rating,$h)";
//$update_new = mysql_query($query) ; //or die('Error1a: ' . mysql_error());
if (!mysql_query($query))
{
    die('Error1a: ' . mysql_error());
}
$querya=mysql_query("SELECT id FROM Location WHERE place='".$place."'"); //this query jus doesnt work !
$rowi = mysql_fetch_assoc($querya) or die('Error1b: ' . mysql_error());
$itemID=$rowi['id'];
}



else{
while($row = mysql_fetch_assoc($data)){
	$id=$row['id'];
	$place=$row['place'];
	$current_rating=$row['rating'];
	$current_hits=$row['hits'];
}
$new_hits = $current_hits + 1;
$update_hits= mysql_query("UPDATE Location SET hits = '$new_hits' WHERE id='$id'");

$pre_rating = $current_rating*$current_hits + $post_rating;
$new_rating = $pre_rating/$new_hits;

$update_rating = mysql_query("UPDATE Location SET rating = '$new_rating' WHERE id='$id'");
}


//------------------------------------------------------------------------------------------for reco
$fbid=$_SESSION['fbid'];
//$itemID=$_POST['placid'];
$r=$_POST['rating'];
//echo "<html> Thank you for rating $itemID $r, $userID </html>";

$data = mysql_query("SELECT id FROM fbusers WHERE fbid='$fbid'") or die('Error2: ' . mysql_error());

while($row = mysql_fetch_assoc($data)){
	$userID=$row['id'];
}


//echo $userID." $itemID ".$r.'';
$userID=intval($userID);
$itemID=intval($itemID);
$r=intval($r);
$sql = "INSERT INTO rating(userID,itemID,ratingValue) VALUES ($userID, $itemID, $r)";

if (!mysql_query($sql, $connection))
{
    die('Error3: ' . mysql_error());
}



$sql = "SELECT DISTINCT r.itemID, r2.ratingValue - r.ratingValue 
            as rating_difference
            FROM rating r, rating r2
            WHERE r.userID=$userID AND 
                    r2.itemID=$itemID AND 
                    r2.userID=$userID;";
$db_result = mysql_query($sql,$connection);
$num_rows = mysql_num_rows($db_result);
 

while ($row = mysql_fetch_assoc($db_result)) {
    $other_itemID = $row["itemID"];
    $rating_difference = $row["rating_difference"];

    if (mysql_num_rows(mysql_query("SELECT itemID1 
    FROM dev WHERE itemID1=$itemID AND itemID2=$other_itemID",
    $connection)) > 0)  {
        $sql = "UPDATE dev SET count=count+1, 
	sum=sum+$rating_difference WHERE itemID1=$itemID 
	AND itemID2=$other_itemID";
        mysql_query($sql, $connection);
               
        if ($itemID != $other_itemID) {
            $sql = "UPDATE dev SET count=count+1, 
	    sum=sum-$rating_difference 
	    WHERE (itemID1=$other_itemID AND itemID2=$itemID)";
            mysql_query($sql, $connection);
        }
    }
    else { 
        $sql = "INSERT INTO dev VALUES ($itemID, $other_itemID,
        1, $rating_difference)";
        mysql_query($sql, $connection); 
	     
        if ($itemID != $other_itemID) {         
            $sql = "INSERT INTO dev VALUES ($other_itemID, 
	    $itemID, 1, -$rating_difference)";
            mysql_query($sql, $connection);
        }
    }    
}
//-----------------------------------------------------------------------------------------------predict

//$userID=$_SESSION['fbid'];
//echo "<html>";
function predict_all($userID ) {
    /*$sql2 = "SELECT d.itemID1 as 'item', sum(d.count) as 'denom', 
    sum(d.sum + d.count*r.ratingValue) as 'numer' FROM rating r,
    dev d WHERE r.userID=$userID 
    AND d.itemID1<>r.itemID 
    AND d.itemID2=r.itemID GROUP BY d.itemID1";*/
    
    $sql2 = "SELECT d.itemID1 as 'item', sum(d.count) as 'denom', 
    sum(d.sum + d.count*r.ratingValue) as 'numer' FROM rating r,
    dev d WHERE r.userID=$userID
    AND d.itemID1 NOT IN (SELECT itemID FROM rating  WHERE userID=$userID) 
    AND d.itemID2=r.itemID GROUP BY d.itemID1";
    //return 
    $resul1 = mysql_query($sql2) or die($myQuery."<br/><br/>".mysql_error()); //, $connection);
    
$_SESSION['reco']='';
while($row = mysql_fetch_array($resul1)){
	if($row['numer']/$row['denom'] > 2.5){
	$rpid=$row['item'];
	$sql3 = "SELECT place FROM Location WHERE id=$rpid";
    
    $resul2 = mysql_query($sql3) or die($myQuery."<br/><br/>".mysql_error()); //, $connection);
	}
}
if($resul2){
while($row5 = mysql_fetch_array($resul2)){
	//echo 
	$nizzyPlace=$row5['place'];
	$nizzyURL = "http://trippin.in/map.php?searchkey=".$nizzyPlace;
	$_SESSION['reco']=$_SESSION['reco']."<br/><a href=${nizzyURL}>${nizzyPlace}</a>";
	
	//echo "<br />";
}}
//echo "</html>";
}

//$result = 

predict_all($userID);



header("location: map.php");
?>
