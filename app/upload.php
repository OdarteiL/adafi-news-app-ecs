<?php
require_once "config/db.php";

$title = $_POST['title'];
$content = $_POST['content'];
$imageName = '';

if (isset($_FILES['image']) && $_FILES['image']['error'] === 0) {
    $imageName = time() . '-' . basename($_FILES['image']['name']);
    move_uploaded_file($_FILES['image']['tmp_name'], "uploads/$imageName");
}

$stmt = $conn->prepare("INSERT INTO news (title, content, image) VALUES (?, ?, ?)");
$stmt->execute([$title, $content, $imageName]);

header("Location: views/home.php");
exit;
