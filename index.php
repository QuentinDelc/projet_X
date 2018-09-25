<?php
require_once 'includes/includes.php';
require_once 'templates/header.php';
require_once 'templates/slider.php';
?>
  <section class="section section-light">
      <blockquote cite="">
          <p class="cite">Pour réaliser de grandes choses, il faut d'abord rêver</p>
      </blockquote>
      <cite>– Coco Chanel</cite>
  </section>

  <div class="pimg2">
    <div class="ptext">
      <span class="border trans">
          <a href="couture.php">Découvrez la couture</a>
      </span>
    </div>
  </div>

  <div class="pimg3">
    <div class="ptext">
      <span class="border trans">
          <a href="couture.php">Découvrez le tricot</a>
      </span>
    </div>
  </div>

  <div class="pimg4">
    <div class="ptext">
      <span class="border trans">
          <a href="couture.php">Découvrez le crochet</a>
      </span>
    </div>
  </div>

  <div class="pimg5">
    <div class="ptext">
      <span class="border trans">
          <a href="couture.php">Découvrez les enfants</a>
      </span>
    </div>
  </div>

<?php
$select = $pdo->query("
      SELECT article.name, article.id, article.description, article.slug, image.name as imageName 
      FROM article 
      LEFT JOIN image 
      ON image.id = article.imageId");
$select->setFetchMode(PDO::FETCH_ASSOC);
$articles = $select->fetchAll();
?>


<?php require_once 'templates/prefooter.php'; ?>
<?php require_once 'templates/footer.php'; ?>