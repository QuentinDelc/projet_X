<?php
require_once '../includes/includes.php';
require_once '../templates/admin_header.php';
logged_only();

/**
 * SUPPRESSION
 */
if(isset($_GET['delete'])) {
    checkCsrfDelete();
    $delete = $pdo->quote($_GET['delete']);
    $pdo->query("DELETE FROM difficulty WHERE id=$delete");
    $_SESSION['flash']['success'] = 'La difficulté a bien été supprimée';
    header('Location: difficulty.php');
    die();
}

/**
 * CATEGORIES
 */
$select = $pdo->query('SELECT id, name FROM difficulty');
$select->setFetchMode(PDO::FETCH_ASSOC);
$difficultys = $select->fetchAll();

?>

    <h1>Difficultés</h1>

    <p><a href="difficulty_edit.php" class="btn btn-success">Ajouter une nouvelle difficulté</a></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Niveau de difficulté</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($difficultys as $difficulty): ?>
            <tr>
                <td><?= $difficulty['id']; ?></td>
                <td><?= $difficulty['name']; ?></td>
                <td>
                    <a href="difficulty_edit.php?id=<?= $difficulty['id']; ?>" class="btn btn-warning">Editer</a>
                    <a href="?delete=<?= $difficulty['id']; ?>&<?= csrf(); ?>" class="btn btn-danger" onclick="confirm('Voulez-vous vraiment supprimer cette difficulté ?)">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>





<?php require_once '../templates/footer.php';