<?php
require_once 'includes/includes.php';
require_once 'templates/header.php';
require_once 'templates/slider.php';
?>
  <section class="section section-light">
    <h2>Première section</h2>
    <p>

    </p>
  </section>

  <div class="pimg2">
    <div class="ptext">
      <span class="border trans">
        JE PEUX METTRE QUELQUE CHOSE
      </span>
    </div>
  </div>

  <section class="section section-dark">
    <h2>Deuxième section</h2>
    <p>

    </p>
  </section>

  <div class="pimg3">
    <div class="ptext">
      <span class="border trans">
        JE PEUX METTRE QUELQUE CHOSE
      </span>
    </div>
  </div>

  <section class="section section-dark">
    <h2>Troisième section</h2>
    <p>
    </p>
  </section>

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