<?php

try {
    $pdo = new PDO('mysql:dbname=projet_x;host=localhost', 'root', '');
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $pdo->setAttribute(PDO::ATTR_DEFAULT_FETCH_MODE, PDO::FETCH_OBJ);
} catch (Exception $e) {
    echo 'Impossible de se connecter à la base de données';
    echo $e->getMessage();
    die();
}
