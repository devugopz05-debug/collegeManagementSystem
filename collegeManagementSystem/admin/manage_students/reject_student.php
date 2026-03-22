<?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $id=$_GET['id'];
    $query=mysqli_query($conn,"update applications set rights='Rejected' where id='$id'");
    if($query){
        echo "<script>alert('Application Rejected');window.location.href='new_applications.php';</script>";
    }else{
        echo "<script>alert('Faild to reject');window.location.href='new_applications.php';</script>";
    }
    ?>