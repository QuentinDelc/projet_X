<?php require('templates/header.php');

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require "PHPMailer/PHPMailer.php";
require "PHPMailer/Exception.php";
require "PHPMailer/SMTP.php";
require 'PHPMailer.autoload.php';

if (isset($_POST['submit'])) {
    $name = $_POST['name'];
    $subject = $_POST['subject'];
    $email = $_POST['email'];
    $message = $_POST['message'];

    $mail = new PHPMailer(true);
    $mail->Host = "xxxxxxxxxxxx";
    $mail->isSMTP();
    $mail->SMTPAuth = true;
    $mail->Username = 'xxxxxxxxxxxxxxxxxx';
    $mail->Password = 'xxxxxxxxxxxxxxxxxxx';
    $mail->SMTPSecure = "ssl"; //TLS
    $mail->Port = 465; //587
    $mail->addAddress('address', 'name');
    /*$mail->addReplyTo($_POST['email'], $_POST['name']);*/
    $mail->setFrom($email, $name);
    $mail->Subject = $subject;
    $mail->isHTML(true);
    $mail->Body = $message;


    // Headers
    $headers  = 'MIME-Version: 1.0' . "\r\n";
    $headers .= 'Content-type: text/html; charset=utf-8' . "\r\n";
    $headers .= $email . "\r\n";
    $to = 'xxxxxxxxxxxxxxxxx';

    // Texte
    $body = '
		<html>
			<head>
				<title>Contact via le site internet</title>
			</head>

			<body>
				<p>Bonjour, un visiteur a pris contact via le formulaire du site.</p>
				<p>Voici les détails : </p>';

    $body .= "<p>Nom : " .$name. '</p>'. "\r\n";
    $body .= "<p>E-mail : " .$email. '</p>'. "\r\n";
    $body .= "<p>Sujet : " .$subject. '</p>'. "\r\n";
    $body .= "<p>Message : ". '</p><p>' .$message. '</p>';

    $body .=
        '</body>
		</html>';

    // Dossier d'upload des fichiers de traçage d'emails
    $upload_dir = $_SERVER['DOCUMENT_ROOT']. '/../mails/' .date('Y'). '/' .date('m'). '/';

    checkDirorCreate($_SERVER['DOCUMENT_ROOT']. '/../mails/');

    checkDirorCreate($_SERVER['DOCUMENT_ROOT']. '/../mails/' .date('Y'));

    checkDirorCreate($_SERVER['DOCUMENT_ROOT']. '/../mails/' .date('Y') .'/'. date('m'));

    $file_name  = '' .date('Y-m-d'). '_';
    $file_name .= date('H'). 'h' .date('i'). 'm' .date('s'). 's_' .wd_remove_accents($name);

    $file_content  = "Nom : " .$name. "\n";
    $file_content .= "E-mail : " .$email. "\n";
    $file_content .= "Sujet : " .$subject. "\n";
    $file_content .= "Message : " . "\n".$message;

    file_put_contents($upload_dir .$file_name. '.txt', $file_content);

    if ($mail->send()) {
        $resultok='<div class="alert alert-success">Votre message a bien été envoyé.</div>';
    } else {
        $resultko='<div class="alert alert-danger">Une erreur est survenu.</div>';
    }
}

function checkDirorCreate($path) {

    if (file_exists($path) == false)
    {
        mkdir($path);
    }
}

function wd_remove_accents($str, $charset='utf-8') {

    $str = htmlentities($str, ENT_NOQUOTES, $charset);

    $str = preg_replace('#&([A-za-z])(?:acute|cedil|caron|circ|grave|orn|ring|slash|th|tilde|uml);#', '\1', $str);
    $str = preg_replace('#&([A-za-z]{2})(?:lig);#', '\1', $str); // pour les ligatures e.g. '&oelig;'
    $str = preg_replace('#&[^;]+;#', '', $str); // supprime les autres caractères

    return $str;
}
?>

<div class="container">
    <h2 class="">Contactez nous</h2>
    <div class="validation-message">
        <?php echo $resultok; ?>
    </div>
    <div class="error-message">
        <?php echo $resultko; ?>
    </div>
    <div class="col-sm-6 formulaire">
        <form method="post" class="">
            <div class="form-group">
                <label for="name">Votre nom<img src="assets/img/icones/asterisk.png"></label>
                <input type="text" name="name" class="form-control" id="name" required>
            </div>
            <div class="form-group">
                <label for="email">Votre Adresse mail<img src="assets/img/icones/asterisk.png"></label>
                <input type="email" name="email" class="form-control" id="email" required>
            </div>
            <div class="form-group">
                <label for="subject">Sujet<img src="assets/img/icones/asterisk.png"></label>
                <input type="text" name="subject" class="form-control" id="subject" required>
            </div>
            <div class="form-group">
                <label for="message">Votre message<img src="assets/img/icones/asterisk.png"></label>
                <textarea id="message" name="message" class="form-control" rows="5" required></textarea>
            </div>
            <button type="submit" name="submit" class="btn btn-primary contact">Envoyez votre message</button>
        </form>
    </div>
</div>

<?php require('templates/footer.php'); ?>