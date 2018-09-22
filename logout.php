<?php
session_start();
//Je met la clé remember avec la valeur NULL et qui expire dans -1 jours
setcookie('remember', NULL, -1);
unset($_SESSION['auth']);
$_SESSION['flash']['success'] = 'Vous êtes maintenant déconnecté';
header('Location: index.php');