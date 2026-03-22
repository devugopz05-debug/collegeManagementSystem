<?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $id=$_GET['id'];
    $query=mysqli_query($conn,"update scholarshipcell set rights='Scholarshipcell' where id='$id'");
    if($query){
        echo "<script>alert('Approved');window.location.href='scholarshipcell.php';</script>";
    }else{
        echo "<script>alert('Faild to approve');window.location.href='scholarshipcell.php';</script>";
    }
    ?>