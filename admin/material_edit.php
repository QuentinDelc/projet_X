<?php
require_once '../includes/includes.php';
require_once '../templates/admin_header.php';
logged_only();

if(isset($_POST['name'])) {
    checkCsrf();
    $name = $pdo->quote($_POST['name']);
    if(isset($_GET['id'])) {
        $id = $pdo->quote($_GET['id']);
        $pdo->query("UPDATE material SET name=$name WHERE id=$id");
    } else {
        $pdo->query("INSERT INTO material SET name=$name");
        /*$pdo->query("INSERT INTO categorie_article SET id=$id WHERE categorieId=$id");*/
    }
    $_SESSION['flash']['success'] = 'Le matériel a bien été ajoutée';
    header('Location: material.php');
    die();
    }else{
        $_SESSION['flash']['danger'] = 'Le matériel n\'a pas été ajouté';
        //header('Location: material_edit.php');
    }


if(isset($_GET['id'])) {
    $id = $pdo->quote($_GET['id']);
    $select = $pdo->query("SELECT * FROM material WHERE id=$id");
    $select->setFetchMode(PDO::FETCH_ASSOC);
    if($select->rowCount() == 0) {
        $_SESSION['flash']['danger'] = 'Il n\'y a pas de matériel avec cet ID';
        header('Location: material_edit.php');
        die();
    }
    $_POST = $select->fetch();
}

require_once '../templates/admin_header.php';

?>

    <h1>Ajouter du matériel</h1>

    <form action="" method="POST">
        <div class="form-group">
            <label for="name">Nom du matériel</label>
            <?= input('name'); ?>
            <!--<input type="text" name="name" class="form-control"/>-->
        </div>
        <?= csrfInput(); ?>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>


<?php require_once '../templates/footer.php';