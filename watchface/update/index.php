<?php

session_start();

$uid = $_SESSION["uid"];
if(empty($uid)){
    header("Location: /?loginNeeded");
	exit();
}

if(!isset($_POST["submit"]) || empty($_POST["title"])){
    header("Location: /?fieldEmpty");
	exit();
}
$title = $_POST["title"];

require "../../backend/db.php";

$sql = "SELECT * FROM watchface WHERE uid='$uid' AND title='$title'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
if($num_rows < 1){
	header("Location: /?notFound");
	exit();
}
$row = mysqli_fetch_assoc($result);
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


if(!empty($_FILES["screenshot"]["name"])){
    $screenshotLocation = $targetDir . $fileName . "." . $screenshotExtension;
    if(move_uploaded_file($_FILES["screenshot"]["tmp_name"], $screenshotLocation)){
        $sql = "UPDATE `watchface` SET `image` = '$fileName.$screenshotExtension' WHERE `title` = '$title' AND `uid` = '$uid'";
        $update = $conn->query($sql);
        unlink($targetDir . $row["image"]);
    }
}
if(!empty($_FILES["code"]["name"])){
    $codeLocation = $targetDir . $fileName . "." . $codeExtension;
    if(move_uploaded_file($_FILES["code"]["tmp_name"], $codeLocation)){
        $sql = "UPDATE `watchface` SET `code` = '$fileName.$codeExtension' WHERE `title` = '$title' AND `uid` = '$uid'";
        $update = $conn->query($sql);
        unlink($targetDir . $row["code"]);
    }
}
if(!empty($_POST["description"])){
    $description = $_POST["description"];
    $sql = "UPDATE `watchface` SET `description` = '$description' WHERE `title` = '$title' AND `uid` = '$uid'";
    $update = $conn->query($sql);
}

header("Location: /watchface/edit/$uid/$title?success");
exit();