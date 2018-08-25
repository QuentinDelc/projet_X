<?php
require_once 'includes/db.php';
require_once 'templates/header.php';
?>


<h1>Mon portfolio</h1>

<?php
$select= $pdo->query('SELECT * FROM user');
//var_dump($select->fetch());
?>

<?php require_once 'templates/footer.php'; ?>
