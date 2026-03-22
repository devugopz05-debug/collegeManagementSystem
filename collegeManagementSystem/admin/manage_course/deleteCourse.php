<?php
    $conn=mysqli_connect("localhost","root","","collegemanagementsystem");
    $id=$_GET['id'];
    $query=mysqli_query($conn,"delete from course where id='$id'");
    if($query){
        echo "<script>alert('Course Deleted');window.location.href='viewCourse.php';</script>";
    }else{
        echo "<script>alert('Failed to delete');window.location.href='viewCourse.php';</script>";
    }
    ?>