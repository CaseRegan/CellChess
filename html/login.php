<?php

session_start();

if(empty($_POST) || 
	!isset($_POST["uname"]) || 
	!isset($_POST["pword"])) {
 	echo "You shouldn't be here...";
 	exit();
}

$uname = $_POST["uname"];
$pwhash = md5($_POST["pword"]);

$servername = "localhost";
$username = "cellchess";
$password = "password";
$dbname = "cellchess";
// Don't actually include a plaintext password here obviously

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
	die("Connection failed: ". mysqli_connect_error());
}

$sql = "SELECT * FROM users WHERE username='$uname' AND pwhash='$pwhash'";
$result = mysqli_query($conn, $sql);

$row = mysqli_fetch_assoc($result);
mysqli_close($conn);

if ($row) {
	echo "Logged in as " . $row["username"] . ".<br>";
	$_SESSION["uname"] = $uname;
	header("Location: index.php");
	exit();
} else {
	echo "Error or no results.";
}

?>