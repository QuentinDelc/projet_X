<?php
require_once '../includes/includes.php';
require_once '../templates/admin_header.php';
logged_only();

/************* INSERTION ET EDITION D'UN ARTICLE ************************/
if(isset($_POST['name']) && isset($_POST['slug']) && isset($_POST['description']) && isset($_POST['content']) && isset ($_POST['categoryId']) && isset($_POST['difficultyId'])) {
    checkCsrf();
    $slug = $_POST['slug'];
    if(preg_match('/^[a-z\-0-9]+$/', $slug)) {
        $name = $pdo->quote($_POST['name']);
        $slug = $pdo->quote($_POST['slug']);
        $description = $pdo->quote($_POST['description']);
        $content = $pdo->quote($_POST['content']);
        $categoryId = $pdo->quote($_POST['categoryId']);
        $difficultyId = $pdo->quote($_POST['difficultyId']);

        if (isset($_GET['id'])) {
            $id = $pdo->quote($_GET['id']);
            $pdo->query("UPDATE article SET name=$name, slug=$slug, description=$description, content=$content, difficultyId=$difficultyId WHERE id=$id");
        } else {
            $pdo->query("INSERT INTO article SET name=$name, description=$description, slug=$slug, content=$content, difficultyId=$difficultyId");
/*
        if (isset($_GET['id'])) {
            $id = $pdo->quote($_GET['id']);
            $pdo->query("UPDATE article SET name=$name, slug=$slug, description=$description, content=$content, difficultyId=$difficultyId WHERE id=$id");
        } else {
            $pdo->query("INSERT INTO article (name, description, content, slug)
            VALUES ('name', 'description', 'content', 'slug')");
            $pdo->query("INSERT INTO difficulty (name) VALUES ('difficultId')");
*/
            /**********REQUETE TABLE RELATIONNELLE CATEGORY ***********/
            $_GET['id'] = $pdo->lastInsertId();
            $articleId = $_GET['id'];
            $pdo->query("INSERT INTO category_article SET categoryId=$categoryId, articleId=$articleId");
        }
        $_SESSION['flash']['success'] = 'L\'article a bien été ajouté';

        /******************* INSERTION MINIATURE ****************************/
        $articleId = $pdo->quote($_GET['id']);
        $files = $_FILES['image'];
        $extension = strtolower(pathinfo($files['name'], PATHINFO_EXTENSION));
        if(in_array($extension, array('jpg', 'png', 'jpeg'))) {
            $pdo->query("INSERT INTO image SET articleId=$articleId");
            $imageId = $pdo->lastInsertId();
            $imageName = $imageId . '.' . $extension;
            move_uploaded_file($files['tmp_name'], IMAGES . '/articles/' . $imageName);
            $imageName = $pdo->quote($imageName);
            $pdo->query("UPDATE image SET name=$imageName WHERE id=$imageId");
        }
        /************************* INSERTION PDF **********************************************/
        $articleId = $pdo->quote($_GET['id']);
        $files = $_FILES['pdf'];
        $extension = pathinfo($files['name'], PATHINFO_EXTENSION);
        if(in_array($extension, array('pdf'))) {
            $pdo->query("INSERT INTO pdf SET articleId=$articleId");
            $pdfId = $pdo->lastInsertId();
            $pdfName = $pdfId . '.' . $extension;
            move_uploaded_file($files['tmp_name'], IMAGES . '/pdf/' . $pdfName);
            $pdfName = $pdo->quote($pdfName);
            $pdo->query("UPDATE pdf SET name=$pdfName WHERE id=$pdfId");
        }
        header('Location: article.php');
        die();
    }else{
        $_SESSION['flash']['danger'] = 'L\'article n\'a pas été ajouté vous devez remplir tous les champs !';
        header('Location: article_edit.php');
    }
}


/******************************************/
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

/***************** AFFICHAGE DES CATEGORYS ********************/
$select = $pdo->query('SELECT id, name FROM category ORDER BY name ASC');
$select->setFetchMode(PDO::FETCH_ASSOC);
$categorys = $select->fetchAll();
$categorysList = array();
foreach($categorys as $category) {
    $categorysList[$category['id']] = $category['name'];
}

/***************** AFFICHAGE DES DIFFICULTES ********************/
$select = $pdo->query('SELECT id, name FROM difficulty ORDER BY id ASC');
$select->setFetchMode(PDO::FETCH_ASSOC);
$difficultys = $select->fetchAll();
$difficultysList = array();
foreach($difficultys as $difficulty) {
    $difficultysList[$difficulty['id']] = $difficulty['name'];
}

