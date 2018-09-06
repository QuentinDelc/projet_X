<?php
require_once 'includes/functions.php';
reconnect_from_cookie();
if(isset($_SESSION['auth'])){
    header('Location: index.php');
    exit();
}
if(!empty($_POST) && !empty($_POST['username']) && !empty($_POST['password'])){
    require_once 'includes/db.php';
    $req = $pdo->prepare('SELECT * FROM user WHERE (username = :username OR email = :username) AND confirmed_at IS NOT NULL');
    $req->execute(['username' => $_POST['username']]);
    $user = $req->fetch();
    if(password_verify($_POST['password'], $user->password)){
        $_SESSION['auth'] = $user;
        //setFlash('Vous êtes maintenant connecté');
$_SESSION['flash']['success'] = 'Vous êtes maintenant connecté';
if($_POST['remember']){
    $remember_token = str_random(250);
    $pdo->prepare('UPDATE user SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
    setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . ''), time() + 60 * 60 * 24 * 7);
}
        header('Location: index.php');
        die();
    }else{
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte';
    }
}
?>
<?php require 'templates/header.php'; ?>
<div class="container login">
    <h1 class="main-title">CONNECTEZ-VOUS</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="username">Pseudo ou email</label>
            <?= input('username'); ?>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe <a href="forget.php">(J'ai oublié mon mot de passe)</a></label>
            <input type="password" name="password" class="form-control"/>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="remember" value="1"/> Se souvenir de moi
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
    </form>
</div>

<?php require 'templates/footer.php'; ?>