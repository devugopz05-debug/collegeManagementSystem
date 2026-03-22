<?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $id=$_GET['id'];
    $email=$_GET['email'];
    $query=mysqli_query($conn,"update facility_bookings set status='Approved' where id='$id'");
    if($query){
        echo "<script>window.location.href='mail.php?email=$email&status=Accepted';</script>";
    }else{
        echo "<script>alert('Faild to approve');window.location.href='view_facility_bookings.php';</script>";
    }
    ?>