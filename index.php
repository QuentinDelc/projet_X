<?php
require_once 'includes/includes.php';
require_once 'templates/header.php';
require_once 'templates/slider.php';



$select = $pdo->query("
      SELECT article.name, article.id, article.description, article.slug, image.name as imageName 
      FROM article 
      LEFT JOIN image 
      ON image.id = article.imageId");
$select->setFetchMode(PDO::FETCH_ASSOC);
$article = $select->fetchAll();
//var_dump($article);
?>


<h1>Couture et tutos !</h1>

<div class="container">
    <?php foreach ($article as $k => $v): ?>
    <div class="col-sm-3">
        <a href="view.php?id=<?= $v['id']; ?>">
            <img src="<?= WEBROOT; ?>assets/images/articles/<?= $v['imageName']; ?>" alt="" width="200">
            <h2><?= $v['name']; ?></h2>
        </a>
    </div>

    <?php endforeach; ?>
</div>
<!-- TEST STICKY MENU -->



<?php require_once 'templates/footer.php'; ?>