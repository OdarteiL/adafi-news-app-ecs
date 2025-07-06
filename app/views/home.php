<?php
require_once "config/db.php";
require_once "includes/header.php";

$news = $conn->query("SELECT * FROM news ORDER BY created_at DESC")->fetchAll();
?>

<h1>Latest News</h1>

<?php foreach ($news as $article): ?>
    <div class="news-item">
        <h2><?= htmlspecialchars($article['title']) ?></h2>
        <p><?= nl2br(htmlspecialchars($article['content'])) ?></p>
        <?php if ($article['image']): ?>
           <img src="uploads/<?= htmlspecialchars($article['image']) ?>" width="300">
        <?php endif; ?>
        <hr>
    </div>
<?php endforeach; ?>

<?php require_once "includes/footer.php"; ?>
