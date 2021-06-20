<?php

session_start();
$uid = strtolower(preg_replace('/[^A-Za-z0-9\-]/', '',$_SESSION["uid"]));

require "backend/db.php";

require "templates/header.php";
require "templates/startPage.php";
require "templates/footer.php";