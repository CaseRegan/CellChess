<?php

// ######################
// Initial database setup
// ######################
$servername = "localhost";
$username = "cellchess";
$password = "password";
$dbname = "cellchess";

$conn = mysqli_connect($servername, $username, $password, $dbname);

if (!$conn) {
	die("failed to connect to database");
}

// #############
// API Functions
// #############

function getGame($gid) {
	global $conn;
	$sql = "SELECT * FROM games WHERE id=$gid";
	$result = mysqli_query($conn, $sql);

	if (!$result || mysqli_num_rows($result) == 0) {
		return;
	}

	$row = mysqli_fetch_assoc($result);
	$game->id = $gid;
	$game->turn = intval($row["turn"]);
	$game->size = intval($row["size"]);
	$game->board = json_decode($row["board"]);
	return $game;
}

function getUser($uname) {
	global $conn;
	$sql = "SELECT * FROM users WHERE username='$uname'";

	$result = mysqli_query($conn, $sql);

	if (!$result || mysqli_num_rows($result) == 0) {
		return;
	}

	$row = mysqli_fetch_assoc($result);
	$user->id = intval($row["id"]);
	$user->uname = $uname;
	if ($row["curgame"] === null)
		$user->curgame = -1;
	else
		$user->curgame = intval($row["curgame"]);
	return $user;
}

function createGame($size, $p1, $p2) {
	global $conn;
	$sql = "SELECT id FROM games ORDER BY id DESC LIMIT 1";
	$result = mysqli_query($conn, $sql);

	if (!$result) {
		return;
	}

	$row = mysqli_fetch_assoc($result);
	$gid = intval($row["id"]) + 1;

	$board = array();
	for ($i = 0; $i < $size; $i++) {
		$board[] = array_fill(0, $size, 0);
	}
	$boardJSON = json_encode($board);

	$sql = "INSERT INTO games ";
	$sql .= "(id, turn, size, board, player1, player2) VALUES ";
	$sql .= "($gid, 1, $size, '$boardJSON', '$p1', '$p2')";
	if (!mysqli_query($conn, $sql)) {
		return;
	}

	$sql = "UPDATE users SET curgame=$gid WHERE username='$p1'";
	if (!mysqli_query($conn, $sql)) {
		return;
	}

	$res->gid = $gid;
	return $res;
}

function endGame($gid) {
	global $conn;
	$sql = "DELETE FROM games WHERE id=$gid";
	if (!mysqli_query($conn, $sql)) {
		// Normally this would return like any other function, but
		// since I'm not entirely sure how game deletion will work
		// yet, I'm leaving this like so for flexibility.
		//return;
	}

	$sql = "UPDATE users SET curgame=-1 WHERE curgame=$gid";
	if (!mysqli_query($conn, $sql)) {
		return;
	}

	$res->gid = -1;
	return $res;
}

function makeMove($gid, $x, $y, $player) {
	global $conn;
	$sql = "SELECT * FROM games WHERE id=$gid";
	$result = mysqli_query($conn, $sql);
	$row = mysqli_fetch_assoc($result);

	// Game logic needs to be implemented here
	$board = json_decode($row["board"]);
	$board[$x][$y] = $player;
	$board = json_encode($board);

	if ($player == 1)
		$player = 2;
	else if ($player == 2)
		$player = 1;
	else
		$player = 0;

	$sql = "UPDATE games SET ";
	$sql .= "turn=$player, board='$board'";
	$sql .= "WHERE id=$gid";

	$res->id = $gid;
	$res->x = $x;
	$res->y = $y;
	$res->player = $player;

	if (mysqli_query($conn, $sql)) {
		$res->code = 1;
	} else {
		$res->code = 0;
	}

	return $res;
}

?>