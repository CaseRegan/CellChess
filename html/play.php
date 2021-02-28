<?php

session_start();
include("api_funcs.php");

if (!isset($_SESSION["uname"])) {
	echo "Not logged in.";
	exit();
}

$gid = -1;
$need_refresh = 0;

if ($_GET["gid"]) {
	$gid = $_GET["gid"];
} 

if ($gid < 0) {
	$gid = getUser($_SESSION["uname"])->curgame;
	$need_refresh = 1;
}

if ($gid < 0) {
	$gid = createGame(8, $_SESSION["uname"], 'NONE')->gid;
	$need_refresh = 1;
}

?>

<html>
<head>
	<title>Play Cellchess</title>
	<script type="text/javascript" src="board.js"></script>
	<?php

	if ($need_refresh) {
		echo "<script>window.location.href = \"play.php?gid=$gid\"</script>";
	}

	?>
</head>
<body>
	<canvas id="mainBoard" width="800" height="800" data-gameid=<?php echo $gid; ?>></canvas>
	<script>
		var board = document.getElementById("mainBoard");
		redraw();

		board.addEventListener("mousedown", boardOnClick);
	</script>
	<br>
	<button onclick="window.location.href='/index.php'">Home</button>
	<button onclick="killGame()">End Game</button>
</body>
</html>