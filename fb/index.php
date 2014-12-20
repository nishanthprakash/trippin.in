<?php

require 'facebooklib/facebook.php';
include_once("../config.php");
$config = array();
$config['appId'] = ''; //your application id 
$config['secret'] = ''; //your application secret 

//facebook class object 
$facebook = new Facebook($config);

// Get User ID
$user = $facebook->getUser();

if ($user) {
  try {
	  // Get User Profile basic information
    $user_profile = $facebook->api('/me');
  } catch (FacebookApiException $e) {
    error_log($e);
    $user = null;
  }
}

//Login or Logout url 
if ($user) {
  $logoutUrl = $facebook->getLogoutUrl(array( 'next' => ("http://anandghegde.in/se/logout.php") ));
} else {
  $loginUrl = $facebook->getLoginUrl();
}

if($user){
  $fbid = $user;
  $fbname = $user_profile['name'];
  $fbgender = $user_profile['gender'];
  $fblocation = $user_profile['location']['name'];
}
?>
<html>
 <head>
     <title> Facebook PHP-SDK | { w4p }</title>
 </head>
 <body>
 <br/>
	 <!-- Login Logout url -->
	 <?php 
		 if(!$user) { 
				echo '<a href="'.$loginUrl.'">Login</a>';
	       }else{ 
				echo '<a href="'.$logoutUrl.'">Logout</a>';
		   }
	?>
	 </div>
	<?php 
	if($user){
		
			//Simple check - for Replication of users data
			$check = mysql_query("SELECT * FROM fbusers WHERE fbid='".$fbid."'");
			$count = mysql_num_rows($check);
			
			if($count == 0){
				// If user first time visit then insert its info into db
				$InsertQuery = mysql_query("INSERT INTO fbusers(fbid, fbname, fbgender, fblocation)
				 VALUES (".$fbid.",'".$fbname."', '".$fbgender."', '".$fblocation."')");
			}else{
				// If user already in our db just update its info into db
				mysql_query("UPDATE fbusers SET fbname = '".$fbname."', fbgender='".$fbgender."', fblocation='".$fblocation."'
				WHERE fbid=".$fbid."");
			}
		
	?>
		
      <pre><?php print_r($user_profile);  ?> </pre>
	<?php }else{ ?>
	       <div clear="all">&nbsp;</div>
		    <div>
			 <b><i>User Information display here...please login to see your facebook information
			</div>
	<?php } ?>
	
 </body>
</html>