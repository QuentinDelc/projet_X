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
    $pdo->query("DELETE FROM material id=$delete");
    $_SESSION['flash']['success'] = 'Le matériel a bien été supprimé';
    header('Location: materiel.php');
    die();
}

/**
 * CATEGORIES
 */
$select = $pdo->query('SELECT id, name FROM material');
$select->setFetchMode(PDO::FETCH_ASSOC);
$materials = $select->fetchAll();

?>

    <h1>Liste de matériels</h1>

    <p><a href="material_edit.php" class="btn btn-success">Ajouter du matériel</a></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Nom</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($materials as $material): ?>
            <tr>
                <td><?= $material['id']; ?></td>
                <td><?= $material['name']; ?></td>
                <td>
                    <a href="material_edit.php?id=<?= $material['id']; ?>" class="btn btn-warning">Editer</a>
                    <a href="?delete=<?= $material['id']; ?>&<?= csrf(); ?>" class="btn btn-danger" onclick="confirm('Voulez-vous vraiment supprimer ce matériel ?)">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>





<?php require_once '../templates/footer.php';
