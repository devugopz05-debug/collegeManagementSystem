<?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $id=$_GET['id'];
    $email=$_GET['email'];
    $query=mysqli_query($conn,"update facility_bookings set status='Rejected' where id='$id'");
    if($query){
        echo "<script>window.location.href='mail.php?email=$email&status=Rejected';</script>";
    }else{
        echo "<script>alert('Faild to reject');window.location.href='view_facility_bookings.php';</script>";
    }
    ?>