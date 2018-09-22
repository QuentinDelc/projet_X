<?php
require 'includes/functions.php';
logged_only();
if(!empty($_POST)){

    if(empty($_POST['password']) || $_POST['password'] != $_POST['password_confirm']){
        $_SESSION['flash']['danger'] = "Les mots de passe ne correspondent pas";
    }else{
        $userId = $_SESSION['auth']->id;
        $password= password_hash($_POST['password'], PASSWORD_BCRYPT);
        require_once 'includes/db.php';
        $pdo->prepare('UPDATE user SET password = ? WHERE id = ?')->execute([$password, $userId]);
        $_SESSION['flash']['success'] = "Votre mot de passe a bien été mis à jour";
    }
}

require 'templates/header.php';
?>
<div class="container log-account">
    <h1 class="main-title">Bonjour <?= $_SESSION['auth']->username; ?></h1>
    <form action="" method="post">
        <div class="form-group">
            <label for="">Changer de mot de passe</label>
            <input class="form-control" type="password" name="password"/>
        </div>
        <div class="form-group">
            <label for="">Confirmez le mot de passe</label>
            <input class="form-control" type="password" name="password_confirm" />
        </div>
        <button class="btn btn-primary">Changer mon mot de passe</button>
    </form>
</div>

<?php require 'templates/footer.php'; ?>