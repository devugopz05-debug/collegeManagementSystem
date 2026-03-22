<?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $id=$_GET['id'];
    $query=mysqli_query($conn,"update scholarship_pg set status='Scholarship Cell Approved' where id='$id'");
    if($query){
        echo "<script>alert('Scholarship Approved');window.location.href='scholarship_pg.php';</script>";
    }else{
        echo "<script>alert('Faild to approve');window.location.href='scholarship_pg.php';</script>";
    }
    ?>