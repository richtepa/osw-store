<h1><?php echo $username; ?></h1>
<h2>Watchfaces</h2>
<?php
$galleryElements = "SELECT * FROM watchface WHERE uid='$username' ORDER BY `votes` DESC";
require "watchfaceGallery.php";
?>