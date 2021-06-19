<?php

session_start();
$uid = $_SESSION["uid"];
$username = explode("/", $_GET["path"])[0];


require "../templates/header.php";


require "../backend/db.php";
$sql = "SELECT * FROM user WHERE uid='$username'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);

//no User
if($num_rows < 1){
	require "../templates/noUser.php";
} else {
    if($row = mysqli_fetch_assoc($result)){
	   require "../templates/user.php";
    }
}


require "../templates/footer.php";