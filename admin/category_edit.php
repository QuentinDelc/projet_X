<?php
require_once '../includes/includes.php';
require_once '../templates/admin_header.php';
logged_only();

if(isset($_POST['name']) && isset($_POST['slug'])) {
    checkCsrf();
    $slug = $_POST['slug'];
    if(preg_match('/^[a-z\-0-9]+$/', $slug)) {
        $name = $pdo->quote($_POST['name']);
        $slug = $pdo->quote($_POST['slug']);
        if(isset($_GET['id'])) {
            $id = $pdo->quote($_GET['id']);
            $pdo->query("UPDATE categorie SET name=$name, slug=$slug WHERE id=$id");
        } else {
            $pdo->query("INSERT INTO categorie SET name=$name, slug=$slug");
            /*$pdo->query("INSERT INTO categorie_article SET id=$id WHERE categorieId=$id");*/
        }
        $_SESSION['flash']['success'] = 'La catégorie a bien été ajoutée';
        header('Location: category.php');
        die();
    }else{
        $_SESSION['flash']['danger'] = 'La catégorie n\'a pas été ajouté car le slug n\'est pas valide';
        header('Location: category_edit.php');
    }
}

if(isset($_GET['id'])) {
    $id = $pdo->quote($_GET['id']);
    $select = $pdo->query("SELECT * FROM categorie WHERE id=$id");
    $select->setFetchMode(PDO::FETCH_ASSOC);
    if($select->rowCount() == 0) {
        $_SESSION['flash']['danger'] = 'Il n\'y a pas de catégorie avec cet ID';
        header('Location: category_edit.php');
        die();
    }
    $_POST = $select->fetch();
}

require_once '../templates/admin_header.php';
/*
$select = $pdo->query('SELECT id, name, parentId, slug FROM categorie');
$select->setFetchMode(PDO::FETCH_ASSOC);
$categories = $select->fetchAll();
*/
?>

<h1>Ajouter une catégorie</h1>

    <form action="" method="POST">
        <div class="form-group">
            <label for="name">Nom de la catégorie</label>
            <?= input('name'); ?>
            <!--<input type="text" name="name" class="form-control"/>-->
        </div>
        <div class="form-group">
            <label for="slug">URL de la catégorie</label>
            <?= input('slug'); ?>
            <!--<input type="text" name="slug" class="form-control"/>-->
        </div>
        <?= csrfInput(); ?>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>


<?php require_once '../templates/footer.php';