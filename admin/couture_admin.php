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
    $pdo->query("DELETE FROM article WHERE id=$delete");
    $_SESSION['flash']['success'] = 'L\'article a bien été supprimée';
    header('Location: article.php');
    die();
}

/**
 * CATEGORYS
 * SELECT article.id, article.name, article.description, article.slug
FROM c = category, a = article, ca = category_article
WHERE c.id = ca.categoryId, ca.articleId = article.id
c.id = 1
*/
$select = $pdo->query('SELECT article.id, name, description, slug 
                                 FROM article
                                 INNER JOIN category_article 
                                 ON article.id = articleId
                                 WHERE categoryId = 1');
$select->setFetchMode(PDO::FETCH_ASSOC);
$articles = $select->fetchAll();

?>

    <h1>Mes Articles sur la couture</h1>

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
        <?php foreach ($articles as $article): ?>
            <tr>
                <td><?= $article['id']; ?></td>
                <td><?= $article['name']; ?></td>
                <td><?= $article['slug']; ?></td>
                <td>
                    <a href="article_edit.php?id=<?= $article['id']; ?>" class="btn btn-warning">Editer</a>
                    <a href="?delete=<?= $article['id']; ?>&<?= csrf(); ?>" class="btn btn-danger" onclick="confirm('Voulez-vous vraiment supprimer cet article ?)">Supprimer</a>
                </td>
            </tr>
        <?php endforeach; ?>
        </tbody>
    </table>

<?php require_once '../templates/admin_footer.php';