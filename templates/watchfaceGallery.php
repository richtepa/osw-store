<div class="gallery">
<?php
    
if(empty($uid)){
    $voted = [];
} else {
    $sql = $conn->prepare("SELECT * FROM user WHERE uid=:uid");
    $sql->bindValue(":uid", $uid, PDO::PARAM_STR);
    $sql->execute();
    if($row = $sql->fetch(PDO::FETCH_ASSOC)){
        $voted = json_decode($row["voted"], true);
    }   
}


while($row = $galleryElements->fetch(PDO::FETCH_ASSOC)) {
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