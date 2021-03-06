<?php
if(!empty($_POST) && !empty($_POST['email'])){
    require_once 'includes/db.php';
    require_once 'includes/functions.php';
    $req = $pdo->prepare('SELECT * FROM user WHERE email = ? AND confirmed_at IS NOT NULL');
    $req->execute([$_POST['email']]);
    $user = $req->fetch();
    if($user){
        session_start();
        $reset_token = str_random(60);
        $pdo->prepare('UPDATE user SET reset_token = ?, reset_at = NOW() WHERE id = ?')->execute([$reset_token, $user->id]);
        $_SESSION['flash']['success'] = 'Les instructions du rappel de mot de passe vous ont été envoyées par emails';
        mail($_POST['email'], 'Réinitiatilisation de votre mot de passe', "Afin de réinitialiser votre mot de passe merci de cliquer sur ce lien\n\nhttps://biarritz.yo.fr/reset.php?id={$user->id}&token=$reset_token");
        header('Location: login.php');
        exit();
        // EXIT pour laisser le message de succés s'afficher
    }else{
        $_SESSION['flash']['danger'] = 'Aucun compte ne correspond à cet adresse';
    }
}
?>
<?php require 'templates/header.php'; ?>

<div class="container log-account">
    <h1 class="main-title">Mot de passe oublié</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="">Entrez votre Email</label>
            <input type="email" name="email" class="form-control"/>
        </div>
        <button type="submit" class="btn btn-primary">Réinitialiser mon mot de passe</button>
    </form>
</div>
<?php require 'templates/footer.php'; ?>