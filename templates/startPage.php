<?php
$limit = 20;
if(empty($_GET["page"])){
    $page = 1;
} else {
    $page = $_GET["page"];
}
$start = ($page-1)*$limit;    


$galleryElements = "SELECT * FROM watchface ORDER BY `votes` DESC LIMIT $start, $limit";
require "watchfaceGallery.php";
    
$sql = "SELECT * FROM watchface";
$result = mysqli_query($conn, $sql);
$num_rows = mysqli_num_rows($result);
$maxPage = ceil($num_rows / $limit);
?>
<div class="paginator">
    Page: 
    <?php if($page > 2){ ?>
    <a href="/">1</a>
    <span>...</span>
    <?php } if($page > 1){ ?>
    <a href="/?page=<?php echo $page-1; ?>"><?php echo $page-1; ?></a>
    <?php } ?>
    <span><?php echo $page; ?></span>
    <?php if($page < $maxPage){ ?>
    <a href="/?page=<?php echo $page+1; ?>"><?php echo $page+1; ?></a>
    <?php } if($page < $maxPage - 1){ ?>
    <span>...</span>
    <a href="/?page=<?php echo $maxPage; ?>"><?php echo $maxPage; ?></a>
    <?php } ?>
</div>






<?php if(!empty($_SESSION["uid"])){ ?>
<hr>
<form action="/watchface/upload/" method="post" enctype="multipart/form-data">
    Upload Watchface:
    <table>
        <tr>
            <td>Name</td>
            <td><input name="title" type="text"></td>
        </tr>
        <tr>
            <td>Description</td>
            <td><input name="description" type="text"></td>
        </tr>
        <tr>
            <td>Screenshot</td>
            <td><input type="file" accept="'jpg','png','jpeg'" name="screenshot"></td>
        </tr>
        <tr>
            <td>Code</td>
            <td><input type="file" accept="text/x-c" name="code"></td>
        </tr>
    </table>
    <input type="submit" name="submit" value="Upload">
</form>
<?php } ?>
