<?php
require_once 'includes/includes.php';

if(!isset($_GET['id'])) {
    header("HTTP/1.1 301 Moved Permanently");
    header('Location:index.php');
    die();
}
$articleId = $pdo->quote($_GET['id']);
$select = $pdo->query("SELECT * FROM article WHERE id = $articleId");
$select->setFetchMode(PDO::FETCH_ASSOC);
if($select->rowCount() == 0) {
    header("HTTP/1.1 301 Moved Permanently");
    header('Location:index.php');
    die();
}
$article = $select->fetch();

$select = $pdo->query("SELECT * FROM image WHERE articleId = $articleId");
$select->setFetchMode(PDO::FETCH_ASSOC);
$images = $select->fetchAll();

require_once 'templates/header.php';
?>

<h1><?= $article['name']; ?></h1>

<?= $article['content']; ?>
    <?php foreach ($images as $k => $image): ?>
        <img src="assets/images/articles/<?= $image['name']; ?>"  alt="">
    <?php endforeach; ?>


<?php require_once 'templates/footer.php'; ?>