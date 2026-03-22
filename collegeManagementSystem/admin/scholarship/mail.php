<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$mail = new PHPMailer(true);
$hemail=$_GET['email'];
$path=$_GET['path'];
$status=$_GET['status'];


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
    $mail->setFrom('devugopz05@gmail.com', 'your name');
    $mail->addAddress($hemail, 'User');    

    // Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'Scholarship Application Confirmation';
    $mail->Body    = "Hello! Your scholarship application has been $status by Principal";
    $mail->AltBody = "Hello! Your scholarship application has been $status by Principal";

    $mail->send();
    echo "<script>alert('Application $status');window.location.href='$path';</script>";
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
