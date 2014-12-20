<html>
<head>
<title>Register Now!</title>

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

</head>
<body>
<div>
<center>
<br/>
<br/>
<b>
<font size="5" face="arial" color="black">
<table>
<form action="insertuser.php" method="post">
<tr>
<td>Enter desired username (alphanumeric only)</td>
<td><input type="text" name="username" /></td>
</tr>
<tr><p></p></tr>
<tr>
<td>Enter password</td>
<td><input type="password" name="password" /></td>
</tr>
<tr>
</tr>
<tr><p></p></tr>
<tr><p></p></tr>
<tr>
<td>Confirm password</td>
<td><input type="password" name="confirm-password" /></td>
</tr>
<tr>
</tr>
<tr><p></p></tr>
<tr>
<td>Enter Name</td>
<td><input type="text" name="name" /></td>
</tr>
<tr>
<td>Enter Email</td>
<td><input type="text" name="email" /></td>
</tr>
<tr>
<td>Enter Location</td>
<td><input type="text" name="location" /></td>
</tr>
</table>
</font>
</b>
<input type="submit" name="submit" />
</form>

<p></p>
</center>
</div>
</body>