function drawBoard(data) {
	var board = document.getElementById("mainBoard");
	var gid = board.getAttribute("data-gameid");
	var ctx = board.getContext("2d");

	if (!data) {
		ctx.globalAlpha = 0.5;
		ctx.fillRect(0, 0, board.width, board.height);
		return;
	}

	var boardSize = Math.min(board.width, board.height);
	var numCells = data.size;
	var cellSize = boardSize / numCells;

	for (var x = 0; x < numCells; x++) {
		for (var y = 0; y < numCells; y++) {
			if (data.board[x][y] == 0) {
				if (x % 2 == y % 2)
					ctx.fillStyle = "#d9d9d9";
				else
					ctx.fillStyle = "#bfbfbf";
			}
			else if (data.board[x][y] == 1) {
				ctx.fillStyle = "#FF0000";
			}
			else if (data.board[x][y] == 2) {
				ctx.fillStyle = "#0000FF";
			}
			else {
				ctx.fillStyle = "#000000";
			}

			ctx.fillRect(cellSize*x, cellSize*y, cellSize, cellSize);
		}
	}
}

function redraw() {
	var board = document.getElementById("mainBoard");
	var gid = board.getAttribute("data-gameid");
	var req = {
		command: "get_game",
		gid: gid
	};

	apiRequest(req, drawBoard);
}

function killGame() {
	var board = document.getElementById("mainBoard");
	var gid = board.getAttribute("data-gameid");
	board.setAttribute("data-gameid", -1);
	board.removeAttribute("onclick");
	var req = {
		command: "end_game",
		gid: gid
	};

	apiRequest(req, redraw);
}

function boardOnClick(event) {
	var board = document.getElementById("mainBoard");
	var gid = board.getAttribute("data-gameid");
	var rect = board.getBoundingClientRect();

	var boardSize = Math.min(board.width, board.height);
	var numCells = 8;
	var cellSize = boardSize / numCells;

	var x = Math.floor((event.clientX - rect.left) / cellSize);
	var y = Math.floor((event.clientY - rect.top) / cellSize);

	var req = {
		command: "make_move",
		gid: gid,
		x: x,
		y: y,
		player: 1
	};

	apiRequest(req, redraw);
}

function apiRequest(data, callback) {
	var xhttp = new XMLHttpRequest();
	xhttp.open("POST", "api_js.php", true);
	xhttp.setRequestHeader("Content-Type", "application/json");
	xhttp.onreadystatechange = function() {
		if (this.readyState == 4 && this.status == 200) {
			var response = JSON.parse(this.responseText);
			if (callback) {
				callback(response);
			}
		}
	}
	xhttp.send(JSON.stringify(data));
}