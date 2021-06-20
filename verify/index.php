<?php

require "../backend/db.php";

if(empty($_GET["email"]) || empty($_GET["code"])){
    header("Location: /?emptyField");
    exit();
}

$email = $_GET["email"];
$code = $_GET["code"];

$sql = $conn->prepare("SELECT * FROM user WHERE email=:email");
$sql->bindValue(":email", $email, PDO::PARAM_STR);
$sql->execute();

if($sql->rowCount() > 0){
    if($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $type = explode("-", $row["verify"])[0];
        $v = explode("-", $row["verify"])[1];
        if($v == $code){
            if($type == "register"){
                $sql = $conn->prepare("UPDATE `user` SET `verify` = '' WHERE `email` = :email;");
                $sql->bindValue(":email", $email, PDO::PARAM_STR);
                $sql->execute();
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
                $sql = $conn->prepare("UPDATE `user` SET `verify` = '' WHERE `email` = :email;");
                $sql->bindValue(":email", $email, PDO::PARAM_STR);
                $sql->execute();
                $sql = $conn->prepare("UPDATE `user` SET `pwd` = :pwd WHERE `email` = :email;");
                $sql->bindValue(":pwd", $pwd, PDO::PARAM_STR);
                $sql->bindValue(":email", $email, PDO::PARAM_STR);
                $sql->execute();
                header("Location: /?ok");
                exit();
            }
        }
    }
}

header("Location: /?wrongCode");
exit();