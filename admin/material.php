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
    $pdo->query("DELETE FROM material id=$deleted");
    $_SESSION['flash']['success'] = 'Le matériel a bien été supprimé';
    header('Location: materiel.php');
    die();
}

/**
 * CATEGORIES
 */
$select = $pdo->query('SELECT id, name FROM material');
$select->setFetchMode(PDO::FETCH_ASSOC);
$categories = $select->fetchAll();

?>

    <h1>Liste de matériels</h1>

    <p><a href="article_edit.php" class="btn btn-success">Ajouter du matériel</a></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['id']; ?></td>
                <td><?= $category['name']; ?></td>
                <td>
                    <a href="material_edit.php?id=<?= $category['id']; ?>" class="btn btn-warning">Editer</a>
                    <a href="?delete=<?= $category['id']; ?>&<?= csrf(); ?>" class="btn btn-danger" onclick="confirm('Voulez-vous vraiment supprimer cet article ?)">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>





<?php require_once '../templates/footer.php';
