<?php

$db_host = "mysql1.alwaysdata.com";
// Place the username for the MySQL database here
$db_username = "anandghegde"; 
// Place the password for the MySQL database here
$db_pass = "se123";
// Place the name for the MySQL database here
$db_name = "anandghegde_se";

mysql_connect("$db_host","$db_username","$db_pass") or die(mysql_error());
mysql_select_db("$db_name") or die("no database by that name");

$data = mysql_query("SELECT * FROM Location");

//use session variable value for searched place n get row/rating of only that place...if such a place doesnt exist...say F U n give a rating form...if rated add to database !


while($row=mysql_fetch_assoc($data)){
	
	$id=$row["id"];
	$place=$row["place"];
	$current_rating=$row["rating"];
	$hits=$row["hits"];
	$summary=$row["summary"];
	
	echo "
		<form action='rate.php' method='POST'>
			$place : <select name ='rating'>
			<option>1</option>
			<option>2</option>
			<option>3</option>
			<option>4</option>
			<option>5</option>
					</select>
		<input type='hidden' value='$id' name='placid'>
		<input type='submit' value='Rate it yo !'> 
		Current Rating : "; echo $current_rating; echo " ($hits votes)
		</form>	
		";
	
	}
?>