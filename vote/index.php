<?php

session_start();

$uid = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '',$_SESSION["uid"]));
if(empty($uid)){
    //header("Location: /?loginNeeded");
    echo 0;
	exit();
}

if(empty($_GET["uid"]) || empty($_GET["title"])){
    //header("Location: /?fieldEmpty");
    echo 0;
	exit();
}

$title = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $_GET["title"]));
$user = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '',$_GET["uid"]));

require "../backend/db.php";


$sql = $conn->prepare("SELECT * FROM user WHERE uid=:uid");
$sql->bindValue(":uid", $uid, PDO::PARAM_STR);
$sql->execute();

//no User
if($sql->rowCount() < 1){
    //header("Location: /?noUser");
    echo 0;
	exit();
} else {
    if($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $voted = json_decode($row["voted"], true);
        $index = array_search($user."/".$title, $voted);        
        if($index > -1){
            $sql = $conn->prepare("UPDATE `watchface` SET `votes` = `votes` - 1 WHERE `title` = :title AND `uid` = :user");
            $sql->bindValue(":title", $title, PDO::PARAM_STR);
            $sql->bindValue(":user", $user, PDO::PARAM_STR);
            $sql->execute();
            unset($voted[$index]);
        } else {
            $sql = $conn->prepare("UPDATE `watchface` SET `votes` = `votes` + 1 WHERE `title` = :title AND `uid` = :user");
            $sql->bindValue(":title", $title, PDO::PARAM_STR);
            $sql->bindValue(":user", $user, PDO::PARAM_STR);
            $sql->execute();
            array_push($voted, $user."/".$title);
        }
        $json = json_encode($voted);
        $sql = $conn->prepare("UPDATE `user` SET `voted` = :json WHERE uid=:uid");
        $sql->bindValue(":json", $json, PDO::PARAM_STR);
        $sql->bindValue(":uid", $uid, PDO::PARAM_STR);
        $sql->execute();
    }
}

//header("Location: /watchface/show/$user/$title");
echo 1;
exit();
