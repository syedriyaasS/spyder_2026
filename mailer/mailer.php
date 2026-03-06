<?php
    use PHPMailer\PHPMailer\PHPMailer;
    require 'PHPMailer/src/Exception.php';
    require 'PHPMailer/src/PHPMailer.php';
    require 'PHPMailer/src/SMTP.php';
    $mail = new PHPMailer(true);
    try {
        //Server settings
        $mail->isSMTP();
        $mail->Host       = 'smtp.gmail.com';
        $mail->SMTPAuth   = true;
        $mail->Username   = 'syedriyaasS@gmail.com';
        $mail->Password   = 'mxcq zwhg cfco cxbm';
        $mail->SMTPSecure = 'tls';
        $mail->Port       = 587;
        //Recipients
        $mail->setFrom('syedriyaasS@gmail.com'); // sent email address
        $mail->addAddress('nkarthickkarthick785@gmail.com'); // receiver email address
        $mail->addAddress('syedriyaassyedriyaas@gmail.com');

        $mail->isHTML(true);
        $mail->Subject = 'Testing';
        $mail->Body = file_get_contents('./index.html');       
        
        // $mail->AltBody = 'This is the body in plain text for non-HTML mail clients';


        if(!$mail->send()){
            echo "faild";
        }else{
            echo "Success";
        }
    } catch (Exception $e) {
    }
?>