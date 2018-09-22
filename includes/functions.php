<?php

function str_random($length){
    $alphabet = "0123456789azertyuiopqsdfghjklmwxcvbnAZERTYUIOPQSDFGHJKLMWXCVBN";
    return substr(str_shuffle(str_repeat($alphabet, $length)), 0, $length);
}

function logged_only(){
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(!isset($_SESSION['auth'])){
        $_SESSION['flash']['danger'] = "Vous n'avez pas le droit d'accéder à cette page";
        header('Location: login.php');
        die();
    }
}

function reconnect_from_cookie(){
    //Si l'utilisateur n'est pas connecté
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(isset($_COOKIE['remember']) && !isset($_SESSION['auth']) ){
        require_once 'db.php';
        if(!isset($pdo)){
            // Afin de pouvoir accès à la varialble $pdo je la met en global car le requier est déjà fait ailleurs
            global $pdo;
        }
        $remember_token = $_COOKIE['remember'];
        //je sépare le cookie par == avec la fonction explode() qui coupe une chaîne de caractères en segments
        //et je sauvegarde ceci dans une variable
        //Je récupère l'id de l'utilisateur qui sera la première partie
        //Ensuite je fais une requête pour récupérer le premier utilisateur qui correspond
        //et je récupère le premier résultat
        $parts = explode('==', $remember_token);
        $user_id = $parts[0];
        $req = $pdo->prepare('SELECT * FROM user WHERE id = ?');
        $req->execute([$user_id]);
        $user = $req->fetch();
        if($user){
            // si j'ai une info je vais vérifier que le token correspond
            //en pasant en paramètre le $userId, ensuite le remember_token que je récupère en base de données
            $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'liametava');
            // et je demande que si $exepected et égale au token qui est stocké dans le cookie
            // et bien je fait une connexion automatique
            if($expected == $remember_token){
                session_start();
                $_SESSION['auth'] = $user;
                //si l'utilisateur correspond je refais un cookie en repassant en paramètre
                // le token qui est remember_token et lui réinitialise la date
                setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
            } else{
                //Si l'utilisateur ne correspond pas je détreuit le cookie comme avant
                setcookie('remember', null, -1);
            }
        }else{
            setcookie('remember', null, -1);
        }
    }
}

function flash() {
    if(isset($_SESSION['Flash'])) {
        extract($_SESSION['Flash']);
        unset($_SESSION['Flash']);
        return "<div class='alert alert-$type'>$message<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
    }
}

function setFlash($message, $type = 'success'){
    $_SESSION['Flash']['message'] = $message;
    $_SESSION['Flash']['type'] = $type;
    //return "<div class='alert alert-$type'>$message<button type='button' class='close' data-dismiss='alert' aria-label='Close'><span aria-hidden='true'>&times;</span></button></div>";
}

function input($id) {
    $value = isset($_POST[$id]) ? $_POST[$id] : '';
    return "<input type='text' name='$id' class='form-control' id='$id' value='$value' maxlength='255'>";
}

function textarea($id) {
    $value = isset($_POST[$id]) ? $_POST[$id] : '';
    return "<textarea type='text' name='$id' class='form-control ckeditor' id='$id'>$value</textarea>";
}

function select($id, $options = array()) {
    $return = "<select type='text' name='$id' class='form-control' id='$id'>";
    foreach ($options as $k => $v) {
        $selected = '';
        if(isset($_POST[$id]) && $k == $_POST[$id]) {
            $selected = 'selected="selected"';
        }
        $return .= "<option value='$k' $selected>$v</option>";
    }
    $return.= '</select>';
    return $return;
}


function resizeImage($file, $width, $height) {
    $info = pathinfo($file);
    $return = '';
    if($info['dirname'] != '.') {
        $return .= $info['dirname'] . '/';
    }
    $return .= $info['filename'] . "_$width" . "x$height." . $info['extension'];
    return $return;
}

?>
