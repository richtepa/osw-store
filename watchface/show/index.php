<?php

session_start();
$uid = $_SESSION["uid"];

$path = explode("/", $_GET["path"]);
$username = strtolower($path[0]);
$title = strtolower($path[1]);


require "../../templates/header.php";


require "../../backend/db.php";
$sql = "SELECT * FROM user WHERE uid='$uid'";
$result = mysqli_query($conn, $sql);
if($row = mysqli_fetch_assoc($result)){
   $voted = in_array($username."/".$title, json_decode($row["voted"], true));
}

$sql = "SELECT * FROM watchface WHERE uid='$username' AND title='$title'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);

//no User
if($num_rows < 1){
	require "../../templates/noWatchface.php";
} else {
    if($row = mysqli_fetch_assoc($result)){
	   require "../../templates/watchface.php";
    }
}


require "../../templates/footer.php";