<?php

session_start();
require "../backend/db.php";
$user = mysqli_real_escape_string($conn, strtolower($_POST["user"]));
$pwd = mysqli_real_escape_string($conn, $_POST["pwd"]);

//empty inputs
if(empty($user) || empty($pwd)){
    header("Location: /?empty");
	exit();
}

$sql = "SELECT * FROM user WHERE uid='$user' OR email='$user'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);

//no User
if($num_rows < 1){
	header("Location: /?noEntry");
	exit();
}

if($row = mysqli_fetch_assoc($result)){
    //echo password_hash($_POST["pwd"], PASSWORD_DEFAULT);
    
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
