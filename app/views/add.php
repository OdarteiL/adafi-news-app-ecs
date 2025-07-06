<?php
require_once "includes/header.php";
?>

<h1>Add News</h1>
<form action="upload.php" method="POST" enctype="multipart/form-data">
    <input type="text" name="title" placeholder="Title" required><br><br>
    <textarea name="content" placeholder="Content" required></textarea><br><br>
    <input type="file" name="image"><br><br>
    <button type="submit">Publish</button>
</form>

<?php require_once "includes/footer.php"; ?>
