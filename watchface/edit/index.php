<?php

session_start();
$path = explode("/", $_GET["path"]);
$username = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '',$path[0]));
$title = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '',$path[1]));

if($_SESSION["uid"] != $username){
    header("Location: /?noPermission");
	exit();
}

require "../../templates/header.php";


require "../../backend/db.php";

$sql = $conn->prepare("SELECT * FROM watchface WHERE uid=:username AND title=:title");
$sql->bindValue(":username", $username, PDO::PARAM_STR);
$sql->bindValue(":title", $title, PDO::PARAM_STR);
$sql->execute();

if($sql->rowCount() < 1){
	require "../../templates/noWatchface.php";
} else {
    if($row = $sql->fetch(PDO::FETCH_ASSOC)){
	   require "../../templates/editWatchface.php";
    }
}


require "../../templates/footer.php";