<?php

require "config.php";

function connectDB(){
	global $conn, $config;
	$conn = new mysqli($config["db"]["domain"], $config["db"]["user"], $config["db"]["pass"]);
	if ($conn->connect_error) {
			die("Connection failed: " . $conn->connect_error);
	}
	mysqli_select_db($conn, $config["db"]["name"]);
}
connectDB();
