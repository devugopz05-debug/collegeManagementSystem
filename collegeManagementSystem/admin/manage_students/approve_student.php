<?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $id=$_GET['id'];
    $query=mysqli_query($conn,"update applications set rights='Student' where id='$id'");
    if($query){
        echo "<script>alert('Application Approved');window.location.href='new_applications.php';</script>";
    }else{
        echo "<script>alert('Faild to approve');window.location.href='new_applications.php';</script>";
    }
    ?>