/************* SUPRESSION MINIATURE ********************/
if(isset($_GET['delete_image'])) {
    checkCsrf();
    $id = $pdo->quote($_GET['delete_image']);
    $select = $pdo->query("SELECT name, articleId FROM image WHERE id=$id");
    $select->setFetchMode(PDO::FETCH_ASSOC);
    $image = $select->fetch();
    unlink(IMAGES . '/articles/' . $image['name']);
    $pdo->query("DELETE FROM image WHERE id=$id");
    $_SESSION['flash']['success'] = 'L\'image a bien été supprimé';
    header('Location:article_edit.php?id=' . $image['articleId']);
    die();
}

/************** AFFICHAGE DES MINIATURES**************/
if(isset($_GET['id'])) {
    $articleId = $pdo->quote($_GET['id']);
    $select = $pdo->query("SELECT id, name FROM image WHERE articleId=$articleId");
    $select->setFetchMode(PDO::FETCH_ASSOC);
    $images = $select->fetchAll();
} else {
    $images = array();
}

/************* IMAGE A LA UNE ********************/
if(isset($_GET['image-une'])) {
    checkCsrf();
    $articleId = $pdo->quote($_GET['id']);
    $imageId = $pdo->quote($_GET['image-une']);
    $pdo->query("UPDATE article SET imageId=$imageId WHERE id=$articleId");
    $_SESSION['flash']['success'] = 'L\'image a bien été mise à la une';
    header('Location:article_edit.php?id=' . $_GET['id']);
    die();
}

/************ SUPPRESSION PDF ********************/
if(isset($_GET['delete_pdf'])) {
    checkCsrf();
    $id = $pdo->quote($_GET['delete_pdf']);
    $select = $pdo->query("SELECT name, articleId FROM pdf WHERE id=$id");
    $select->setFetchMode(PDO::FETCH_ASSOC);
    $pdf = $select->fetch();
    unlink(IMAGES . '/pdf/' . $pdf['name']);
    $pdo->query("DELETE FROM pdf WHERE id=$id");
    $_SESSION['flash']['success'] = 'Le pdf a bien été supprimé';
    header('Location:article_edit.php?id=' . $pdf['articleId']);
    die();
}

if(isset($_GET['id'])) {
    $articleId = $pdo->quote($_GET['id']);
    $select = $pdo->query("SELECT id, name FROM pdf WHERE articleId=$articleId");
    $select->setFetchMode(PDO::FETCH_ASSOC);
    $pdfs = $select->fetchAll();
} else {
    $pdfs = array();
}

require_once '../templates/admin_header.php';
?>

    <h1>Ajouter un article</h1>

        <form action="" method="POST" enctype="multipart/form-data">
            <div class="col-sm-9">
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
                    <label for="categoryId">Catégorie</label>
                    <?= select('categoryId', $categorysList); ?>
                </div>
                <div class="form-group">
                    <label for="difficultyId">Difficulté</label>
                    <?= select('difficultyId', $difficultysList); ?>
                </div>
                <?= csrfInput(); ?>
                <button type="submit" class="btn btn-primary">Enregistrer</button>
            </div>
            <div class="col-sm-3">
                <?php foreach($images as $k => $image): ?>
                    <p>
                        <img src="<?= WEBROOT; ?>assets/images/articles/<?= $image['name']; ?>" width="200">
                        <a href="?delete_image=<?= $image['id']; ?>&<?=csrf(); ?>" onclick="return confirm('Voulez vous supprimer la miniature de l\'article?);">Supprimer</a>
                        <a href="?image-une=<?= $image['id']; ?>&id=<?= $_GET['id']; ?>&<?= csrf(); ?>">Mettre en une de l'article</a>
                    </p>
                <?php endforeach; ?>
                <div class="form-group">
                    <label for="image">Votre Image :</label>
                    <input type="file" name="image">
                </div>
                <div class="form-group">
                    <label for="pdf">PDF à télécharger :</label>
                    <input type="file" name="pdf">
                </div>
                <?php foreach($pdfs as $k => $pdf): ?>
                    <p>
                        <a href="?delete_pdf=<?= $pdf['id']; ?>&<?=csrf(); ?>" onclick="myFunction()confirm('Voulez vous supprimer le pdf de l\'article?);">Supprimer le pdf</a>
                    </p>
                <?php endforeach; ?>
            </div>
        </form>

    <script type="text/javascript" src="../assets/ckeditor/ckeditor.js"></script>


<?php require_once '../templates/admin_footer.php';