<?php
require_once '../includes/includes.php';
require_once '../templates/admin_header.php';
logged_only();

/************* INSERTION ET EDITION D'UN ARTICLE ************************/
if(isset($_POST['name']) && isset($_POST['slug'])) {
    checkCsrf();
    $slug = $_POST['slug'];
    if(preg_match('/^[a-z\-0-9]+$/', $slug)) {
        $name = $pdo->quote($_POST['name']);
        $slug = $pdo->quote($_POST['slug']);
        $description = $pdo->quote($_POST['description']);
        $content = $pdo->quote($_POST['content']);
        $categorieId = $pdo->quote($_POST['categorieId']);
        if(isset($_GET['id'])) {
            $id = $pdo->quote($_GET['id']);
            $pdo->query("UPDATE article SET name=$name, slug=$slug, description=$description, content=$content WHERE id=$id");
        } else {
            $pdo->query("INSERT INTO article SET name=$name, slug=$slug, content=$content");

            /**********REQUETE TABLE INTERMEDIAIRE ***********/
            $_GET['id'] = $pdo->lastInsertId();
            $articleId = $_GET['id'];
            $pdo->query("INSERT INTO categorie_article SET categorieId=$categorieId, articleId=$articleId");


        }
        $_SESSION['flash']['success'] = 'L\'article a bien été ajouté';
        header('Location: article.php');
        die();
    }else{
        $_SESSION['flash']['danger'] = 'L\'article n\'a pas été ajouté car le slug n\'est pas valide';
        header('Location: article_edit.php');
    }
}

if(isset($_GET['id'])) {
    $id = $pdo->quote($_GET['id']);
    $select = $pdo->query("SELECT * FROM article WHERE id=$id");
    $select->setFetchMode(PDO::FETCH_ASSOC);
    if($select->rowCount() == 0) {
        $_SESSION['flash']['danger'] = 'Il n\'y a pas d\'article avec cet ID';
        header('Location: article_edit.php');
        die();
    }
    $_POST = $select->fetch();
}

$select = $pdo->query('SELECT id, name FROM categorie ORDER BY name ASC');
$select->setFetchMode(PDO::FETCH_ASSOC);
$categories = $select->fetchAll();
$categories_list = array();
foreach($categories as $category) {
    $categories_list[$category['id']] = $category['name'];
}
/*
var_dump($categories_list);
*/
require_once '../templates/admin_header.php';
/*
$select = $pdo->query('SELECT id, name, parentId, slug FROM categorie');
$select->setFetchMode(PDO::FETCH_ASSOC);
$categories = $select->fetchAll();
*/
?>

    <h1>Ajouter un article</h1>

    <form action="" method="POST" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Nom de l'article</label>
            <?= input('name'); ?>
        </div>
        <div class="form-group">
            <label for="slug">URL de l'article</label>
            <?= input('slug'); ?>
        </div><div class="form-group">
            <label for="description">Description de l'article</label>
            <?= input('description'); ?>
        </div>
        <div class="form-group">
            <label for="content">Contenu de l'article</label>
            <?= textarea('content'); ?>
        </div>
        <div class="form-group">
            <label for="categorieId">Catégorie</label>
            <?= select('categorieId', $categories_list); ?>
        </div>
        <?= csrfInput(); ?>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>


<script type="text/javascript" src="../assets/js/ckeditor/ckeditor.js"></script>


<?php require_once '../templates/footer.php';