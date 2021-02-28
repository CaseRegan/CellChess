<?php

session_start();

session_destroy();

header("Location: http://proj.cellchess.com");
exit();

?>