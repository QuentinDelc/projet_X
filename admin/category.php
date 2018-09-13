<?php
require_once '../includes/includes.php';
require_once '../templates/admin_header.php';
logged_only();

/**
 * SUPPRESSION
 */
if(isset($_GET['delete'])) {
    checkCsrf();
    $delete = $pdo->quote($_GET['delete']);
    $pdo->query("DELETE FROM category WHERE id=$delete");
    $_SESSION['flash']['success'] = 'La catégorie a bien été supprimée';
    header('Location: category.php');
    die();
}

/**
 * CATEGORYS
 */
$select = $pdo->query('SELECT id, name, slug FROM category');
$select->setFetchMode(PDO::FETCH_ASSOC);
$categorys = $select->fetchAll();

?>

<h1>Les catégories</h1>

    <p><a href="category_edit.php" class="btn btn-success">Ajouter une nouvelle catégorie</a></p>

<table class="table table-striped">
    <thead>
    <tr>
        <th>Id</th>
        <th>Nom</th>
        <th>Actions</th>
    </tr>
    </thead>
    <tbody>
    <?php foreach ($categorys as $category): ?>
        <tr>
            <td><?= $category['id']; ?></td>
            <td><?= $category['name']; ?></td>
            <td>
                <a href="category_edit.php?id=<?= $category['id']; ?>" class="btn btn-warning">Editer</a>
                <a href="?delete=<?= $category['id']; ?>&<?= csrf(); ?>" class="btn btn-danger" onclick="confirm('Voulez-vous vraiment supprimer cette catégorie ?)">Supprimer</a>
            </td>
        </tr>
    <?php endforeach; ?>
    </tbody>
</table>





<?php require_once '../templates/admin_footer.php';
