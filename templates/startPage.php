<div class="content">
    <h1>All Watchfaces</h1>


<?php
$limit = 20;
if(empty($_GET["page"])){
    $page = 1;
} else {
    $page = $_GET["page"];
}
$start = ($page-1)*$limit;
$galleryElements = $conn->prepare("SELECT * FROM watchface ORDER BY `votes` DESC LIMIT :start, :limit");
$galleryElements->bindValue(":start", $start, PDO::PARAM_INT);
$galleryElements->bindValue(":limit", $limit, PDO::PARAM_INT);
$galleryElements->execute();
require "watchfaceGallery.php";
$sql = $conn->prepare($sql = "SELECT id FROM watchface");
$sql->execute();
$num_rows = $sql->rowCount();
$maxPage = ceil($num_rows / $limit);
?>
<div class="paginator">
    <?php if($page > 2){ ?>
    <a href="/" class="invisibleLink"><span class="page">1</span></a>
    <span>...</span>
    <?php } if($page > 1){ ?>
    <a href="/?page=<?php echo $page-1; ?>" class="invisibleLink"><span class="page"><?php echo $page-1; ?></span></a>
    <?php } ?>
    <span class="page"><?php echo $page; ?></span>
    <?php if($page < $maxPage){ ?>
    <a href="/?page=<?php echo $page+1; ?>" class="invisibleLink"><span class="page"><?php echo $page+1; ?></span></a>
    <?php } if($page < $maxPage - 1){ ?>
    <span>...</span>
    <a href="/?page=<?php echo $maxPage; ?>" class="invisibleLink"><span class="page"><?php echo $maxPage; ?></span></a>
    <?php } ?>
</div>
</div>
