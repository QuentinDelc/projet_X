<?php
require_once 'includes/includes.php';
$close =  '<button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>';
if(session_status() == PHP_SESSION_NONE){
    session_start();
}
?>
<?php if(isset($_SESSION['flash'])): ?>
    <?php foreach($_SESSION['flash'] as $type => $message): ?>
        <div class="alert alert-<?= $type; ?>">
            <?=  $close . $message; ?>
        </div>
    <?php endforeach; ?>
    <?php unset($_SESSION['flash']); ?>
<?php endif; ?>
<!DOCTYPE html>
<html lang="fr" class="no-js">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">
    <link rel="icon" type="image/png" href="assets/images/icones/logo.ico" />
    <link href="assets/css/main.css" rel="stylesheet">
    <link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.3.1/css/all.css" integrity="sha384-mzrmE5qonljUremFsqc01SB46JvROS7bZs3IO2EmfFsd15uHvIt+Y8vEf7N7fWAU" crossorigin="anonymous">
    <link rel="stylesheet" type="text/css" href="assets/owl/OwlCarousel2-2.3.4/dist/assets/owl.carousel.css">
    <link rel="stylesheet" type="text/css" href="assets/owl/OwlCarousel2-2.3.4/dist/assets/owl.theme.default.min.css">
    <script src="assets/js/grid/modernizr.custom.js"></script>
    <title>Tuto de couture</title>
</head>

<body>
<header>
    <div class="top-header">
        <div class="container header">
            <div class="col-md-12 col-lg-6 widget-account">
                <div class="top-bar-account">
                    <ul>
                        <?php if (isset($_SESSION['auth'])): ?>
                            <li><a href="account.php" class="nav-links">Bonjour <?= $_SESSION['auth']->username; ?> !</a></li>
                            <li><a href="logout.php" class="nav-links">Se déconnecter</a></li>
                            <li><a href="account.php" class="nav-links">Mon compte</a></li>
                        <?php else: ?>
                            <li><a href="login.php" class="nav-links">Se connecter</a></li>
                            <li><a href="register.php" class=nav-links"">S'inscrire</a></li>
                        <?php endif; ?>
                    </ul>
                </div>
            </div>
            <div class="col-md-6 top-bar-text">
                <div class="social-media">
                    <a href=""><i class="fab fa-facebook-f"></i></a>
                    <a href=""><i class="fab fa-instagram"></i></a>
                    <a href=""><i class="fab fa-pinterest"></i></a>
                    <a href=""><i class="fab fa-twitter"></i></a>
                </div>
                <!--<div class="search-bar">
                    <form method="get" class="form-inline">
                        <input class="form-control search mr-sm-2" type="search" placeholder="Recherche" aria-label="Search">
                    </form>
                </div>-->
            </div>
        </div>
    </div>
    <div class="middle-header">
        <div class="logo-header">
            <a href="index.php"><img src="assets/images/logo/logo.svg" alt="" class="logo"></a>
            <h1>Mon tuto couture</h1>
        </div>
    </div>
    <div class="separate-nav">
        <div class="container">
            <nav class="navbar navbar-expand-lg navbar-light" id="navbar">
                <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                    <div id="nav-anime-hamburger">
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav mr-auto">
                    <?php if (isset($_SESSION['auth'])): ?>
                        <li class="nav-item"><a class="nav-links hidden" href="account.php">Bonjour <?= $_SESSION['auth']->username; ?> !</a></li>
                        <li class="nav-item"><a class="nav-links hidden" href="logout.php">Se déconnecter</a></li>
                        <li class="nav-item"><a class="nav-links hidden" href="account.php">Mon compte</a></li>
                    <?php else: ?>
                        <li><a href="login.php" class="nav-links hidden">Se connecter</a></li>
                        <li><a href="register.php" class="nav-links hidden">S'inscrire</a></li>
                    <?php endif; ?>
                        <li class="nav-item"><a class="nav-links" href="couture.php">Couture</a></li>
                        <li class="nav-item"><a class="nav-links" href="tricot.php">Tricot</a></li>
                        <li class="nav-item"><a class="nav-links" href="crochet.php">Crochet</a></li>
                        <li class="nav-item"><a class="nav-links" href="enfant.php">Côté enfant</a></li>
                        <li class="nav-item"><a class="nav-links" href="contact.php">Contact</a></li>
                    </ul>
                </div>
            </nav>
        </div>
    </div>
</header>

