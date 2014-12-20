<?php
include("config.php");
$q=mysql_query("CREATE TABLE IF NOT EXISTS `fbusers` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `fbid` varchar(255) NOT NULL,
  `fbname` varchar(255) NOT NULL,
  `fbgender` varchar(255) NOT NULL,
  `fblocation` varchar(255) NOT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1 AUTO_INCREMENT=1 ;");
