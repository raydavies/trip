<!DOCTYPE html>
<html>
<head>
<meta charset="utf-8">
<meta name="viewport" content="width=device-width, initial-scale=1.0, user-scalable=no" />
<title>Log In</title>
<link rel="stylesheet" type="text/css" href="/trip/assets/css/fonts.css">
<link rel="stylesheet" type="text/css" href="/trip/assets/css/login.css">
</head>

<body>
<div id="postcard">
	<h1>Please sign in</h1>
	<?php echo '<span id="error">'.$_SESSION['errormsg'].'</span>'; ?><br>
	<form method="Post" action="">
	<label>Name</label><br>
	<input type="text" name="username" id="name" required="required"><br>
	<label>Password</label><br>
	<input type="password" name="password" id="pass" required="required"><br>
	<input type="submit" name="submit" value="Log In">
	</form>
</div>
</body>
</html>
