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
$_SESSION['flash']['success'] = 'Vous êtes maintenant connecté';
var_dump($_POST['remember']);
if($_POST['remember']){
    $remember_token = str_random(250);
    $pdo->prepare('UPDATE user SET remember_token = ? WHERE id = ?')->execute([$remember_token, $user->id]);
    // 1er paramètre remember pour tout sauvegarder, user-> en 1er paramètre de la clé remember_token je sépara par ==,
    // je cripte l'id suivie de la clé liametava, enfin en 3eme paramètre le temps du cookie qui expire dans 7 jours
    setcookie('remember', $user->id . '==' . $remember_token . sha1($user->id . 'liametava'), time() + 60 * 60 * 24 * 7);
}
        header('Location: index.php');
        die();
    }else{
        $_SESSION['flash']['danger'] = 'Identifiant ou mot de passe incorrecte';
    }
}
?>
<?php require 'templates/header.php'; ?>
<div class="container log-account">
    <h1 class="main-title">CONNECTEZ-VOUS</h1>
    <form action="" method="POST">
        <div class="form-group">
            <label for="username">Pseudo ou email</label>
            <?= input('username'); ?>
        </div>
        <div class="form-group">
            <label for="password">Mot de passe</label>
            <input type="password" name="password" class="form-control"/>
            <a href="forget.php">(J'ai oublié mon mot de passe)</a>
        </div>
        <div class="form-group">
            <label>
                <input type="checkbox" name="remember" value="1"/> Se souvenir de moi
            </label>
        </div>
        <button type="submit" class="btn btn-primary">Se connecter</button>
        <p>Vous n'êtes pas encore inscrit ?</p>
        <a href="register.php">C'est par ici !</a>
    </form>
</div>

<?php require 'templates/footer.php'; ?>