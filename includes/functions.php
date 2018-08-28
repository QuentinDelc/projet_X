<?php
function debug($variable){
    echo '<pre>' . print_r($variable, true) . '</pre>';
}

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
    if(session_status() == PHP_SESSION_NONE){
        session_start();
    }
    if(isset($_COOKIE['remember']) && !isset($_SESSION['auth']) ){
        require_once 'db.php';
        if(!isset($pdo)){
            global $pdo;
        }
        $remember_token = $_COOKIE['remember'];
        $parts = explode('==', $remember_token);
        $user_id = $parts[0];
        $req = $pdo->prepare('SELECT * FROM user WHERE id = ?');
        $req->execute([$user_id]);
        $user = $req->fetch();
        if($user){
            $expected = $user_id . '==' . $user->remember_token . sha1($user_id . 'ratonlaveurs');
            if($expected == $remember_token){
                session_start();
                $_SESSION['auth'] = $user;
                setcookie('remember', $remember_token, time() + 60 * 60 * 24 * 7);
            } else{
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
    return "<input type='text' name='$id' class='form-control' id='$id' value='$value'>";
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
        $return .= "<option value='$id' $selected>$v</option>";
    }
    $return.= '</select>';
    return $return;
}

/*
 * FAILLE CSRF
 */


if(!isset($_SESSION['csrf'])) {
    $_SESSION['csrf'] = bin2hex(openssl_random_pseudo_bytes(6));
}
/*
echo "<pre>";
var_dump($_SESSION);
echo "</pre>";
die();
*/
function csrf() {
    return 'csrf=' . isset($_SESSION['csrf']);
}

function csrfInput() {
    return '<input type="hidden" value="' . $_SESSION['csrf'] . '" name="csrf">';
}

function checkCsrfDelete() {
    if(!isset($_GET['csrf']) || $_GET['csrf'] != isset($_SESSION['csrf'])) {
        header('Location:' . WEBROOT . 'csrf.php');
        die();
    }
}

function checkCsrf() {
    if(
        (isset($_POST['csrf']) && $_POST['csrf'] == $_SESSION['csrf']) ||
        (isset($_GET['csrf']) && $_GET['csrf'] == $_SESSION['csrf'])) {
        return true;
    }
    header('Location:' . WEBROOT . 'csrf.php');
    die();
}

?>