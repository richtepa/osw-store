<?php

require "config.php";

function connectDB(){
	global $conn, $config;
    
    
    /*
	$conn = new mysqli($config["db"]["domain"], $config["db"]["user"], $config["db"]["pass"]);
	if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
	}
	mysqli_select_db($conn, $config["db"]["name"]);
    */
    
    $domain = $config["db"]["domain"];
    $db = $config["db"]["name"];
    $u = $config["db"]["user"];
    $pass = $config["db"]["pass"];
    
    $conn = new PDO("mysql:host=$domain;dbname=$db", $u, $pass);
    $conn -> query ('SET NAMES utf8');
    //$conn -> query ('SET CHARACTER_SET utf8_general_ci');
    $conn -> setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    
}
connectDB();
