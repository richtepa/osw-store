<?php

session_start();

$uid = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '',$_SESSION["uid"]));
if(empty($uid)){
    header("Location: /?loginNeeded");
	exit();
}

if(!isset($_POST["submit"]) || empty($_POST["title"]) || empty($_FILES["screenshot"]["name"]) || empty($_FILES["code"]["name"])){
    header("Location: /?fieldEmpty");
	exit();
}
$title = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '', $_POST["title"]));
if(empty($_POST["description"])){
    $description = "";
} else {
    $description = htmlspecialchars($_POST["description"], ENT_QUOTES, 'UTF-8');
}

require "../../backend/db.php";

$sql = $conn->prepare("SELECT * FROM watchface WHERE uid=:uid AND title=:title");
$sql->bindValue(":uid", $uid, PDO::PARAM_STR);
$sql->bindValue(":title", $title, PDO::PARAM_STR);
$sql->execute();

if($sql->rowCount() > 0){
	header("Location: /?titleExists");
	exit();
}

// File upload path
$targetDir = "../uploads/";
$fileName = uniqid() . "-" . time();

$screenshotExtension = pathinfo($_FILES["screenshot"]["name"], PATHINFO_EXTENSION);
$screenshotLocation = $targetDir . $fileName . "." . $screenshotExtension;

$codeExtension = pathinfo($_FILES["code"]["name"], PATHINFO_EXTENSION);
$codeLocation = $targetDir . $fileName . "." . $codeExtension;

$allowTypes = array('jpg','png','jpeg');
if(!in_array($screenshotExtension, $allowTypes) || $codeExtension != "cpp"){
    header("Location: /?wrongFiletype");
	exit();
}

if(move_uploaded_file($_FILES["screenshot"]["tmp_name"], $screenshotLocation) && move_uploaded_file($_FILES["code"]["tmp_name"], $codeLocation)){
    $sql = $conn->prepare("INSERT into watchface (`id`, `image`, `code`, `title`, `description`, `uid`, `uploaded`, `votes`) VALUES (NULL, :s, :c, :title, :description, :uid, NOW(), 0)");
    $sql->bindValue(":s", $fileName.".".$screenshotExtension, PDO::PARAM_STR);
    $sql->bindValue(":c", $fileName.".".$codeExtension, PDO::PARAM_STR);
    $sql->bindValue(":title", $title, PDO::PARAM_STR);
    $sql->bindValue(":description", $description, PDO::PARAM_STR);
    $sql->bindValue(":uid", $uid, PDO::PARAM_STR);
    if($sql->execute()){
        header("Location: /watchface/edit/$uid/$title");
        exit();
    } else {
        header("Location: /?error");
        exit();
    } 
} else {
    header("Location: /?error");
    exit();
}
