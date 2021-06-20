<div class="content">
    <h1>Edit Watchface
        <?php echo $row["title"]; ?>
    </h1>
    
    
    <form action="/watchface/update/" method="post" enctype="multipart/form-data">
    <div class="galleryWrapper">
        <div class="gallery">
            <div class="galleryBox">
                <div class="galleryImage" style="background-image: url(https://osw.richter.dev/watchface/uploads/<?php echo $row["image"]; ?>);"></div>
                <div class="gallerySubtitle">
                    Screenshot: <input type="file" accept="image/jpg, image/png ,image/jpeg" name="screenshot">
                </div>
            </div>
            <div class="galleryBox">
                <h2>Description</h2>
                <textarea name="description" rows="3"><?php echo $row["description"]; ?></textarea>
            </div>
            <div class="galleryBox">
                <h2>Watchface File</h2>
                <table>
                    <tr><td>Header (.h)</td><td><input type="file" accept=".h" name="header"></td></tr>
                    <tr><td>Code (.cpp)</td><td><input type="file" accept=".cpp" name="code"></td></tr>
                </table>
                
            </div>
            <div class="galleryBox">
                <h2>Save Watchface</h2>
                <input type="hidden" name="title" value="<?php echo $row["title"]; ?>">
                <button name="submit" type="submit">Save</button>
            </div>
        </div>
    </div>
    </form>
</div>    