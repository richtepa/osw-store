<?php

session_start();
$path = explode("/", $_GET["path"]);
$username = strtolower($path[0]);
$title = strtolower($path[1]);

if($_SESSION["uid"] != $username){
    header("Location: /?noPermission");
	exit();
}

require "../../templates/header.php";


require "../../backend/db.php";
$sql = "SELECT * FROM watchface WHERE uid='$username' AND title='$title'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);

if($num_rows < 1){
	require "../../templates/noWatchface.php";
} else {
    if($row = mysqli_fetch_assoc($result)){
	   require "../../templates/editWatchface.php";
    }
}


require "../../templates/footer.php";