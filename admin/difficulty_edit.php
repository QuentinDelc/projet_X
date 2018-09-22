<?php
require_once '../includes/includes.php';
require_once '../templates/admin_header.php';
logged_only();

if(isset($_POST['name'])) {
    checkCsrf();
    $name = $_POST['name'];
    if (preg_match('/^[a-z\-0-9]+$/', $name)) {
        $name = $pdo->quote($_POST['name']);
        if (isset($_GET['id'])) {
            $id = $pdo->quote($_GET['id']);
            $pdo->query("UPDATE difficulty SET name=$name WHERE id=$id");
        } else {
            $pdo->query("INSERT INTO difficulty (name) VALUES ($name)");
        }
        $_SESSION['flash']['success'] = 'La difficulté a bien été ajoutée';
        header('Location: difficulty.php');
        die();
    } else {
        $_SESSION['flash']['danger'] = 'La difficulté n\'a pas été ajouté';
    }
}

if(isset($_GET['id'])) {
    $id = $pdo->quote($_GET['id']);
    $select = $pdo->query("SELECT * FROM difficulty WHERE id=$id");
    $select->setFetchMode(PDO::FETCH_ASSOC);
    if($select->rowCount() == 0) {
        $_SESSION['flash']['danger'] = 'Il n\'y a pas de difficulté avec cet ID';
        header('Location: difficulty_edit.php');
        die();
    }
    $_POST = $select->fetch();
}

require_once '../templates/admin_header.php';
?>

    <h1>Ajouter une difficulté</h1>

    <form action="" method="POST">
        <div class="form-group">
            <label for="name">Nom de la difficulté</label>
            <?= input('name'); ?>
        </div>
        <?= csrfInput(); ?>
        <button type="submit" class="btn btn-primary">Enregistrer</button>
    </form>


<?php require_once '../templates/admin_footer.php';