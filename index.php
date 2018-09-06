<?php
require_once 'includes/includes.php';
require_once 'templates/header.php';


$select = $pdo->query("
      SELECT article.name, article.id, article.description, article.slug, image.name as imageName 
      FROM article 
      LEFT JOIN image 
      ON image.id = article.imageId");
$select->setFetchMode(PDO::FETCH_ASSOC);
$article = $select->fetchAll();
//var_dump($article);
?>
    <div class="slider-section__carousel">
        <div class="main-carousel owl-carousel-v1 owl-carousel owl-theme">
            <div class="main-carousel__slide item slide1">
                <div class="main-carousel__overlay">
                    <div class="content-slide">
                        <h3 class="main-carousel__title main-title main-title--center">UN CENTRE DE FORMATION ANGLET-BAYONNE-BIARRITZ</h3>
                        <p class="main-carousel__description">Des formations sur-mesure avec des professeurs natifs</p>
                        <a class="main-carousel__btn btn" href="">DÉCOUVRIR  </a>
                    </div>
                </div>
            </div>
            <div class="main-carousel__slide item slide2">
                <div class="main-carousel__overlay">
                    <div class="content-slide">
                        <h3 class="main-carousel__title main-title main-title--center">RÉUSSISSEZ LES TESTS TOEIC-TOEFL EET BULATS</h3>
                        <p class="main-carousel__description">Préparer et valider votre niveau en anglais et espagnol.</p>
                        <a class="main-carousel__btn btn" href="">DÉCOUVRIR</a>
                    </div>
                </div>
            </div>
            <div class="main-carousel__slide item slide3">
                <div class="main-carousel__overlay">
                    <div class="content-slide">
                        <h3 class="main-carousel__title main-title main-title--center">UNE ÉCOLE DE LANGUES PAS COMME LES AUTRES</h3>
                        <p class="main-carousel__description">Des formations sur-mesure avec des professeurs natifs</p>
                        <a class="main-carousel__btn btn" href="">DÉCOUVRIR</a>
                    </div>
                </div>
            </div>
            <div class="main-carousel__slide item slide4">
                <div class="main-carousel__overlay">
                    <div class="content-slide">
                        <h3 class="main-carousel__title main-title main-title--center">UNE ÉCOLE DE LANGUES PAS COMME LES AUTRES</h3>
                        <p class="main-carousel__description">Des formations sur-mesure avec des professeurs natifs</p>
                        <a class="main-carousel__btn btn" href="">DÉCOUVRIR</a>
                    </div>
                </div>
            </div>
        </div>
    </div>

<h1>Couture et tutos !</h1>

<div class="row">

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

<div class="container">
    <div class="row">
        <img src="assets/images/slider/couture.jpg" alt="" width="800px">
    </div>
</div>
<?php require_once 'templates/footer.php'; ?>