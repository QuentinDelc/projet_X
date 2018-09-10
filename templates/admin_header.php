<?php
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
if (empty($_SESSION['auth']) && basename($_SERVER['SCRIPT_FILENAME']) !== 'login.php' || isset($_SESSION['auth']  ) && !$_SESSION['auth']->isAdmin && basename($_SERVER['SCRIPT_FILENAME']) !== 'login.php') {
    if (isset($_SESSION['auth']) && !$_SESSION['auth']->isAdmin) {
        header('Location: ../login.php');
    }
    else {
        header('Location: ../login.php');
    }
    die();
}
$close = '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="../../favicon.ico">
    <title>Mon administration</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>

<?php if (basename($_SERVER['SCRIPT_FILENAME']) !== 'login.php') : ?>
    <nav class="navbar navbar-inverse" style="margin-top: 0;">
        <div class="container">
            <div class="navbar-header">
                <a class="navbar-brand" href="#">Administration du site</a>
            </div>
            <ul class="nav navbar-nav">
                <?php if (isset($_SESSION['auth'])): ?>
                    <li><a href="../account.php" class="nav-links">Bonjour <?= $_SESSION['auth']->username; ?> !</a></li>
                    <li><a href="../logout.php" class="nav-links">Se déconnecter</a></li>
                <?php else: ?>
                    <li><a href="login.php" class="nav-links">Se connecter</a></li>
                    <li><a href="register.php" class=nav-links"">S'inscrire</a></li>
                <?php endif; ?>
                <li class="dropdown">
                    <a class="dropdown-toggle" data-toggle="dropdown" href="article.php">Articles
                        <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="couture_admin.php">Couture</a></li>
                        <li><a href="tricot_admin.php">Tricot</a></li>
                        <li><a href="crochet_admin.php">Crochet</a></li>
                        <li><a href="enfant_admin.php">Enfant</a></li>
                    </ul>
                </li>
                <li><a href="category.php">Catégories</a></li>
                <li><a href="difficulty.php">Difficultés</a></li>
                <li><a href="material.php">Matériaux</a></li>
                <li><a href="../index.php">Retour au site</a></li>
            </ul>
        </div>
    </nav>
<?php endif; ?>

<div class="container admin">

    <?php if(isset($_SESSION['flash'])): ?>
        <?php foreach($_SESSION['flash'] as $type => $message): ?>
            <div class="alert alert-<?= $type; ?>">
                <?=  $close . $message; ?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

