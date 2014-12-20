<?php
session_start();
require_once("config.php");
?>


<!DOCTYPE html>
<html lang="en">
  <head>
  
  
<link href='http://fonts.googleapis.com/css?family=Alfa+Slab+One' rel='stylesheet' type='text/css'>    <meta charset="utf-8">
    <title> About Trippin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

    <!-- Le styles -->
    <link href="bootstrap/css/bootstrap.css" rel="stylesheet">
    
    <link href="style.css" rel="stylesheet">
    <style>
      body {
        padding-top: 20px;
        padding-left: 20px;
     }
    </style>
    <link href="bootstrap/css/bootstrap-responsive.css" rel="stylesheet">
    
    	
    <!-- Le HTML5 shim, for IE6-8 support of HTML5 elements -->
    <!--[if lt IE 9]>
      <script src="http://html5shim.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->

    <!-- Le fav and touch icons -->
    <link rel="shortcut icon" href="../assets/ico/favicon.ico">
    <link rel="apple-touch-icon-precomposed" sizes="114x114" href="../assets/ico/apple-touch-icon-114-precomposed.png">
    <link rel="apple-touch-icon-precomposed" sizes="72x72" href="../assets/ico/apple-touch-icon-72-precomposed.png">
    <link rel="apple-touch-icon-precomposed" href="../assets/ico/apple-touch-icon-57-precomposed.png">
  </head>
  
  <body>
  
    
 <?php require("headerbar.php");?>
    <div class="container" >
    <br/><br/><br/><br/>
    <div class='well'>
    <p>
    <h1>About</h1>
	<br /><br />
	Trippin is your one-stop destination for getting information on a location just before a vacation, a short holiday or a weekend
	getaway. Never has planning your itinerary been this easy.<br />
	It makes use of various APIs to gather information about a place so that you get all you wanted to know
	about the place including: <br /><br />
	<ul>
	<li>Location on Google Maps</li>
	<li>Weather forecast for the week</li>
	<li>Places of interest</li>
	<li>Geography</li>
	<li>Pictures</li>
	</ul>
	<br />
	For a more personalized experience, you can now login using your Facebook account.<br />
	Rate and review a place, restaurants, clubs and help fellow travellers get a heads up on the best venues in town.</p>
</div>
     </div> <!-- /container -->

	
  </body>
</html>