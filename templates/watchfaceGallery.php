<div class="galleryWrapper">
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
<?php function addTile($user, $title, $image, $votes, $v){ ?>
    <div class="galleryBox">
        <a class="invisibleLink" href="/watchface/show/<?php echo $user; ?>/<?php echo $title; ?>/">
            <div class="galleryImage" style="background-image: url(https://osw.richter.dev/watchface/uploads/<?php echo $image; ?>);"></div>
        </a>
        <div class="gallerySubtitle">
            <div>
                <div class="title"><a class="invisibleLink" href="/watchface/show/<?php echo $user; ?>/<?php echo $title; ?>/"><?php echo $title; ?></a></div>
                <div class="user"><a href="/user/<?php echo $user; ?>/" class="invisibleLink"><?php echo $user; ?></a></div>
            </div>
            <div class="likes"><?php echo $votes; ?></div>
            <svg class="heart <?php if($v){echo "active";} ?>" item="<?php echo $user; ?>/<?php echo $title; ?>" viewBox="-5 -5 42 39.6">
                    <path d="M23.6,0c-3.4,0-6.3,2.7-7.6,5.6C14.7,2.7,11.8,0,8.4,0C3.8,0,0,3.8,0,8.4c0,9.4,9.5,11.9,16,21.2
                c6.1-9.3,16-12.1,16-21.2C32,3.8,28.2,0,23.6,0z" /></a>
        </div>
    </div>
<?php } ?>
    
</div>
</div>