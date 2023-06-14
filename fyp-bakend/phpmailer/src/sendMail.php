<?php
include 'DatabaseConfig.php';
include 'helper_functions/authentication_functions.php';
//PHPMailer-master

include 'PHPMailer.php';
include 'SMTP.php';
include 'Exception.php';
include 'OAuth.php';

function sendMailNexus($to, $html)
{
    $success = false;
    try {
        $FROMEMAIL  = 'pappuchhetri544@gmail.com';
        $TOEMAIL    = $to;
        $SMTPHOST   = "smtp.gmail.com";
        $SMTPPORT   = 587;
        $PASSWORD  = "twhcamreubaxnuhd";
        $SUBJECT    = "Change Password";
        // Create a new PHPMailer instance
        //without phpMailer
        $mail = new PHPMailer\PHPMailer\PHPMailer();
        $mail->isSMTP();
        $mail->Host = $SMTPHOST;
        $mail->SMTPAuth = true;
        $mail->Username = $FROMEMAIL;
        $mail->Password = $PASSWORD;
        $mail->SMTPSecure = 'tls';
        $mail->Port = $SMTPPORT;
        $mail->setFrom($FROMEMAIL, 'Nexus Nepal');
        $mail->addAddress($TOEMAIL, '');
        $mail->Subject = $SUBJECT;
        $mail->msgHTML($html);
        //send the message, check for errors
        if (!$mail->send()) {
            $success = false;
        } else {
            $success = true;
        }
    
    } catch (\Throwable $th) {
        $success = false;
    }
    return $success;
    
}
?>
