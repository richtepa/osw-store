<?php

require "../backend/db.php";

if(empty($_POST["email"])){
    header("Location: /?emptyField");
    exit();
}

$email = $_POST["email"];

$sql = $conn->prepare("SELECT * FROM user WHERE email=:email");
$sql->bindValue(":email", $email, PDO::PARAM_STR);
$sql->execute();

if($sql->rowCount() > 0){
    if($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $v = explode("-", $row["verify"])[0];
        if($v == "register"){
            header("Location: /?bad");
            exit();
        } else {
            $verify = generateRandomString(16);
            
            $sql = $conn->prepare("UPDATE `user` SET `verify` = :verify WHERE `email` = :email;");
            $sql->bindValue(":verify", "passwordReset-".$verify, PDO::PARAM_STR);
            $sql->bindValue(":email", $email, PDO::PARAM_STR);
            $sql->execute();
            
            $link = "https://" . $config["domain"] . "/verify?email=$email&code=$verify";
            $subject = "Password reset at ${config['domain']}";
            $message = "Your password reset link: <a href='$link'>$link</a>";

            $headers[] = 'MIME-Version: 1.0';
            $headers[] = 'Content-type: text/html; charset=iso-8859-1';
            $headers[] = "From: ${config['name']} <no-reply@${config['domain']}>";

            $success = mail($email, $subject, $message, implode("\r\n", $headers));
            if (!$success) {
                $errorMessage = error_get_last()['message'];
            }
            
            header("Location: /?ok");
            exit();
        }
    }
}



function generateRandomString($length) {
    $characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
    $charactersLength = strlen($characters);
    $randomString = '';
    for ($i = 0; $i < $length; $i++) {
        $randomString .= $characters[rand(0, $charactersLength - 1)];
    }
    return $randomString;
}