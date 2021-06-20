<div class="content">
    <h1>Watchface
        <?php echo $row["title"]; ?> by
        <a href="/user/<?php echo $row["uid"]; ?>">
            <?php echo $row["uid"]; ?>
        </a>
    </h1>

    <img class="screenshot" src="/watchface/uploads/<?php echo $row["image"]; ?>">
    <a href="/vote/?uid=<?php echo $username; ?>&title=<?php echo $title; ?>"><?php echo $row["votes"]; if($voted){?> 
        &#9829; 
    <?php } else { ?>
        &#9825;
    <?php } ?></a><br>
    <hr>
    <div><?php echo $row["description"];?></div>
    <hr>
    <a href="/watchface/uploads/<?php echo $row["code"];?>">
        Download Watchface
    </a>

    <?php if($uid == $row["uid"]){ ?>
        <hr>
        <a href="/watchface/edit/<?php echo $row["uid"] . "/" . $row["title"]; ?>/">Edit</a>
    <?php } ?>
</div>