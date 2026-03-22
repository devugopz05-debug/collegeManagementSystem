<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$mail = new PHPMailer(true);
$hemail=$_GET['email'];
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
    $mail->setFrom('devugopz05@gmail.com', 'Your name');
    $mail->addAddress($hemail, 'User');    

    // Content
    $mail->isHTML(true);                                  
    $mail->Subject = 'Facility Booking Confirmation';
    $mail->Body    = "Hello! Your facility booking has been $status";
    $mail->AltBody = "Hello! Your facility booking has been $status";

    $mail->send();
    echo "<script>alert('Facility $status');window.location.href='view_facility_bookings.php';</script>";
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
