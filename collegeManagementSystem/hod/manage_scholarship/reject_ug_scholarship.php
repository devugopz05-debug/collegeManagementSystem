<?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $id=$_GET['id'];
    $email=$_GET['email'];
    $path=$_GET['path'];
    $query=mysqli_query($conn,"update scholarship_ug set status='Hod Rejected' where id='$id'");
    if($query){
        echo "<script>window.location.href='mail.php?email=$email&path=$path';</script>";
    }else{
        echo "<script>alert('Faild to reject');window.location.href='scholarship_ug.php';</script>";
    }
    ?>