<?php
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
    <title>Mon administration</title>
    <link href="../assets/css/bootstrap.css" rel="stylesheet">
    <link href="../assets/css/style.css" rel="stylesheet">
</head>

<body>

<nav class="navbar navbar-inverse admin">
    <div class="container admin">
        <div class="navbar-header">
            <a href="" class="navbar-brand">Administration du site</a>
        </div>
        <ul class="nav navbar-nav">
            <li><a href="article.php">Articles</a></li>
            <li><a href="category.php">Catégories</a></li>
            <li><a href="difficulty.php">Difficultés</a></li>
            <li><a href="material.php">Matériaux</a></li>
            <li><a href="../index.php">Retour au site</a></li>
        </ul>
    </div>
</nav>

<div class="container admin">

    <?php if(isset($_SESSION['flash'])): ?>
        <?php foreach($_SESSION['flash'] as $type => $message): ?>
            <div class="alert alert-<?= $type; ?>">
                <?=  $close . $message; ?>
            </div>
        <?php endforeach; ?>
        <?php unset($_SESSION['flash']); ?>
    <?php endif; ?>

