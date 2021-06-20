<?php

session_start();
$uid = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '',$_SESSION["uid"]));
$username = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '',explode("/", $_GET["path"])[0]));


require "../templates/header.php";


require "../backend/db.php";


$sql = $conn->prepare("SELECT * FROM user WHERE uid=:username");
$sql->bindValue(":username", $username, PDO::PARAM_STR);
$sql->execute();

//no User
if($sql->rowCount() < 1){
	header("Location: /?noUser");
    exit();
} else {
    if($row = $sql->fetch(PDO::FETCH_ASSOC)){
	   require "../templates/user.php";
    }
}


require "../templates/footer.php";