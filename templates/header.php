<?php
require_once 'includes/includes.php';
$close =  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
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
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link href="assets/css/style.css" rel="stylesheet">
    <!--<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">-->
    <link rel="stylesheet" type="text/css" href="assets/owl/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="assets/owl/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css">
    <!--<link rel="stylesheet" href="assets/css/main.css" />-->
    <title>Tuto de couture</title>
</head>

<body>
<header>
    <div class="top-header">
        <div class="container">
            <div class="top-bar-text">
                <div class="top-text">
                    <p>La couture devient accessible à tous !</p>
                </div>
            </div>
            <div class="widget-account">
                <div class="top-bar-account">
                    <ul>
                        <?php if (isset($_SESSION['auth'])): ?>
                            <li><a href="account.php" class="nav-links">Bonjour <?= $_SESSION['auth']->username; ?> !</a></li>
                            <li><a href="logout.php" class="nav-links">Se déconnecter</a></li>
                            <li><a href="account.php" class="nav-links">Mon compte</a></li>
                        <?php else: ?>
                            <li><a href="register.php" class=nav-links"">S'inscrire</a></li>
                            <li><a href="login.php" class="nav-links">Se connecter</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
        </div>
    </div>
    <div class="middle-header">
        <div class="container">
            <div class="logo-header">
                <a href="index.php"><img src="assets/images/logo/logo.png" alt="" class="logo"></a>
            </div>
        </div>
    </div>
    <div class="container head menu" >
    <nav class="navbar navbar-expand-lg navbar-light">
        <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav mr-auto">
                <li class="nav-item"><a class="nav-link" href="#">Couture</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Tricot</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Crochet</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Côté enfant</a></li>
                <li class="nav-item"><a class="nav-link" href="#">Contact</a></li>
            </ul>
            <form class="form-inline my-2 my-lg-0">
                <input class="form-control mr-sm-2" type="search" placeholder="Recherche" aria-label="Search">
            </form>
        </div>
    </nav>
</header>

    <?php if(isset($_SESSION['flash'])): ?>
        <?php foreach($_SESSION['flash'] as $type => $message): ?>
            <div class="alert alert-<?= $type; ?>">
                <?=  $close . $message; ?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>
