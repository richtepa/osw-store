<?php
session_start();

if(empty($_POST["uid"]) || empty($_POST["email"]) || empty($_POST["pwd"]) || empty($_POST["pwd2"])){
    header("Location: /?emptyField");
    exit();
}

if($_POST["pwd"] != $_POST["pwd2"]){
    header("Location: /?pwdNotMatch");
    exit();
}

$email = $_POST["email"];
if(!checkMail($email)){
    header("Location: /?incorrectMail&mail=$uid");
    exit();
}

require "../backend/db.php";

$uid = strtolower($_POST["uid"]);
$pwd = password_hash($_POST["pwd"], PASSWORD_DEFAULT);

$sql = "SELECT * FROM user WHERE email='$email'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
if($num_rows > 0){
    if($row = mysqli_fetch_assoc($result)){
        if(password_verify($_POST["pwd"], $row["pwd"])){
            if($row["verify"] == ""){
                $_SESSION["uid"] = $row["uid"];
                header("Location: /");
                exit();
            } else {
                $_SESSION["uid"] =  $row["uid"];
                header("Location: /?verifyMail");
                exit();
            }
        } else {
            header("Location: /?emailExists");
            exit();
        }
    }
}

$sql = "SELECT * FROM user WHERE uid='$uid'";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
if($num_rows > 0){
    if($row = mysqli_fetch_assoc($result)){
        if(password_verify($_POST["pwd"], $row["pwd"])){
            if($row["verify"] == ""){
                $_SESSION["uid"] =  $row["uid"];
                header("Location: /");
                exit();
            } else {
                $_SESSION["uid"] =  $row["uid"];
                header("Location: /?verifyMail");
                exit();
            }
        } else {
            header("Location: /?usernameExists");
            exit();
        }
    }
}


$verify = generateRandomString(16);
$sql = "INSERT INTO `user` (`id`, `uid`, `email`, `pwd`, `verify`, `voted`) VALUES (NULL, '$uid', '$email', '$pwd', 'register-$verify', '[]');";
$conn->query($sql);

$link = "https://" . $config["domain"] . "/verify?email=$email&code=$verify";
$subject = "Registration at ${config['domain']}";
$message = "Your verification link: <a href='$link'>$link</a>";

$headers[] = 'MIME-Version: 1.0';
$headers[] = 'Content-type: text/html; charset=iso-8859-1';
$headers[] = "From: ${config['name']} <no-reply@${config['domain']}>";

$success = mail($email, $subject, $message, implode("\r\n", $headers));
if (!$success) {
    $errorMessage = error_get_last()['message'];
}

//echo $sql;

$_SESSION["uid"] = $uid;
header("Location: /?ok");

exit();



function checkMail(){
    /*
    $field = filter_var($field, FILTER_SANITIZE_EMAIL);
    return filter_var($field, FILTER_VALIDATE_EMAIL);
    */
    return true;
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