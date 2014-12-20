<?php
session_start();
require_once("config.php");

/*
if(isset($_SESSION['fbid']))
{$loggedin=1;}
else{$loggedin=0;}
*/
?>

<!DOCTYPE html>
<html lang="en">
  <head>
  
  
<link href='http://fonts.googleapis.com/css?family=Alfa+Slab+One' rel='stylesheet' type='text/css'>    <meta charset="utf-8">
    <title> Trippin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="">
    <meta name="author" content="">

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
    <script type="text/javascript" src="http://twitter.github.com/bootstrap/1.4.0/bootstrap-tabs.js"></script>  <script src="js/script.js" language="javascript" type="text/javascript" ></script>
	<!--chroma plugin -->
	<script src="http://www.google.com/jsapi"></script>
  <script type="text/javascript" charset="utf-8">
     google.load("jquery", "1.3.2");
  </script>  
	<script src="js/chroma-hash.js" type="text/javascript" charset="utf-8"></script>
	<script type="text/javascript" charset="utf-8">
	  $(document).ready(function() {
      $("input:password").chromaHash({bars: 3});
      $("#username").focus();
    });
	</script>
	
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
  <div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = "//connect.facebook.net/en_US/all.js#xfbml=1&appId=283002241786060";
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
    
 <?php require("headerbar.php");?>
    <div class="container" id="page">
<div class="fb-like" data-href="http://trippin.in" data-send="true" data-width="200" data-show-faces="false" data-font="arial"></div><br/>
  <?php

if($fbname!="") echo "<h4> Hi ${fbname}\n<br /> <a href=map.php?searchkey=".$fblocation."/>Get Info</a> on your current location</h4>";
  ?>

      <img id="logo" src="images/HolidayIconPalm.gif" width="50" height="50"/> <br/>
      <br/>
      <p><form id="searchForm" action="map.php" method="post">
   <input id="searchkey" name="searchkey" class="span3" size="56" type="text" placeholder="Search for a city..">
  <button type="submit" class="btn btn-primary btn-large">Search</button>
</form></p>

    </div> <!-- /container -->



  </body>
</html>