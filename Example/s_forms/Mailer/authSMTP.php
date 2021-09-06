<?php 
use PHPMailer\PHPMailer\PHPMailer;

        require_once "PHPMailer/PHPMailer.php";
        require_once "PHPMailer/SMTP.php";
        require_once "PHPMailer/Exception.php";


        $mail = new PHPMailer(true);
        $mail->CharSet = $GLOBALS['CharSet'];
        $mail->Encoding = $GLOBALS['Encoding'];
        // SMTP SETTINGS
        $mail->SMTPDebug = $GLOBALS['SMTPDebug'];
        $mail->IsSMTP();
        $mail->SMTPSecure = $GLOBALS['SMTPSecure'];
        $mail->Host = $GLOBALS['Host'];
        $mail->SMTPAuth = $GLOBALS['SMTPAuth'];
        $mail->Username = $GLOBALS['Username']; // Gmail address which you want to use as SMTP server
        $mail->Password = $GLOBALS['Password']; // Gmail address Password
        $mail->Port = $GLOBALS['Port'];
?>