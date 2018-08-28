<?php
require_once '../includes/includes.php';
require_once '../templates/admin_header.php';
logged_only();

/**
 * SUPPRESSION
 */
if(isset($_GET['delete'])) {
    checkCsrfDelete();
    $deleted = $pdo->quote($_GET['delete']);
    $pdo->query("DELETE FROM difficulty id=$deleted");
    $_SESSION['flash']['success'] = 'La difficulté a bien été supprimée';
    header('Location: difficulty.php');
    die();
}

/**
 * CATEGORIES
 */
$select = $pdo->query('SELECT * FROM difficulty');
$select->setFetchMode(PDO::FETCH_ASSOC);
$categories = $select->fetchAll();

?>

    <h1>Les difficultés</h1>

    <p><a href="difficulty_edit.php" class="btn btn-success">Ajouter une nouvelle difficulté</a></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['id']; ?></td>
                <td><?= $category['name']; ?></td>
                <td>
                    <a href="difficulty_edit.php?id=<?= $category['id']; ?>" class="btn btn-warning">Editer</a>
                    <a href="?delete=<?= $category['id']; ?>&<?= csrf(); ?>" class="btn btn-danger" onclick="confirm('Voulez-vous vraiment supprimer cet difficulté ?)">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>


<?php require_once '../templates/footer.php';