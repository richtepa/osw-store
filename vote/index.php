<?php

session_start();

$uid = $_SESSION["uid"];
if(empty($uid)){
    header("Location: /?loginNeeded");
	exit();
}

if(empty($_GET["uid"]) || empty($_GET["title"])){
    header("Location: /?fieldEmpty");
	exit();
}

$title = $_GET["title"];
$user = $_GET["uid"];

require "../backend/db.php";


$sql = "SELECT * FROM user WHERE uid='$uid'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
if($num_rows < 1){
    header("Location: /?noUser");
	exit();
} else {
    if($row = mysqli_fetch_assoc($result)){
        $voted = json_decode($row["voted"], true);
        $index = array_search($user."/".$title, $voted);        
        if($index > -1){
            $sql = "UPDATE `watchface` SET `votes` = `votes` - 1 WHERE `title` = '$title' AND `uid` = '$user'";
            $update = $conn->query($sql);
            unset($voted[$index]);
        } else {
            $sql = "UPDATE `watchface` SET `votes` = `votes` + 1 WHERE `title` = '$title' AND `uid` = '$user'";
            $update = $conn->query($sql);
            array_push($voted, $user."/".$title);
        }
        $json = json_encode($voted);
        $sql = "UPDATE `user` SET `voted` = '$json' WHERE uid='$uid'";
        $update = $conn->query($sql);
    }
}

header("Location: /watchface/show/$user/$title");
exit();
