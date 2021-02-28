<?php

include("api_funcs.php");

// ##########################
// Initial request processing
// ##########################
$request = json_decode(file_get_contents("php://input"), true);

// Ensure the request is valid and die if it isn't
if (!$request || !array_key_exists("command", $request)) {
	messageDeath("no command specified");
}

// ###############
// Command handler
// ###############
switch ($request["command"]) {
	case "get_game":
		assertKeys($request, "gid");
		$response = getGame($request["gid"]);
		break;

	case "get_user":
		assertKeys($request, "uname");
		$response = getUser($request["uname"]);
		break;

	case "make_move":
		assertKeys($request, "gid", "x", "y", "player");
		$response = makeMove($request["gid"], $request["x"], $request["y"], $request["player"]);
		break;

	case "create_game":
		assertKeys($request, "size", "player1", "player2");
		$response = createGame($request["size"], $request["player1"], $request["player2"]);
		break;

	case "end_game":
		assertKeys($request, "gid");
		$response = endGame($request["gid"]);
		break;

	default:
		messageDeath("null or unrecognized command");
}

// #########################################
// This is the result the client sees 
// ($response is set in the command handler)
// #########################################
echo json_encode($response);

// ##########################################
// Cleanup (end of procedural execution, 
// everything below is a function definition)
// ##########################################
mysqli_close($conn);

// #################
// Utility functions
// #################

// Verify that every key the command expects is
// available in the request and die if not
function assertKeys($array, ...$keys) {
	foreach($keys as $key) {
		if (!array_key_exists($key, $array))
			messageDeath("param not specified ($key)");
	}
}

// Die with a JSON-encoded message (usually and 
// by default an error, but occasionally a "Success" 
// message for a command with no output)
function messageDeath($message, $prefix="ERROR") {
	$message->message = "$prefix: $message";
	die(json_encode($message));
}

?>