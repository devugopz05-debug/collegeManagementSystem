<?php
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require '../../vendor/autoload.php';

$mail = new PHPMailer(true);
$hemail=$_GET['email'];


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
    $mail->Subject = 'Facility Booking Confirmation';
    $mail->Body    = 'Hello! Your facility booking has been successfully completed. Kindly wait for the approvel from the admin!';
    $mail->AltBody = 'Hello! Your facility booking has been successfully completed. Kindly wait for the approvel from the admin!';

    $mail->send();
    echo "<script>alert('Booking Success. Wait for admin approvel!');window.location.href='view_facility_bookings.php';</script>";
} catch (Exception $e) {
    echo "Email could not be sent. Mailer Error: {$mail->ErrorInfo}";
}
?>
