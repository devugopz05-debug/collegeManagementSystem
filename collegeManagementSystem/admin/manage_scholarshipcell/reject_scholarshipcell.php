<?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $id=$_GET['id'];
    $query=mysqli_query($conn,"update scholarshipcell set rights='Rejected' where id='$id'");
    if($query){
        echo "<script>alert('Rejected');window.location.href='scholarshipcell.php';</script>";
    }else{
        echo "<script>alert('Faild to reject');window.location.href='scholarshipcell.php';</script>";
    }
    ?>