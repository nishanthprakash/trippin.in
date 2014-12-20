<?php 

$db_host = "mysql1.alwaysdata.com";
// Place the username for the MySQL database here
$db_username = "anandghegde"; 
// Place the password for the MySQL database here
$db_pass = "se123";
// Place the name for the MySQL database here
$db_name = "anandghegde_se";

$connection = mysql_connect($db_host,$db_username,$db_pass) or die(mysql_error());
mysql_select_db($db_name,$connection) or die("no database by that name");

$userID=101;
$itemID=202;
$r=7;
echo "<html> Thank you for rating $itemID $r, $userID </html>";
$sql = "INSERT INTO rating VALUES ($userID, $itemID, $r,'')";

if (!mysql_query($sql, $connection))
{
    die('Error: ' . mysql_error());
}
echo "1 record added";


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

?>