<?php

session_start();

$uid = $_SESSION["uid"];
if(empty($uid)){
    header("Location: /?loginNeeded");
	exit();
}

if(!isset($_POST["submit"]) || empty($_POST["title"]) || empty($_FILES["screenshot"]["name"]) || empty($_FILES["code"]["name"])){
    header("Location: /?fieldEmpty");
	exit();
}
$title = strtolower($_POST["title"]);
if(empty($_POST["description"])){
    $description = "";
} else {
    $description = $_POST["description"];
}

require "../../backend/db.php";

$sql = "SELECT * FROM watchface WHERE uid='$uid' AND title='$title'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
if($num_rows > 0){
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
    $sql = "INSERT into watchface (`id`, `image`, `code`, `title`, `description`, `uid`, `uploaded`, `votes`) VALUES (NULL, '$fileName.$screenshotExtension', '$fileName.$codeExtension', '$title', '$description', '$uid', NOW(), 0)";
    $insert = $conn->query($sql);
    if($insert){
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
