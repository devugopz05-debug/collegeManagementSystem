<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$mail = new PHPMailer(true);
$hemail=$_GET['email'];
$path=$_GET['path'];


try {
    //Server settings
    $mail->isSMTP();                                            
    $mail->Host       = 'smtp.gmail.com';                     
    $mail->SMTPAuth   = true;                                  
    $mail->Username   = 'devugopz05@gmail.com';               
    $mail->Password   = 'ghmkfzatahtuwtfu';
    $mail->SMTPSecure = 'tls';                                
    $mail->Port       = 587;                                  
 
    //Recipients
    $mail->setFrom('devugopz05@gmail.com', 'Your name');
    $mail->addAddress($hemail, 'User');    

    // Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'Scholarship Application Confirmation';
    $mail->Body    = "Hello! Your scholarship application has been rejected by Sholarship Cell";
    $mail->AltBody = "Hello! Your scholarship application has been rejected by Sholarship Cell";

    $mail->send();
    echo "<script>alert('Application rejected');window.location.href='$path';</script>";
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
