<?php

session_start();

if (isset($_SESSION["uname"])) {
	$header = "Logged in as " . $_SESSION["uname"] . "!";
} else {
	$header = "Not logged in.";
}

?>

<html>
<head>
	<title>cellchess.com</title>
</head>
<body>
	<?php echo $header ?><br>
	Play:<br>
	<form action="/play.php" method="post">
		<input type="text" id="opselect" name="specified"><br>
		<input type="submit" value="Play"><br>
	</form>

	Register:<br>
	<form action="/register.php" method="post">
		<input type="text" id="login" name="uname"><br>
		<input type="text" id="login" name="pword"><br>
		<input type="submit" value="Register"><br>
	</form>

	Login:<br>
	<form action="/login.php" method="post">
		<input type="text" id="login" name="uname"><br>
		<input type="text" id="login" name="pword"><br>
		<input type="submit" value="Login"><br>
	</form>

	Logout:<br>
	<form action="/logout.php" method="post">
		<input type="submit" value="Logout"><br>
	</form>
</body>
</html>