<?php
session_start();
setcookie('fbs_177478695705807', '', time()-100, '/', 'anandghegde.in/se');
session_destroy();
header("Location: http://anandghegde.in/se");
?>