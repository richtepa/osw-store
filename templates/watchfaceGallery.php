<div class="gallery">
<?php
    
if(empty($uid)){
    $voted = [];
} else {
    $sql = "SELECT * FROM user WHERE uid='$uid'";
    $result = mysqli_query($conn, $sql);
    $num_rows = mysqli_num_rows($result);
    if($row = mysqli_fetch_assoc($result)){
        $voted = json_decode($row["voted"], true);
    }   
}
    
$result = mysqli_query($conn, $galleryElements);
while($row = mysqli_fetch_assoc($result)) {
    $v = in_array($row["uid"]."/".$row["title"], $voted);
    addTile($row["uid"], $row["title"], $row["image"], $row["votes"], $v);
}

?>
<?php function addTile($uid, $title, $image, $votes, $v){ ?>
    <a href="/watchface/show/<?php echo $uid."/".$title; ?>">
        <div class="galleryBox">
            <div class="galleryImage" style="background-image: url(/watchface/uploads/<?php echo $image; ?>);"></div>
            <div class="gallerySubtitle">
                <?php echo $title; ?> by <?php echo $uid; ?> - 
                <?php echo $votes; if($v){?> 
                    &#9829; 
                <?php } else { ?>
                    &#9825;
                <?php } ?>
            </div>
        </div>
    </a>
<?php } ?>
</div>