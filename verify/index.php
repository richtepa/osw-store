<?php

require "../backend/db.php";

if(empty($_GET["email"]) || empty($_GET["code"])){
    header("Location: /?emptyField");
    exit();
}

$email = $_GET["email"];
$code = $_GET["code"];

$sql = "SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
if($num_rows > 0){
    if($row = mysqli_fetch_assoc($result)){
        $type = explode("-", $row["verify"])[0];
        $v = explode("-", $row["verify"])[1];
        if($v == $code){
            if($type == "register"){
                $sql = "UPDATE `user` SET `verify` = '' WHERE `email` = '$email';";
                mysqli_query($conn, $sql);
                header("Location: /?ok");
                exit();
            } else if($type == "passwordReset"){
                if(empty($_POST["pwd"]) || empty($_POST["pwd2"])){
                    require "../templates/resetPwd.php";
                    exit();
                }
                if($_POST["pwd"] != $_POST["pwd2"]){
                    header("Location: /?pwdNotMatch");
                    exit();
                }
                $pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);
                $sql = "UPDATE `user` SET `verify` = '' WHERE `email` = '$email';";
                mysqli_query($conn, $sql);
                $sql = "UPDATE `user` SET `pwd` = '$pwd' WHERE `email` = '$email';";
                mysqli_query($conn, $sql);
                header("Location: /?ok");
                exit();
            }
        }
    }
}

header("Location: /?wrongCode");
exit();