<?php

session_start();
require "../backend/db.php";
$user = strtolower(preg_replace('/[^A-Za-z0-9\-\@\.]/', '',$_POST["user"]));
$pwd = $_POST["pwd"];

//empty inputs
if(empty($user) || empty($pwd)){
    header("Location: /?empty");
	exit();
}

$sql = $conn->prepare("SELECT * FROM user WHERE uid=:uid OR email=:email");
$sql->bindValue(":uid", $user, PDO::PARAM_STR);
$sql->bindValue(":email", $user, PDO::PARAM_STR);
$sql->execute();
//no User
if($sql->rowCount() < 1){
	header("Location: /?noEntry");
	exit();
}

if($row = $sql->fetch(PDO::FETCH_ASSOC)){    
	if(!password_verify($pwd, $row["pwd"])){
		header("Location: /?wrongPwd");
		exit();
	}
    if($row["verify"] != ""){
        $_SESSION["uid"] = $row["uid"];
        header("Location: /?verifyMail");
		exit();
    }
	$_SESSION["uid"] = $row["uid"];
	header("Location: /");
	exit();
}
