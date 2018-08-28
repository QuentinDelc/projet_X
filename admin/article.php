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
    $pdo->query("DELETE FROM article WHERE id=$deleted");
    $_GET['id'] = $pdo->lastInsertId();
    $articleId = $_GET['id'];
    $pdo->query("DELETE FROM categorie_article SET categorieId=$categorieId, articleId=$articleId");
    $_SESSION['flash']['success'] = 'L\article a bien été supprimée';
    header('Location: article.php');
    die();
}

/**
 * CATEGORIES
 */
$select = $pdo->query('SELECT id, name, description, slug FROM article');
$select->setFetchMode(PDO::FETCH_ASSOC);
$categories = $select->fetchAll();

?>

    <h1>Mes Articles</h1>

    <p><a href="article_edit.php" class="btn btn-success">Ajouter un nouvel article</a></p>

    <table class="table table-striped">
        <thead>
        <tr>
            <th>Id</th>
            <th>Titre</th>
            <th>Slug</th>
            <th>Actions</th>
        </tr>
        </thead>
        <tbody>
        <?php foreach ($categories as $category): ?>
            <tr>
                <td><?= $category['id']; ?></td>
                <td><?= $category['name']; ?></td>
                <td><?= $category['slug']; ?></td>
                <td>
                    <a href="article_edit.php?id=<?= $category['id']; ?>" class="btn btn-warning">Editer</a>
                    <a href="?delete=<?= $category['id']; ?>&<?= csrf(); ?>" class="btn btn-danger" onclick="confirm('Voulez-vous vraiment supprimer cet article ?)">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>





<?php require_once '../templates/footer.php';
