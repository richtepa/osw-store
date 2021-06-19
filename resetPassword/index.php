<?php

require "../backend/db.php";

if(empty($_POST["email"])){
    header("Location: /?emptyField");
    exit();
}

$email = $_POST["email"];

$sql = "SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
if($num_rows > 0){
    if($row = mysqli_fetch_assoc($result)){
        
        $v = explode("-", $row["verify"])[0];
        if($v == "register"){
            header("Location: /?bad");
            exit();
        } else {
            $verify = generateRandomString(16);
            $sql = "UPDATE `user` SET `verify` = 'passwordReset-$verify' WHERE `email` = '$email';";
            mysqli_query($conn, $sql);
            
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