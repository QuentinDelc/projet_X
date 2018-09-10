<?php
require_once 'includes/includes.php';
require_once 'templates/header.php';

$select = $pdo->query("
      SELECT article.id, article.name, article.description, article.slug, image.name as imageName 
      FROM article 
      LEFT JOIN image 
      ON image.id = article.imageId
      INNER JOIN category_article 
      ON article.id = category_article.articleId
      WHERE categoryId = 2");
$select->setFetchMode(PDO::FETCH_ASSOC);
$articles = $select->fetchAll();

?>
    <div class="banner couture">
        <div class="banner_overlay">
            <div class="container banner_container">
                <div class="box-banner box-banner-big">
                    <h1 class="box-banner_title">Tricot</h1>
                </div><a class="banner_arrow-bottom js-scrollto" href="#couture"></a>
            </div>
        </div>
    </div>

    <div class="container" id="couture">
        <ul class="grid effect zoom" id="grid">
            <?php foreach ($articles as $k => $article): ?>
                <li>
                    <figure class="text-content image">
                        <img src="<?= WEBROOT; ?>assets/images/articles/<?= $article['imageName']; ?>" alt="">
                        <figcaption>
                            <h3><a href="" class="title-article"><?= $article['name']; ?></a></h3>
                            <p><?= $article['description']; ?></p>
                            <a class="btn-discover" href="decoration.php">DÉCOUVRIR</a>
                        </figcaption>
                    </figure>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>

<?php require 'templates/footer.php'; ?>