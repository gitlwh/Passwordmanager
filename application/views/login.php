<!DOCTYPE html>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title>KSA&D Interactive Passwords</title>

<link media="all" href="/styles/global.css" type="text/css" rel="stylesheet">
<link media="all" href="/styles/main.css" type="text/css" rel="stylesheet">


</head>
<body>
	<div id="wrapper" class="sub news">
    <div id="topHeader">
    	<?php include('incl/topHeader.incl.php'); ?>
    </div>
    <div id="topNav">
    </div>
	<div id="main" class="left">
  	<h3 class="login">ksa+d interactive Client Information Login</h3>
    <div id="login_box">
    <?php echo validation_errors(); ?>

		<form method="post" action="/index.php/home/login" class="loginForm">
			<table>
				<tr>
					<td><label for="username">Username:</label></td>
				</tr>
				<tr>
					<td><input type="text" id="username" name="username" /></td>
				</tr>
				<tr>
					<td><label for="password">Password:</label></td>
				</tr>
				<tr>
					<td><input type="password" id="password" name="password" /></td>
				</tr>
				<tr>
					<td>
						<input type="submit" id="login" name="login" value="Log In" />
					</td>
				</tr>
			</table>
		</form>
		</div>
	</div>
</div>
	
</body>
</html>