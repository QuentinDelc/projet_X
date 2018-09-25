<?php
require_once 'includes/includes.php';
require_once 'templates/header.php';

if(!isset($_GET['id'])) {
    header("HTTP/1.1 301 Moved Permanently");
    header('Location:index.php');
    die();
}
$articleId = $pdo->quote($_GET['id']);
$select = $pdo->prepare("SELECT * FROM article WHERE id = $articleId");
$select->execute(array());
$select->setFetchMode(PDO::FETCH_ASSOC);
if($select->rowCount() == 0) {
    header("HTTP/1.1 301 Moved Permanently");
    header('Location:index.php');
    die();
}
$article = $select->fetch();

/***************** SELECT DIFFICULTY **********************/
$select = $pdo->prepare("SELECT a.id id_article, d.name difficulty_name
                                 FROM difficulty d
                                 INNER JOIN article a
                                 ON a.difficultyId = d.id
                                 WHERE a.id = $articleId");
$select->execute(array());
$select->setFetchMode(PDO::FETCH_ASSOC);
$difficultys = $select->fetchAll();

/************* SELECT IMAGE *******************/
$select = $pdo->prepare("SELECT * FROM image WHERE articleId = $articleId");
$select->execute(array());
$select->setFetchMode(PDO::FETCH_ASSOC);
$images = $select->fetchAll();

/*************** SELECT PDF *************************/
$select = $pdo->prepare("SELECT * FROM pdf WHERE articleId = $articleId");
$select->execute(array());
$select->setFetchMode(PDO::FETCH_ASSOC);
$pdfs = $select->fetchAll();


/***************** SELECT AUTEUR ********************************/
$select = $pdo->prepare("SELECT a.id id_article, u.username username_name
                                 FROM user u
                                 INNER JOIN article a
                                 ON a.authorId = u.id
                                 WHERE a.id = $articleId");
$select->execute(array());
$select->setFetchMode(PDO::FETCH_ASSOC);
$authors = $select->fetchAll();


/***************** INSERT COMMENTS *****************************/
if(isset($_SESSION['auth'])) {
    $userId = $_SESSION['auth']->id;
    if (isset($_POST['message'])) {
        if (!empty($_POST['message'])) {
            $message = htmlspecialchars($_POST['message']);
            $result = $pdo->prepare("INSERT INTO comment (message, date, userId, articleId) VALUES (?, NOW(),?,?)");
            $result->execute(array($message, $userId, $_GET['id']));
            $c_msg = "<span style='color:green'>Votre commentaire a bien été enregistré</span>";
        } else {
            $c_msg = "Le commentaire n'a pas été enregistré";
        }
    }
}
/***************** SELECT COMMENTS *****************************/
if(isset($_SESSION['auth'])) {
    $userId = $_SESSION['auth']->id;
    $select = $pdo->prepare("SELECT * FROM comment WHERE userId = $userId AND articleId = $articleId");
    $select->execute(array());
    $select->setFetchMode(PDO::FETCH_ASSOC);
    $messages = $select->fetchAll();
}
?>
<div class="container article">
    <h1><?= $article['name']; ?></h1>
    <?php foreach ($difficultys as $k => $difficulty): ?>
        <p class="difficulty">Niveau de difficulté : <?= $difficulty['difficulty_name']; ?>
    <?php endforeach; ?>
    <?php foreach ($authors as $k => $author): ?>
        <p class="difficulty">Auteur : <?= $author['username_name']; ?>
    <?php endforeach; ?>
    <?= $article['content']; ?>
    <?php foreach ($images as $k => $image): ?>
        <img src="assets/images/articles/<?= $image['name']; ?>"  alt="">
    <?php endforeach; ?>
    <div class="extra">
        <div class="pdf">
            <?php if(isset($_SESSION['auth'])) {
              foreach ($pdfs as $k => $pdf): ?>
                 <a href="/assets/images/pdf/<?= $pdf['name']; ?>" target="_blank" class="download-pdf">
                     Télécharger le PDF</a>
              <?php endforeach;
            } else { ?>
                <a href="login.php" class="download-pdf">Connectez-vous pour télécharger le PDF</a>
            <?php } ?>
        </div>
        <div class="comment">
            <?php if(isset($_SESSION['auth'])) { ?>
            <h3 class="message">Commentaires:</h3>
                <?php foreach ($messages as $k => $message): ?>
                    <p><?= $_SESSION['auth']->username ; ?> : <?= $message['message']; ?> à <?= $message['date']; ?></p>
                <?php endforeach; ?>
            <form method="post">
                <textarea name="message" placeholder="Votre Commentaire..." id=""></textarea><br />
                <input type="submit" value="Poster votre commentaire">
            </form>
            <?php } else { ?>
                <a href="login.php" class="comment">Connectez-vous pour laisser un commentaire</a>
            <?php } ?>
        </div>
    </div>
</div>


<?php require_once 'templates/footer.php'; ?>
