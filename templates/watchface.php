<div class="content">
    <h1>Watchface
        <?php echo $row["title"]; ?> by
        <a href="/user/<?php echo $row["uid"]; ?>">
            <?php echo $row["uid"]; ?>
        </a>
    </h1>
    
    
    
    <div class="galleryWrapper">
        <div class="gallery">
            <div class="galleryBox">
                <a class="invisibleLink" href="/watchface/show/<?php echo $username; ?>/<?php echo $title; ?>/">
                    <div class="galleryImage" style="background-image: url(https://osw.richter.dev/watchface/uploads/<?php echo $row["image"]; ?>);"></div>
                </a>
                <div class="gallerySubtitle">
                    <div>
                        <div class="title"><a class="invisibleLink" href="/watchface/show/<?php echo $username; ?>/<?php echo $title; ?>/"><?php echo $title; ?></a></div>
                        <div class="user"><a href="/user/<?php echo $username; ?>/" class="invisibleLink"><?php echo $username; ?></a></div>
                    </div>
                    <div class="likes"><?php echo $row["votes"]; ?></div>
                    <a href="/vote?uid=<?php echo $username; ?>&title=<?php echo $title; ?>" class="heartLink"><svg class="heart <?php if($voted){echo "active";} ?>" viewBox="-5 -5 42 39.6">
                            <path d="M23.6,0c-3.4,0-6.3,2.7-7.6,5.6C14.7,2.7,11.8,0,8.4,0C3.8,0,0,3.8,0,8.4c0,9.4,9.5,11.9,16,21.2
                        c6.1-9.3,16-12.1,16-21.2C32,3.8,28.2,0,23.6,0z" /></svg></a>
                </div>
            </div>
            <div class="galleryBox">
                <h2>Description</h2>
                <div style="margin: 10%"><?php echo $row["description"];?></div>
            </div>
            <div class="galleryBox">
                <h2>Download Watchface</h2>
                <ol>
                    <li><a href="/watchface/uploads/<?php echo $row["code"];?>" download>Klick to download the watchface.</a></li>
                    <li>Move the watchface into the folder <code>/src/include/watchfaces</code> and rename it.</li>
                    <li>Add <code>watchFaceSwitcher->registerApp(new OswAppWatchfaceBinary());</code> into the watchface section of <code>/src/main.cpp</code>.</li>
                    <li>Compile, Install and Enjoy.</li>
                </ol>
            </div>
            <?php if($uid == $row["uid"]){ ?>
                <div class="galleryBox">
                    <h2>Edit Watchface</h2>
                    <a href="/watchface/edit/<?php echo $row["uid"] . "/" . $row["title"]; ?>/"><h3>Edit</h3></a>
                </div>
            <?php } ?>
        </div>
    </div>
</div>