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

/***************** SELECT DIFFICULTY **********************/
$select = $pdo->query("SELECT * FROM difficulty WHERE articleId = $articleId");
$select->setFetchMode(PDO::FETCH_ASSOC);
$difficultys = $select->fetchAll();

/************* SELECT IMAGE *******************/
$select = $pdo->query("SELECT * FROM image WHERE articleId = $articleId");
$select->setFetchMode(PDO::FETCH_ASSOC);
$images = $select->fetchAll();

/*************** SELECT PDF *************************/
$select = $pdo->query("SELECT * FROM pdf WHERE articleId = $articleId");
$select->setFetchMode(PDO::FETCH_ASSOC);
$pdfs = $select->fetchAll();

require_once 'templates/header.php';
?>
    <div class="container article">
        <h1><?= $article['name']; ?></h1>
        <!--<p><?= $article['difficulty']; ?></p>-->

        <?= $article['content']; ?>
        <?php foreach ($images as $k => $image): ?>
            <img src="assets/images/articles/<?= $image['name']; ?>"  alt="">
        <?php endforeach; ?>

        <div class="pdf">
            <?php if(isset($_SESSION['auth'])) { ?>
              <?php foreach ($pdfs as $k => $pdf): ?>
                 <a href="/assets/images/pdf/<?= $pdf['name']; ?>" target="_blank" class="download-pdf">Télécharger le PDF</a>
              <?php endforeach; ?>
            <?php } else { ?>
                <a href="login.php" class="download-pdf">Vous devez vous connecter pour télécharger le PDF</a>
            <?php } ?>
        </div>
    </div>


<?php require_once 'templates/footer.php'; ?>
