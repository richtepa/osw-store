<?php

session_start();

$uid = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '',$_SESSION["uid"]));
if(empty($uid)){
    header("Location: /?loginNeeded");
	exit();
}

if(!isset($_POST["submit"]) || empty($_POST["title"])){
    header("Location: /?fieldEmpty");
	exit();
}
$title = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '',$_POST["title"]));

require "../../backend/db.php";

$sql = $conn->prepare("SELECT * FROM watchface WHERE uid=:uid AND title=:title");
$sql->bindValue(":uid", $uid, PDO::PARAM_STR);
$sql->bindValue(":title", $title, PDO::PARAM_STR);
$sql->execute();
if($sql->rowCount() < 1){
	header("Location: /?notFound");
	exit();
}
$row = $sql->fetch(PDO::FETCH_ASSOC);
if($row["uid"] != $uid){
    header("Location: /?noPermission");
	exit();
}



$targetDir = "../uploads/";
$fileName = uniqid() . "-" . time();


if(!empty($_FILES["screenshot"]["name"])){
    $screenshotExtension = pathinfo($_FILES["screenshot"]["name"], PATHINFO_EXTENSION);
    $allowTypes = array('jpg','png','jpeg');
    if(!in_array($screenshotExtension, $allowTypes)){
        header("Location: /?wrongFiletype");
        exit();
    }
}
if(!empty($_FILES["code"]["name"])){
    $codeExtension = pathinfo($_FILES["code"]["name"], PATHINFO_EXTENSION);
    if($codeExtension != "cpp"){
        header("Location: /?wrongFiletype");
        exit();
    }
}
if(!empty($_FILES["header"]["name"])){
    $headerExtension = pathinfo($_FILES["header"]["name"], PATHINFO_EXTENSION);
    if($headerExtension != "h"){
        header("Location: /?wrongFiletype");
        exit();
    }
}


if(!empty($_FILES["screenshot"]["name"])){
    $screenshotLocation = $targetDir . $fileName . "." . $screenshotExtension;
    if(move_uploaded_file($_FILES["screenshot"]["tmp_name"], $screenshotLocation)){
        $sql = $conn->prepare("UPDATE `watchface` SET `image` = :f WHERE `title` = :title AND `uid` = :uid");
        $sql->bindValue(":f", $fileName.".".$screenshotExtension, PDO::PARAM_STR);
        $sql->bindValue(":uid", $uid, PDO::PARAM_STR);
        $sql->bindValue(":title", $title, PDO::PARAM_STR);
        $sql->execute();
        unlink($targetDir . $row["image"]);
    }
}
if(!empty($_FILES["code"]["name"])){
    $codeLocation = $targetDir . $fileName . "." . $codeExtension;
    if(move_uploaded_file($_FILES["code"]["tmp_name"], $codeLocation)){
        $sql = $conn->prepare("UPDATE `watchface` SET `code` = :f WHERE `title` = :title AND `uid` = :uid");
        $sql->bindValue(":f", $fileName.".".$codeExtension, PDO::PARAM_STR);
        $sql->bindValue(":uid", $uid, PDO::PARAM_STR);
        $sql->bindValue(":title", $title, PDO::PARAM_STR);
        $sql->execute();
        unlink($targetDir . $row["code"]);
    }
}
if(!empty($_FILES["header"]["name"])){
    $headerLocation = $targetDir . $fileName . "." . $headerExtension;
    if(move_uploaded_file($_FILES["header"]["tmp_name"], $headerLocation)){
        $sql = $conn->prepare("UPDATE `watchface` SET `header` = :f WHERE `title` = :title AND `uid` = :uid");
        $sql->bindValue(":f", $fileName.".".$headerExtension, PDO::PARAM_STR);
        $sql->bindValue(":uid", $uid, PDO::PARAM_STR);
        $sql->bindValue(":title", $title, PDO::PARAM_STR);
        $sql->execute();
        unlink($targetDir . $row["header"]);
    }
}
if(!empty($_POST["description"])){
    $description = htmlspecialchars($_POST["description"], ENT_QUOTES, 'UTF-8');
    $sql = $conn->prepare("UPDATE `watchface` SET `description` = :description WHERE `title` = :title AND `uid` = :uid");
    $sql->bindValue(":description", $description, PDO::PARAM_STR);
    $sql->bindValue(":uid", $uid, PDO::PARAM_STR);
    $sql->bindValue(":title", $title, PDO::PARAM_STR);
    $sql->execute();
}

header("Location: /watchface/edit/$uid/$title?success");
exit();