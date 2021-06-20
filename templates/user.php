<style>
    .gallery{
        grid-template-rows: 1fr;
        grid-template-columns: repeat(100, 20vw);
    }
</style>

<div class="content">
    <h1><?php echo $username; ?></h1>
    <h2>Watchfaces</h2>
    <?php
    $galleryElements = $conn->prepare("SELECT * FROM watchface WHERE uid=:username ORDER BY `votes` DESC");
    $galleryElements->bindValue(":username", $username, PDO::PARAM_STR);
    $galleryElements->execute();
    require "watchfaceGallery.php";
    ?>
</div>