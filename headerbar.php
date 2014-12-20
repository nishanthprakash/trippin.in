<?php
//session_start(); ?>

 <?php
require 'fb/facebooklib/facebook.php';
require_once("config.php");
$config = array();
$config['appId'] = '283002241786060'; //your application id 
$config['secret'] = '6803c688ed96b1f71fa3285677b358f7'; //your application secret 

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
  $logoutUrl = $facebook->getLogoutUrl(array( 'next' => ("http://trippin.in/logout.php") ));
} else {
  $loginUrl = $facebook->getLoginUrl(array( 'redirect_uri' => ("http://trippin.in/index.php") ));
}

if($user){
  $fbid = $user;
  $fbname = $user_profile['name'];
  $fbgender = $user_profile['gender'];
  $fblocation = $user_profile['location']['name'];
  $fbprofile=$user_profile['link'];
}
?>

<body>



<div class="navbar navbar-fixed-top">
      <div class="navbar-inner">
        <div class="container">
          <a class="btn btn-navbar" data-toggle="collapse" data-target=".nav-collapse">
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
          </a>
           <a class="brand" href="index.php"> Trippin'</a>
          <div class="nav-collapse">

            <ul class="nav">
            
              <li class="active"><a href="index.php">Home</a></li>

              <li><a href="about.php">About</a></li>
		
               <li><?php 
		 if(!$user) { 
				echo '<a href="'.$loginUrl.'">FB Login</a>';
	       }else{ 
				echo '<a href="'.$logoutUrl.'">Logout</a>';
		   }
	?>
</li>

  
  
            </ul>
	<?php 
	if($user){
		$_SESSION['fbid']=$fbid;
			//Simple check - for Replication of users data
			$check = mysql_query("SELECT * FROM fbusers WHERE fbid='".$fbid."'");
			$count = mysql_num_rows($check);
			
			if($count == 0){
				// If user first time visit then insert its info into db
				$InsertQuery = mysql_query("INSERT INTO fbusers(fbid, fbname, fbgender, fblocation,fblink)
				 VALUES (".$fbid.",'".$fbname."', '".$fbgender."', '".$fblocation."','".$fbprofile."')");
			}else{
				// If user already in our db just update its info into db
				mysql_query("UPDATE fbusers SET fbname = '".$fbname."', fbgender='".$fbgender."', fblink='".$fbprofile."',fblocation='".$fblocation."'
				WHERE fbid=".$fbid."");
			}
			}
		
	?>
            
          </div>
        </div>
      </div>
    </div>
