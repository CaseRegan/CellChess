<?php

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

$sql = "SELECT * FROM users WHERE username='$uname'";

if ($result=mysqli_query($conn, $sql)) {
	if (mysqli_num_rows($result) > 0) {
		echo "Error: exists (remove 'exists' in final version).";
		exit();
	}
}

$sql = "INSERT INTO users (username, pwhash) VALUES ('$uname', '$pwhash')";

if (mysqli_query($conn, $sql)) {
	echo "New record created successfully!";
} else {
	echo "Error creating record.";
}

mysqli_close($conn);

?>