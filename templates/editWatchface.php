<img class="screenshot" src="/watchface/uploads/<?php echo $row["image"]; ?>"><br>
<hr>
<form action="/watchface/update/" method="post" enctype="multipart/form-data">
    <table>
        <tr><td>Title:</td><td><?php echo $row["title"]; ?></td></tr>
        <tr><td>Screenshot:</td><td><input type="file" accept="'jpg','png','jpeg'" name="screenshot"></td></tr>
        <tr><td>Description:</td><td><input name="description" type="text" value="<?php echo $row["description"]; ?>"></td></tr>
        <tr><td>Code:</td><td><input type="file" accept="text/x-c" name="code"></td></tr>
    </table>
    <input type="hidden" name="title" value="<?php echo $row["title"]; ?>">
    <input type="submit" name="submit" value="submit">
</form>