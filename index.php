<?php

session_start();
$uid = $_SESSION["uid"];

require "backend/db.php";

require "templates/header.php";
require "templates/startPage.php";
require "templates/footer.php";